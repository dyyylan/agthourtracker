$(document).ready(function() {

	$('#pay_date').datepicker({
		format: 'yyyy-mm-dd'
	});

	$('.show-hours').on('click', function() {
		var userId = $(this).data('userid');
		
		$('#hours-user-' + userId).toggle('slow');
	});

});