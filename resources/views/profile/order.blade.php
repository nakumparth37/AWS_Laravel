@extends('layouts')

@section('content')
	<div class="container mt-5">
		<div class="row">
			<x-profile-sidebar />
			<div class="col-md-8">
				<h3>All Orders</h3>
				@if ($orders->isEmpty())
					<p>You have no orders yet.</p>
				@else
					@foreach ($orders as $order)
						<div class="card mb-3">
							<div class="card-header d-flex justify-content-between align-items-center">
								@php
									$colorArr = ['danger', 'warning', 'secondary', 'primary', 'success', 'danger'];
									$statusArr = [
										'Inprogress',
										'Pending',
										'shipped',
										'Out for Delivery',
										'Delivered',
										'Cancelled',
									];
									$orderStatus = $order->status;

									if (in_array($orderStatus, $statusArr)) {
										$index = array_search($orderStatus, $statusArr);
										$colorClass = $colorArr[$index];
									}
								@endphp
								<span>Order ID: {{ $order->id }} - <strong
										class="text-{{ $colorClass }} fw-bold text-capitalize">{{ $order->status }}</strong></span>
								<span>Date: {{ $order->created_at->format('d M Y') }}</span>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<h5>Shipping address:</h5>
										<p>{{ $order->address }}</p>
									</div>
									<div class="col-md-6">
										<h5>Payment:</h5>
										<p class="m-0">Transaction ID: {{ $order->transaction_id }}</p>
										<p>Payed Amount: <span class="text-success fw-bold">${{ $order->amount }}</span></p>
										@if ($order->status == 'Cancelled' && $order->payment->status == 'Refunded')
											<p class="fw-bold">Your payment has been refunded. The amount of  <span class="text-success">${{ number_format($order->payment->amount,2) }}</span> has been credited to your PayPal account.</p>
										@endif
									</div>
								</div>
								<hr>
								<div class="row">
									@foreach ($order->orderItems as $orderItem)
										<div class="col-6 mt-4">
											<div class="row mx-1 border border-1 rounded">
												<div class="col-3 p-0">
													<img class=' mx-2 ' src="{{ $orderItem->product->thumbnail }}"
														class="card-img-top" alt="{{ $orderItem->product->title }}"
														width="120"></img>
												</div>
												<div class="col-9 ps-5">
													<div>
														<hp class="card-title">{{ $orderItem->product->title }}</h5>
															<p class="text-muted mb-0">{{ $orderItem->product->brand }}</p>
															<span class="text-muted mb-0">MRP : </span>$
															{{ $orderItem->product->price }}
													</div>
													<div class='mt-1'>
														<p class="text-muted mb-0 fw-bold">Quantity:
															{{ $orderItem->quantity }}</p>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
								<div class="d-flex justify-content-end mt-2">
									@if ($order->status != 'Cancelled' && $order->status != 'Delivered')
										<form action="{{ route('order.cancel', ['order' => $order->id]) }}" method="POST">
											@csrf
											<button type="submit" class="btn btn-danger">Cancel Order</button>
										</form>
									@endif
								</div>
							</div>
						</div>
					@endforeach
				@endif
			</div>
		</div>
	</div>
@endsection
