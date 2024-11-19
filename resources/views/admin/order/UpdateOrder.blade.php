@extends('admin.dashboard')

@section('adminMainContant')
	<div class="admin-content-continuer">
		<div class="mx-5 mt-5">
			<div class="container">
				<h1>Order Details</h1>
				<form action="{{ route('admin.orders.update', $order) }}" method="POST">
					@csrf
					<div class="card mb-4">
						<div class="card-header">
							Order #{{ $order->id }} - {{ $order->created_at->format('D, M j, Y, g:i A') }}
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-4">
									<h5>Customer</h5>
									<p>{{ $order->user->name ." ".$order->user->surname }}</p>
									<p>{{ $order->user->email }}</p>
									<p>{{ $order->user->phone_number }}</p>
								</div>
								<div class="col-md-4">
									<h5>Shipping</h5>
									<p>Fargo express</p>
									<p>Card card</p>
									<p>Status: <span id="status" class="fw-bold">{{ $order->status }}</span>
									</p>
									<select name="status" class="form-control">
										<option value="Inprogress" @selected($order->status == 'Inprogress')>Inprogress</option>
										<option value="Pending" @selected($order->status == 'Pending')>Pending</option>
										<option value="Shipped" @selected($order->status == 'shipped')>Shipped</option>
										<option value="Out for Delivery" @selected($order->status == 'Out for Delivery')>Out for Delivery</option>
										<option value="Delivered"@selected($order->status == 'Delivered')>Delivered</option>
										<option value="Cancelled" @selected($order->status == 'Cancelled')>Cancelled</option>
									</select>
								</div>
								<div class="col-md-4">
									<h5>Deliver to</h5>
									<p>{{ $order->address }}</p>
								</div>
							</div>
							<h5 class="mt-4">Order Items</h5>
							<table class="table">
								<thead>
									<tr>
										<th>Product</th>
										<th>Quantity</th>
										<th>Unit Price</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($order->orderItems as $item)
										<tr>
											<td>
												<div class="col-12">
													<div class="row mx-1">
														<div class="col-3 p-0">
															<img class=' mx-2 ' src="{{ $item->product->thumbnail }}"
																class="card-img-top" alt="{{ $item->product->title }}"
																width="120"></img>
														</div>
														<div class="col-9 ps-5">
															<div>
																<hp class="card-title">{{ $item->product->title }}</h5>
																	<p class="text-muted mb-0">{{ $item->product->brand }}</p>
																	<span class="text-muted mb-0">MRP : </span>$
																	{{ $item->product->price }}
															</div>
															<div class='mt-1'>
																<p class="text-muted mb-0 fw-bold">Quantity:
																	{{ $item->quantity }}</p>
															</div>
														</div>
													</div>
												</div>
											</td>
											<td>
												<input type="number" name="order_items[{{ $item->id }}][quantity]"
													class="form-control" value="{{ $item->quantity }}" min="1">
												<input type="hidden" name="order_items[{{ $item->id }}][id]"
													value="{{ $item->id }}">
											</td>
											<td>${{ number_format($item->price, 2) }}</td>
											<td>${{ number_format($item->price * $item->quantity, 2) }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
							@php
							$colorArr = ['secondary', 'warning', 'success', 'danger'];
							$statusArr = [
								'Inprogress',
								'Pending',
								'Completed',
								'Refunded',
							];
							$orderStatus = $order->payment->status;

							if (in_array($orderStatus, $statusArr)) {
								$index = array_search($orderStatus, $statusArr);
								$colorClass = $colorArr[$index];
							}
						@endphp
							<h5 class="mt-4">Payment Info</h5>
							<p>Amount: ${{ number_format($order->payment->amount, 2) }}</p>
							<p>Status: <span class="text-{{ $colorClass }} fw-bold text-capitalize">{{ $order->payment->status }}</span></p>
							<div class="text-right">
								<button type="submit" class="btn btn-primary">Save</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		@endsection
