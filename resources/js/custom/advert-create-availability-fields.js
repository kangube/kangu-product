/*$('.availability-display').datepicker({
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
});*/