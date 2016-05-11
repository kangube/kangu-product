// Calendar die de datums toont waarop anderen mij geboekt hebben

var user_id = $('#user-id').val();

if (typeof user_id !== 'undefined') {
	var BookedDate = function(className) {
    	this.className = className;
	};

	var BookedDates = [];
	$.getJSON('booker-dates.php?id="'+user_id+'"', function(data) {
        $.each(data, function(key, val) {
            booked_date_item = val.booking_date_format.replace(/-/g, '/');
            BookedDates[new Date(booked_date_item)] = new BookedDate("availability-date-item");
        });
    });

	$('#booker-events').datepicker({
        inline: true,
	    firstDay: 0,
	    showOtherMonths: true,
	    monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
	    dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
	    dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
	    beforeShowDay: function(date) {
	        var booking = BookedDates[date];

	        if (booking) {
	            return [true, booking.className];
	        }
	        else {
	            return [true, ''];
	        }
	    }
	});
}