$(document).ready(function() {
	// Input datepicker for large screens and up

	$(".search-date").datepicker({
		inline: false,
		dateFormat: 'yy-mm-dd',
		firstDay: 0,
	    showOtherMonths: true,
	    monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
	    dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
	    dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za']
	});

	// Input datepicker for medium screens and down
	
	$(".search-date-mobile").datepicker({
		inline: true,
		dateFormat: 'yy-mm-dd',
		firstDay: 0,
	    showOtherMonths: true,
	    monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
	    dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
	    dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
	    altFormat: "yy-mm-dd",
		altField: ".search-date-mobile-alt"
	});
});