// Resizing both registration containers when an error is displayed

$("#registration-form").on("invalid.zf.abide", function(ev, el) {
	var elem = new Foundation.Equalizer($('.registration-panel'));
	elem.applyHeight();
})