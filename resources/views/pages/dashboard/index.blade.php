@extends('layout.master')
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-3 col-sm-6 mb-3">
				<div class="card o-hidden h-100">
					<div class="card-body">
						<div class="card-body-icon">
							<i class="fa fa-fw fa-money"></i>
						</div>
						<div class="mr-5">Php. <span class="h3" id="monthlyIncome"></span></div>
					</div>
					<a class="card-footer bg-white text-dark clearfix small z-1" href="#">
						<span class="float-left">Monthly Income for {{ date('F') }}</span>
						<span class="float-right">
							<i class="fa fa-angle-right"></i>
						</span>
					</a>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 mb-3">
				<div class="card o-hidden h-100">
					<div class="card-body">
						<div class="card-body-icon">
							<i class="fa fa-fw fa-line-chart"></i>
						</div>
						<div class="mr-5">Php. <span class="h3" id="weeklyIncome"></span></div>
					</div>
					<a class="card-footer bg-white text-dark clearfix small z-1" href="#">
						<span class="float-left">Weekly Income for {{ date('M d,',strtotime('Monday this week')) }} - {{ date('d, Y', strtotime(date('Y-m-d',strtotime('Monday this week')).' + 6 day')) }} </span>
						<span class="float-right">
							<i class="fa fa-angle-right"></i>
						</span>
					</a>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 mb-3">
				<div class="card o-hidden h-100">
					<div class="card-body">
						<div class="card-body-icon">
							<i class="fa fa-fw fa-hand-o-down"></i>
						</div>
						<div class="mr-5">Php. <span class="h3" id="expenseCount"></span></div>
					</div>
					<a class="card-footer bg-white text-dark clearfix small z-1" href="#">
						<span class="float-left">Expense for {{ date('F') }} </span>
						<span class="float-right">
							<i class="fa fa-angle-right"></i>
						</span>
					</a>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 mb-3">
				<div class="card o-hidden h-100">
					<div class="card-body">
						<div class="card-body-icon">
							<i class="fa fa-fw fa-bicycle"></i>
						</div>
						<div class="mr-5"> <span class="h3" id="transactions"></span></div>
					</div>
					<a class="card-footer bg-white text-dark clearfix small z-1" href="#">
						<span class="float-left">Total Transaction</span>
						<span class="float-right">
							<i class="fa fa-angle-right"></i>
						</span>
					</a>
				</div>
			</div>
		</div>
		<div class="card mb-3 mt-3">
			<div class="card-header bg-white">
				<i class="fa fa-area-chart"></i> Area Chart Example</div>
			<div class="card-body">
				<canvas id="myAreaChart" width="100%" height="30"></canvas>
			</div>
			<div class="card-footer bg-white small text-muted">Updated yesterday at 11:59 PM</div>
		</div>
	</div>
@stop

@section('pageJs')
	<script src="{!! asset('sbadmin/js/sb-admin-charts.js') !!}"></script>
	<script>
		$(function(){
			
			getExpense();
			getMonthly();
			getWeekly();
			getTransactions();
			getIncomeYearly();
		});

		function getExpense() {
			$.ajax({
				url : '/dashboard/getExpense',
				type : 'get',
			}).done(function(returnData){
				var parsedData = $.parseJSON(returnData);
				$('#expenseCount').text(parsedData['expenseSum']);
				console.log(returnData);
			});
		}

		function getMonthly() {
			$.ajax({
				url : '/dashboard/getMonthlyIncome',
				type : 'get',
			}).done(function(result){
				var parsedData = $.parseJSON(result);
				$('#monthlyIncome').text(parsedData['monthlyIncomeSum']);
			});
		}

		function getWeekly() {
			$.ajax({
				url : '/dashboard/getWeeklyIncome',
				type : 'get'
			}).done(function(result){
				var parsedData = $.parseJSON(result);
				$('#weeklyIncome').text(parsedData['weeklyIncomeSum']);
			});
		}

		function getTransactions() {
			$.ajax({
				url : '/dashboard/getTransactions',
				type : 'get'
			}).done(function(result){
				console.log(result);
				var parsedData = $.parseJSON(result);
				$('#transactions').text(parsedData['transactionCount']);
			});
		}

		function getIncomeYearly() {
			$.ajax({
				url : '/dashboard/getIncomeYearly',
				type : 'get',
			}).done(function(result){
				var parsedData = $.parseJSON(result);

				console.log(parsedData);
				var ctx = document.getElementById("myAreaChart");
				var myLineChart = new Chart(ctx, {
					type: 'line',
					data: {
						labels: parsedData['months'],
						datasets: [{
							label: "Sessions",
							lineTension: 0.3,
							backgroundColor: "#f5a55840",
							borderColor: "#f5a558",
							pointRadius: 5,
							pointBackgroundColor: "#f5a558",
							pointBorderColor: "rgba(255,255,255,0.8)",
							pointHoverRadius: 5,
							pointHoverBackgroundColor: "rgba(2,117,216,1)",
							pointHitRadius: 20,
							pointBorderWidth: 2,
							data: parsedData['datas'],
						}],
					},
					options: {
						scales: {
						xAxes: [{
							time: {
							unit: 'date'
							},
							gridLines: {
							display: false
							},
							ticks: {
							maxTicksLimit: 7
							}
						}],
						yAxes: [{
							ticks: {
							min: 0,
							maxTicksLimit: 5
							},
							gridLines: {
							color: "rgba(0, 0, 0, .125)",
							}
						}],
						},
						legend: {
						display: false
						}
					}
				});
			});
		}
	</script>
@stop