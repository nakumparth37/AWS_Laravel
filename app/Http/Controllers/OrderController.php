<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Payment;
use GuzzleHttp\Client;
use DataTables;
use Illuminate\Support\Str;

class OrderController extends Controller
{

	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$user = Auth::user();
		if ($user->orders()->exists()) {
			$orders = Auth::user()->orders()->with(['orderItems.product', 'payment'])->get();
		}else{
			$orders = collect();
		}
		return view('profile.order', compact('orders'));
	}

	public function refundOrderPayment(Order $order)
	{
		$payment = Payment::findOrFail($order->payment_id);
		$refundUrl = $payment->refund_url;
		$refoundAmount = $payment->amount;
		$provider = new PayPalClient;
		$provider->setApiCredentials(config('paypal'));
		$accessToken = $provider->getAccessToken();


		$client = new Client();
		$requestData = [
			'amount' => [
				'value' => $refoundAmount,
				'currency_code' => 'USD' // adjust currency code as per your requirements
			]
		];


		try {
			$response = $client->post($refundUrl, [
				'headers' => [
					'Content-Type' => 'application/json',
					'Authorization' => 'Bearer ' . $accessToken['access_token'],
				],
				'json' => $requestData,
			]);

			$responseBody = json_decode($response->getBody(), true);
			if ($response->getStatusCode() == 201) {
                $payment->status = 'Refunded';
                $payment->save();
                return true;
			} else {
                return false;
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}

	}

	public function orderListing(Request $request)
	{

		if ($request->ajax() ) {
			$orders = Order::select('id','transaction_id','user_id','status','content','address','payment_id','amount')->get()->toArray();
			foreach ($orders as $key => &$order) {
				$order['address'] = Str::words($order['address'], 7, '...');
			}
			return Datatables::of($orders)
					->addIndexColumn()
					->addColumn('action', function($row){
						$btn = "
							<a href = '". route('admin.orders.show', ['order' => $row['id']]) ."' class='edit btn  btn-sm m-1' ><i class='fa-solid fa-pen text-warning'></i>
							</a><button class='edit btn btn-sm m-1 deleteOrder'  id='". $row['id'] ."'><i class='fa-solid fa-trash text-danger deleteProduct'></i></button>
						";
						return $btn;
					})
					->rawColumns(['action'])
					->make(true);
		}
		return view('admin.order.OrderListing');
	}

	public function show(Order $order)
	{

		$order->load('orderItems.product', 'payment','user');
		// dd($order->status);
		return view('admin.order.UpdateOrder', compact('order'));
	}

	public function deleteOrder(Request $request, $id)
	{
		try {
			$order = Order::find($id);
			if ($order) {
				$order->delete();
				return response()->json([
					'status' => true,
					'Message' => "Order is Deleted Successfully",
				], 200);
			}
			return response()->json([
				'Message' => "order not Found",
			], 404);
		} catch (Exception $ex) {
			return response()->json([
				'status' => false,
				'error' =>  $ex->getMessage(),
			], 500);
		}
	}

	public function update(Request $request, Order $order)
	{
		// Validate the request data
		$request->validate([
			'status' => 'required|string',
			'order_items' => 'required|array',
			'order_items.*.quantity' => 'required|integer|min:1',
		]);
        $isAmountRefunded = false;
        if ($request->input('status') == 'Cancelled') {
            $paymentRefund = self::refundOrderPayment($order);
            if ($paymentRefund === true) {
                $order->status = $request->input('status');
                $order->save();
                $isAmountRefunded = true;
            }else{
                return redirect()->back()->with('error','Failed to refund the payment.');
            }
        }elseif ($request->input('status') && !($request->input('status') == 'Cancelled')) {
            $order->status = $request->input('status');
            $order->save();
        }


		foreach ($request->input('order_items') as $itemData) {
			$orderItem = $order->orderItems()->find($itemData['id']);
			if ($orderItem) {
				$orderItem->quantity = $itemData['quantity'];
				$orderItem->save();
			}
		}
        $messages = $isAmountRefunded ? "Order updated successfully and refund the payment to customer paypal account of $". $order->amount : 'Order updated successfully';
		return redirect()
                ->route('admin.orders.show', $order)
                ->with('success', $messages);
	}

    public function cancelOrder(Order $order)
    {
        $cancelOrder = self::refundOrderPayment($order);
        $payment = Payment::findOrFail($order->payment_id);
        $refundUrl = $payment->refund_url;
        $refoundAmount = $order->amount;
        if ($refundUrl) {
            if ($cancelOrder === true) {
                $order->update(['status' => 'Cancelled']);
                return redirect()->back()->with('success',"Your order has been canceled successfully and Payment refunded of $refoundAmount");
            }else{
                return redirect()->back()->with('error','Failed to refund the payment.');
            }
        }else{
            return redirect()->back()->with('error','Refund URL not available.');
        }
    }


}
