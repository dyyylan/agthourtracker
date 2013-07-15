$(document).ready(function() {

	$(".jobnumber").change(function() {
		var id = $(this).attr('id');
		var date = id.split('_');
		date = date[1];
		var costCodeSelectId = '#costcode_' + date;

		// Hide the select box
		$('#costcode_' + date).hide();
		$('#loader_' + date).show();
		
		// Delete all cost codes from the select box
		$(costCodeSelectId).find('option').remove();

		if ($(this).val().length == 0) {
			$(costCodeSelectId).append('<option value="">Select a job number</option>').val('');
			$('#loader_' + date).hide();
			$('#costcode_' + date).show();
		} else {
			data = { job_number: $(this).val() }
			$.post('/api/v1/projects/cost_codes', data, function(response) {
				result = $.parseJSON(response);

				if (result.error) {
					alert('There was an error. Please try again.');
				} else {
					$(costCodeSelectId).append('<option value="">Select...</option>');
					for (i = 0; i < result.costCodes.length; i++) {
						costCode = result.costCodes[i].cost_code + " :: " + result.costCodes[i].description;
						$(costCodeSelectId).append('<option value="' + costCode + '">' + costCode + '</option>');
					}
				}

				$('#loader_' + date).hide();
				$('#costcode_' + date).show();
			});
		}			
	});

});