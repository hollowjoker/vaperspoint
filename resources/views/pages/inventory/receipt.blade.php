@extends('layout.master')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<div class="card border py-3">
					<div class="card-body">
						
						<div class="row">
							<div class="col-md-12">
								<h3>Official Receipt</h3>
								<p>Twin Lincoln Motor/Bike Shop</p>
								<hr>
								<h4>Checkout Details</h4>
							</div>
						</div>

						<div class="row">
							<div class="col-md-8">	
								<div class="form-group">
									<span class="clearfix">Sold To: <span class="text-default text-600 ml-3">{{ $transData[0]['customer_name'] }}</span></span>
									<span class="clearfix">Address: <span class="text-default text-600 ml-3">{{ $transData[0]['address'] }}</span></span> 
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<span class="clearfix">Date: <span class="text-default text-600 ml-3">{{ date('F d, Y',strtotime($transData[0]['date_trans'])) }}</span></span>
								</div>
							</div>
						</div>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Item Name</th>
									<th>QTY</th>
									<th>Price</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
								@foreach($transData as $each)
									<tr>
										<td> {{ $each['item_name'] }} </td>
										<td> {{ $each['qty'] }} </td>
										<td> {{ number_format($each['price'],2) }} </td>
										<td> {{ number_format($each['amount'],2) }} </td>
									</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<td colspan="3" class="text-right text-600">GRAND TOTAL</td>
									<td class="text-default"> <span class="h4">{{ number_format($grandTotal,2) }}</span> </td>
								</tr>
							</tfoot>
						</table>
						<p>Worker: <span class="text-600 text-default">{{ $transData[0]['worker'] }}</span></p>
						<p>Transacted By: <span class="text-600 text-default">{{ $transData[0]['transacted'] }}</span></p>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('pageJs')
	<script>
		$(function(){
			localStorage.clear();
		});
	</script>
@stop