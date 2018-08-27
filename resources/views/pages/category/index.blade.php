@extends('layout.master')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-8">
								<h3>Category List</h3>
								<span class="text-muted">This list is showing all Category of your Items</span>
							</div>
							<div class="col-sm-4 text-right">
								<button class="btn btn-info btn-lg" data-toggle="modal" data-target="#categoryModal" >
									Add Category
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card my-2">
			<div class="card-body">
				<table class="table table-borderless table-hover table-striped " id="categoryTable">
					<thead>
						<tr>
							<th>Name</th>
							<th>Type</th>
							<th>Description</th>
							<th>Item Count</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>

	<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="{{ route('category.store') }}" method="post" class="needs-validation" novalidate>
					{{ csrf_field() }}
					<div class="modal-header">
						<h5 class="modal-title">Create Category</h5>
						<button class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group has-danger">
							<label for="category_name">Category Name</label>
							<input type="text" name="category_name" id="category_name" class="form-control" required >
							<input type="hidden" name="id" class="form-control" >
						</div>
						<div class="form-group">
							<label for="type">Type</label>
							<select name="type" id="type" class="form-control"  required >
								<option selected disabled value=""> -- Select Type --</option>
								<option value="bike">Bike</option>
								<option value="motor">Motor</option>
							</select>
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" id="description" class="form-control"></textarea>
						</div>
					</div>
					<div class="modal-footer text-right">
						<button class="btn btn-info" type="submit">
							Submit Category
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop

@section('pageJs')
	<script>
		$(function(){
			$('#categoryModal').on('shown.bs.modal', function () {
				$('#categoryName').trigger('focus');
			});

			$('#categoryModal').on('hide.bs.modal', function () {
				$('form')[0].reset();
				$('[name="id"]').val('');
				$('#categoryTable').DataTable().destroy();
				getData();
			});

			getData();

			$('form').unbind('submit');
			$('form').bind('submit',function(){
				var thisForm = $(this);
				var formData = $(this).serialize();
				$.ajax({
					type	: 'post',
					url		: $(this).attr('action'),
					data	: formData
				}).done(function(returnData){
					if(returnData['type'] == 'success'){
						removeValidation(thisForm);
						swal('Good Job!',returnData['message'],returnData['type'],{
							button: "Aww yiss!",
						}).then((value) => {
							$('#categoryModal').modal('hide');
						});
					}
					else if(returnData['type'] == 'failed') {
						var errors = returnData['message'];
						applyValidation(thisForm,errors);
					}
				});
				return false;
			});

			
		});

		function getData(){
			$('#categoryTable').DataTable({
				processing : true,
				serverSide : true,
				responsive : true,
                searching : true,
				autoWidth : false,
				ajax : {
					url : '/category/api',
				}
			});
			
			
		}

		function deleteCategory(id){
			console.log(id);
			swal({
				title : 'Are you sure you want to delete this item?',
				icon : 'warning',
				buttons: ["Oh noez!", "Aww yiss!"],
				dangerMode: true,
			}).then((value) => {
				console.log(value);
				if(value){
					$.ajax({
						type: 'post',
						data: {_method: 'delete'},
						url : 'category/destroy/'+id,
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
					}).done(function(returnData){
						console.log(returnData);
						swal('Good Job!',returnData['message'],returnData['type'],{
							button: "Aww yiss!",
						}).then((value) => {
							$('#categoryTable').DataTable().destroy();
							getData();
						});
					});
				}
			});
		}

		function isNumeric(n) {
			return !isNaN(parseFloat(n)) && isFinite(n);
		}

		function editCategory(id){
			$.ajax({
				type : 'get',
				url : 'category/show/'+id+'/api',
			}).done(function(returnData){
				$('#categoryModal').modal();
				var parsedData = $.parseJSON(returnData);
				$.each(parsedData, function(key,val){
					$('[name="'+key+'"]').val(val);
				});
			});
		}
		
	</script>
@stop
