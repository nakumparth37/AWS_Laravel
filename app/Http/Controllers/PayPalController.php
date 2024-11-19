<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Payment;
use GuzzleHttp\Client;

class PayPalController extends Controller
{
	public function createTransaction()
	{
		return view('transaction');
	}

	public function processTransaction(Request $request)
	{

		$request->validate([
			'addressLine1' => "required",
			'addressLine2' => "nullable",
			'county' => 'required',
			'state' => 'required',
			'pinCode' => 'required|size:6',
			'city' => 'required',
		]);

		$provider = new PayPalClient;
		$provider->setApiCredentials(config('paypal'));
		$paypalToken = $provider->getAccessToken();
		$response = $provider->createOrder([
			"intent" => "CAPTURE",
			"application_context" => [
				"return_url" => route('successTransaction'),
				"cancel_url" => route('cancelTransaction'),
			],
			"purchase_units" => [
				0 => [
					"amount" => [
						"currency_code" => "USD",
						"value" => $request->productData
					],
					"shipping" => [
						"address" => [
							"address_line_1" => $request->addressLine1,
							"address_line_2" => $request->addressLine2 ? '' : $request->addressLine2,
							"admin_area_1" => $request->city,
							"admin_area_2" => $request->city,
							"postal_code" => $request->pinCode,
							"country_code" => 'US',
						]
					]
				]
			],
			"payer" => [
				"name" => [
					"given_name" => Auth::user()->name,
					"surname" => Auth::user()->surname
				],
				"email_address" => Auth::user()->email,
					"phone" => [
						"phone_type" => "MOBILE",
						"phone_number" => [
							 "national_number" => (int)Auth::user()->phone_number
						]
				],
				"address" => [
					"address_line_1" => $request->addressLine1,
					"address_line_2" => $request->addressLine2 ? '' : $request->addressLine2,
					"admin_area_1" => $request->city,
					"admin_area_2" => $request->city,
					"postal_code" => $request->pinCode,
					"country_code" => 'US',
				]
			]
		]);
		if (isset($response['id']) && $response['id'] != null) {
			// redirect to approve href
			foreach ($response['links'] as $links) {
				if ($links['rel'] == 'approve') {
					return redirect()->away($links['href']);
				}
			}
			return redirect()
				->route('dashboard')
				->with('error', 'Something went wrong.');
		} else {
			return redirect()
				->route('dashboard')
				->with('error', $response['message'] ?? 'Something went wrong.');
		}
	}

	public function successTransaction(Request $request)
	{
		$provider = new PayPalClient;
		$provider->setApiCredentials(config('paypal'));
		$provider->getAccessToken();
		$response = $provider->capturePaymentOrder($request['token']);
		$refundUrl = $response['purchase_units'][0]['payments']['captures'][0]['links']['1']['href'];
		// dd($response);
		if (isset($response['status']) && $response['status'] == 'COMPLETED') {
			DB::beginTransaction();
			try {
				$payment = Payment::create([
					'user_id' =>  Auth::id(),
					'payment_id' => $response['id'],
					'capture_id' => $response['purchase_units'][0]['payments']['captures'][0]['id'],
					'payer_id' => $response['payer']['payer_id'],
					'amount' => number_format(floatval($response['purchase_units'][0]['payments']['captures'][0]['amount']['value']),2,'.',''),
					'currency' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'],
					'refund_url' => $refundUrl,
				]);
                $payment->status = 'Completed';
				if ($payment) {
                    $payment->save();
					$cartItems = Auth::user()->carts()->with('product')->get();
					$uesAddressData = $response['payer']['address'];
					$address = null;
					foreach ($uesAddressData as $key => $value) {
						if ($key != 'country_code' && $key != 'postal_code') {
							$address .= $value . ",";
						}elseif($key != 'country_code'){
							$address .= $value ;
						}
					}
					$order = Order::create([
						'user_id' => Auth::id(),
						'transaction_id' => $response['id'],
						'status' => 'Pending',
						'content' => intval(Auth::user()->phone_number),
						'address'=> $address,
						'amount' => number_format(floatval($response['purchase_units'][0]['payments']['captures'][0]['amount']['value']),2,'.',''),
						'payment_id' => $payment->id,
					]);
					foreach ($cartItems as $cartItem) {
						$product = Product::find($cartItem->product_id);
						if ($product->reduceStock($cartItem->quantity)) {
							OrderItem::create([
								'order_id' => $order->id,
								'product_id' => $cartItem->product_id,
								'quantity' => $cartItem->quantity,
								'price' => $cartItem->product->price,
							]);
						}else{
							DB::rollBack();
							return redirect()->route('cart.index')->with('error', 'Not enough stock for ' . $product->title);
						}
					}
					DB::commit();
					Cart::where('user_id', Auth::id())->delete();
					return redirect()
						->route('dashboard')
						->with('success', 'Payment successful. Your order has been placed.');
				}else{
					DB::rollBack();
					$refundData = self::refundPayment($refundUrl);
					return redirect()->route('cart.index')->with('info', "Failed to place order. Please try again.and $refundData");
				}
			} catch (\Exception $e) {
				DB::rollBack();
				$refundData = self::refundPayment($refundUrl);
				return redirect()->route('cart.index')->with('info', "Failed to place order. Please try again. and $refundData");
			}

		} else {
			return redirect()
				->route('dashboard')
				->with('error', $response['message'] ?? 'Something went wrong.');
		}
	}

	public function cancelTransaction(Request $request)
	{
		return redirect()
			->route('dashboard')
			->with('error', $response['message'] ?? 'You have canceled the transaction.');
	}

	public function refundPayment($refundUrl)
	{
		if ($refundUrl) {
			$client = new Client();
			try {
				$response = $client->post($refundUrl, [
					'headers' => [
						'Content-Type' => 'application/json',
						'Authorization' => 'Bearer ' . $this->getAccessToken(),
					],
				]);
				$responseBody = json_decode($response->getBody(), true);

				if ($response->getStatusCode() == 201) {

					return "Payment refunded please check in you paypal account";
				} else {
					return 'Failed to refund the payment.';
				}
			} catch (\Exception $e) {
				return $e->getMessage();
			}
		} else {
			return 'Refund URL not available.';
		}
	}

	private function getAccessToken()
	{
		// Get a new access token from PayPal
		$provider = new PayPalClient;
		$provider->setApiCredentials(config('paypal'));
		$accessToken = $provider->getAccessToken();
		return $accessToken['access_token'];
	}
}
