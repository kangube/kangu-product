// Script used to add a new child to the advert-create

$(document).ready(function() {
	$(".advert-add-child-button").on("click", function() {
		$(".number-children-container").append("<div class='form-icon-input-field'><div class='form-icon-input-container'><span class='form-icon' data-icon='o'></span><input class='form-input' type='text' name='advert-child-name[]' placeholder='Voor- en achternaam van jouw kind' required></div></div><div class='form-icon-input-field'><div class='form-icon-input-container'><span class='form-icon' data-icon='e'></span><input class='form-input' type='text' name='advert-child-class[]' placeholder='Klasnummer van jouw kind' required></div></div>");
	});
});