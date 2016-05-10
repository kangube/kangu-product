var schools = [];
$.getJSON('availability-schools.php', function(data) {
	$.each(data, function(key, val) {
	    schools.push(val["school_name"]);
	});
});

$(".search-region").autocomplete({
	source: schools
});

$(".search-region-mobile").autocomplete({
	source: schools
});