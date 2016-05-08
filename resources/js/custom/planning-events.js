$(document).ready(function() {
	var getUrlParameter = function getUrlParameter(sParam) {
	    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
	        sURLVariables = sPageURL.split('&'),
	        sParameterName,
	        i;
​
	    for (i = 0; i < sURLVariables.length; i++) {
	        sParameterName = sURLVariables[i].split('=');
​
	        if (sParameterName[0] === sParam) {
	            return sParameterName[1] === undefined ? true : sParameterName[1];
	        }
	    }
	};
​
	var booker_id = getUrlParameter('id');
​
	if (typeof booker_id !== 'undefined') {
        var Event = function(className) {
	    	this.className = className;
		};
​
		var events = [];
		$.getJSON('booker-dates.php?id="'+booker_id+'"', function(data) {
            $.each(data, function(key, val) {
                booker_date_item = val.booking_date_format.replace(/-/g, '/');
                events[new Date(booker_date_item)] = new Event("booker-date-item");
            });
        });
​
		$('.booker-events').multiDatesPicker({
	        inline: true,
		    firstDay: 0,
		    showOtherMonths: true,
		    monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
		    dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
		    dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
		    beforeShowDay: function(date) {
		        var event = events[date];
​
		        if (event) {
		            return [true, event.className];
		        }
		        else {
		            return [true, ''];
		        }
		    }
		});
	}
});

$(document).ready(function() {
	var getUrlParameter = function getUrlParameter(sParam) {
	    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
	        sURLVariables = sPageURL.split('&'),
	        sParameterName,
	        i;
​
	    for (i = 0; i < sURLVariables.length; i++) {
	        sParameterName = sURLVariables[i].split('=');
​
	        if (sParameterName[0] === sParam) {
	            return sParameterName[1] === undefined ? true : sParameterName[1];
	        }
	    }
	};
​
	var renter_id = getUrlParameter('id');
​
	if (typeof renter_id !== 'undefined') {
        var Event = function(className) {
	    	this.className = className;
		};
​
		var events = [];
		$.getJSON('renter-dates.php?id="'+renter_id+'"', function(data) {
            $.each(data, function(key, val) {
                renter_date_item = val.booking_date_format.replace(/-/g, '/');
                events[new Date(renter_date_item)] = new Event("renter-date-item");
            });
        });
​
		$('.renter-events').multiDatesPicker({
	        inline: true,
		    firstDay: 0,
		    showOtherMonths: true,
		    monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
		    dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
		    dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
		    beforeShowDay: function(date) {
		        var event = events[date];
​
		        if (event) {
		            return [true, event.className];
		        }
		        else {
		            return [true, ''];
		        }
		    }
		});
	}
});