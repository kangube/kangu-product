$("#create-availability-input").on("click", function() {
	$(".advert-availability-input-fields").append("<div class='small-12 large-4 columns'><label>Datum</label><input type='date' name='advert-availability-date[]'></div><div class='small-12 large-4 columns'><label>Begin-tijd</label><input type='time' name='advert-availability-start-time[]'></div><div class='small-12 large-4 columns'><label>Eind-tijd</label><input type='time' name='advert-availability-end-time[]'></div>");
	return false;
});