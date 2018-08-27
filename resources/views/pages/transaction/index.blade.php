
@extends('layout.master')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-8">
								<h3>Transactions</h3>
								<span class="text-muted">Here are your list of transaction</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card my-2">
			<div class="card-body">
				<h3>List of Transactions</h3>
				<table class="table table-bordered table-striped" id="transactionTable">
					<thead>
						<tr>
							<td>Transaction No.</td>
							<td>Date</td>
							<td>Worker</td>
							<td>Transacted By</td>
							<td>Amount</td>
							<td>Action</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
@stop

@section('pageJs')
	<script>
		$(function(){
			
			getData();
		});

		function getData() {
			$('#transactionTable').DataTable({
				processing : true,
				serverSide : true,
				responsive : true,
				searching : true,
				autoWidth : false,
				order : [[ 0, "desc" ]],
				ajax : {
					url : '/transaction/api',
				}
			});
		}
	</script>
@stop