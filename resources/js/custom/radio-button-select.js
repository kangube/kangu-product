// Changing the styling of the radio button when selected
$(".radio-button").on("click", function() {
	$('.radio-button').removeClass("radio-selected");
	$(this).addClass("radio-selected");
});