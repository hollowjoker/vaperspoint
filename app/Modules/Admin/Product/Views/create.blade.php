
{{ Form::open(array('route' => 'products.create_item','files' => true,'method' => 'post','id' => 'addItemForm','class' => 'addItemForm')) }}
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="category">Category</label>
				{{ Form::select('category',$categories, 'S',['class'=>'form-control form-control-sm','id' => 'category']) }}
			</div>
			<div class="form-group">
				<label for="name">Item Name</label>
				{{ Form::text('name','',['class'=>'form-control form-control-sm','id'=>'name']) }}
			</div>
			<div class="form-group">
				<label for="description">Description</label>
				{{ Form::textarea('description','',['class'=>'form-control form-control-sm','id'=>'description']) }}
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<img src="images/placeholder.png" id="image" alt="" style="width: 100%; height: 300px;">
			</div>
			<div class="form-group">
				<label for="file" class="btn btn-dark-color text-white btn-sm">Upload Photo</label>
				{{ Form::file('file',['class'=>'form-control form-control-sm d-none','id'=>'file']) }}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="" class="text-info">Item Details:</label>
			</div>
		</div>
		<div class="col-4">
			<div class="form-group">
				<label for="quantity">QTY</label>
				<div class="input-group input-group-sm">
					{{ Form::number('quantity','',['class' => 'form-control form-control-sm','id' => 'quantity','placeholder' => '0']) }}
					<div class="input-group-append">
						<span class="input-group-text">pcs</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="form-group">
				<label for="size">Size</label>
				<div class="input-group input-group-sm">
					{{ Form::number('size','',['class' => 'form-control form-control-sm','id' => 'size','placeholder' => '0']) }}
					<div class="input-group-append">
						<span class="input-group-text">ml</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="form-group">
				<label for="nic">Nic Level</label>
				<div class="input-group input-group-sm">
					{{ Form::number('nic','',['class' => 'form-control form-control-sm','id' => 'nic','placeholder' => '0']) }}
					<div class="input-group-append">
						<span class="input-group-text">mg</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="form-group">
				<label for="srp">SRP</label>
				<div class="input-group input-group-sm">
					{{ Form::number('srp','',['class' => 'form-control form-control-sm','id' => 'srp','placeholder' => '0.00']) }}
					<div class="input-group-append">
						<span class="input-group-text">.00</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="form-group">
				<label for="rsp">RSP</label>
				<div class="input-group input-group-sm">
					{{ Form::number('rsp','',['class' => 'form-control form-control-sm','id' => 'rsp','placeholder' => '0.00']) }}
					<div class="input-group-append">
						<span class="input-group-text">.00</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="form-group">
				<label for="vip">VIP</label>
				<div class="input-group input-group-sm">
					{{ Form::number('vip','',['class' => 'form-control form-control-sm','id' => 'vip','placeholder' => '0.00']) }}
					<div class="input-group-append">
						<span class="input-group-text">.00</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="form-group text-right">
				<button class="btn btn-dark-color text-white btn-sm">
					Submit
				</button>
			</div>
		</div>
	</div>

{{ Form::close() }}

<script>
	var $image = $("#image");
	var URL = window.URL || window.webkitURL;
	var uploadedImageURL;
	var options = {
		aspectRatio: 4 / 2,
		crop: function (data) {

		},
		zoomable : false,
		scalable : false,
		movable : false,
		background : true,
		viewMode : 2,
		minContainerWidth: '100%',
		built : function(){
			$(this).cropper('getCroppedCanvas').toBlob(function (blob) {
				console.log("ENtereedddd");
				var formData = new FormData();
				formData.append('croppedImage', blob);
				console.log(formData);
			});
		}
	}

	$(function(){
		
		$image.cropper('destroy');
		setTimeout(function(){
			initCropper();
		},2000);

		setFormSubmit();

	})

	function initCropper() {
		$image.cropper(options);
		setUploadFunction();
	}

	function setUploadFunction() {
		var $inputImage = $('#file');

		$inputImage.change(function () {
			var files = this.files;
			var file;

			if (!$image.data('cropper')) {
				return;
			}

			if (files && files.length) {
				file = files[0];

				if (/^image\/\w+$/.test(file.type)) {
					uploadedImageName = file.name;
					uploadedImageType = file.type;

					if (uploadedImageURL) {
						URL.revokeObjectURL(uploadedImageURL);
					}

					uploadedImageURL = URL.createObjectURL(file);
					$image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
					// $inputImage.val('');
				}
			}
		});
	}

	function setFormSubmit() {
		
		$('.addItemForm').unbind('submit');
		$('.addItemForm').bind('submit',function(event){
			event.preventDefault();
			var $form = $(this);
			var newFormData = new FormData($form[0]);
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('[name="_token"]').attr('value')
				}
			});
			$.ajax({
				url : $form.attr('action'),
				data : newFormData,
				type : 'POST',
				cache: false,
				contentType: false,
				processData: false
			}).done(function(returnData){
				console.log(returnData);
			});

			return false;
		});
	}

</script>
