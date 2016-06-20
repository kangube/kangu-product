$(document).on('click','.remove-availability-slot', function() { 
	$(this).parent('div').parent('div').remove();
	selectedDate = $(this).prev().prev().prev().prev('.selected-date').find('input[type="date"]').attr('value');

	selectedDateFormat = selectedDate.split("-");
	selectedDateDay = selectedDateFormat[2];
	selectedDateMonth = selectedDateFormat[1].replace(/^0+/, '');
	selectedDateYear = selectedDateFormat[0];

	selectedDateInArray = disabledDates.indexOf(selectedDate);
	if(selectedDateInArray != -1) {
		disabledDates.splice(selectedDateInArray, 1);
	}

	if ($(".advert-availability-month .advert-availability-dates").children('.availability-slot-container').length === 0) {
		$(".advert-availability-month[data-availability-format='"+selectedDateMonth+'-'+selectedDateYear+"']").remove();
		$(".advert-availability-slots").css("display", "none");
	}

	$('#availability-datepicker tbody td:has(a)').each(function(index) {
		var date = $.datepicker.formatDate('yy-mm-dd', new Date($(this).data('year'), $(this).data('month'), $(this).text()));
		if (date === selectedDate) {
			$(this).find('.ui-state-highlight').removeClass('ui-state-highlight');
		}
	});
});