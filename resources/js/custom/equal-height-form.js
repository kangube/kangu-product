$("#registration-form").on("forminvalid.zf.abide", function(ev, el) {
	var elem = new Foundation.Equalizer($('.registration-panel'));
	elem.applyHeight();
})