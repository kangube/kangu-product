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
	var advert_id = getUrlParameter('id');
​
	if (typeof advert_id !== 'undefined') {
        var Event = function(className) {
	    	this.className = className;
		};
​
		var events = [];
		$.getJSON('planning-dates.php?id="'+advert_id+'"', function(data) {
            $.each(data, function(key, val) {
                planning_date_item = val.planning_date.replace(/-/g, '/');
                events[new Date(planning_date_item)] = new Event("planning-date-item");
            });
        });
​
		$('.planning-events').datepicker({
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