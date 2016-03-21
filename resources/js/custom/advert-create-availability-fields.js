/*$("#create-availability-input").on("click", function() {
	$(".advert-availability-input-fields").append("<div class='small-12 large-4 columns'><label>Datum</label><input type='date' name='advert-availability-date[]'></div><div class='small-12 large-4 columns'><label>Begin-tijd</label><input type='time' name='advert-availability-start-time[]'></div><div class='small-12 large-4 columns'><label>Eind-tijd</label><input type='time' name='advert-availability-end-time[]'></div>");
	return false;
});*/

// Creating a new datepicker and setting all options
$('.availability-datepicker').datepicker({
    inline: true,
    dateFormat: 'yy-mm-dd',
    firstDay: 0,
    showOtherMonths: true,
    monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
    dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
    dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
    onSelect: function (date) {
        var selected = $(this).val();
        $(".advert-availability-input-fields").append("<div class='small-12 large-4 columns'><label>Datum</label><input type='date' name='advert-availability-date[]' value="+selected+"></div><div class='small-6 large-4 columns'><label>Begin-tijd</label><input type='time' name='advert-availability-start-time[]'></div><div class='small-6 large-4 columns'><label>Eind-tijd</label><input type='time' name='advert-availability-end-time[]'></div>");
        return false;
    },
    beforeShowDay: function (date) {
        var td = date.getDay();
        var ret = [(date.getDay() != 0 && date.getDay() != 6),'',(td != 'Za' && td != 'Zo')?'':'only on workday'];
        return ret;
    }
});

$('.availability-display').datepicker({
    inline: true,
    dateFormat: 'yy-mm-dd',
    firstDay: 0,
    showOtherMonths: true,
    monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
    dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
    dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
    beforeShowDay: function (date) {
        var td = date.getDay();
        var ret = [(date.getDay() != 0 && date.getDay() != 6),'',(td != 'Za' && td != 'Zo')?'':'only on workday'];
        return ret;
    }
});