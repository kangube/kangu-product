$.getJSON('../pages/availability-schools.php', function(data) {
	$('.advert-school-input').append('<option value="" selected="selected">Basisschool van jouw kind</option>');

	$.each(data, function(key, val) {
		var school_name = "";
		school_name = val["school_name"].replace(/ /g, '&#32;');
	    $('.advert-school-input').append('<option value='+school_name+'>'+val["school_name"]+'</option>');
	});
});