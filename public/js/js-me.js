$(function(){
	$('.date').bootstrapMaterialDatePicker({ weekStart : 0, time: false, minDate : new Date() });

	
});
function countToValue(){
	$('.count').each(function () {
		$(this).prop('Counter',0).animate({
			Counter: $(this).text()
		}, {
			duration: 4000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			}
		});
	});
}
function applyValidation(thisForm,errors){

	thisForm.addClass('was-validated');
	thisForm.find('.invalid-feedback').remove();
	$.each(errors, function( index, value){
		var toAppend = '<div class="invalid-feedback">'+ value +'</div>';
		thisForm.find('[name="'+index+'"]').closest('.form-group').append(toAppend);
	});

}

function removeValidation(thisForm){
	thisForm.removeClass('was-validated');
}

function checkNumeric(number){
	return $.isNumeric(number) ? number : 0;
}

function numberFormat(number) {
	return numeral(number).format('0,0');
}