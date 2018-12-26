{{-- 
<form action="">
	<div class="form-group">
		<label for=""></label>
		<input type="text" class="form-control">
	</div>
</form> --}}

{{ Form::open(array('url' => '')) }}
	<div class="form-group">
		<label for="category">Category</label>
		{{ Form::select('category',$categories, 'S',['class'=>'form-control','id' => 'category']) }}
	</div>
	<div class="form-group">
		<label for="name">Item Name</label>
		{{ Form::text('name','',['class'=>'form-control','id'=>'name']) }}
	</div>
	<div class="form-group">
		<label for="description">Description</label>
		{{ Form::textarea('description','',['class'=>'form-control','id'=>'description']) }}
	</div>
	<div class="form-group">
		<label for="" class="text-info">Item Details:</label>
	</div>
	<div class="form-group">
		<label for="price">Price</label>
	</div>

{{ Form::close() }}