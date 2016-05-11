// Calendar die de datums toont waarop ik anderen geboekt heb
var user_id = $('#user-id').val();

if (typeof user_id !== 'undefined') {
	var RentedDate = function(className) {
		this.className = className;
	};

	$.ajaxSetup({
		async: false
	});

	var RentedDates = [];
	$.getJSON('renter-dates.php?id="'+user_id+'"', function(data) {
	    $.each(data, function(key, val) {
	        rented_date_item = val.booking_date_format.replace(/-/g, '/');
	        RentedDates[new Date(rented_date_item)] = new RentedDate("availability-date-item");
	    });
	});

	$('#renter-events').datepicker({
	    inline: true,
	    firstDay: 0,
	    showOtherMonths: true,
	    monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
	    dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
	    dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
	    beforeShowDay: function(date) {
	        var renting = RentedDates[date];

	        if (renting) {
	            return [true, renting.className];
	        }
	        else {
	            return [true, ''];
	        }
	    }
	});
}