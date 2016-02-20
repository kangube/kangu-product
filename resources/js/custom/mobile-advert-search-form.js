// Opening and closing the mobile search form
$("#mobile-search-form-button").on("click", function() {
	if ($('.mobile-search-form-container').hasClass('animate-fade-out')) 
	{
		$('.mobile-search-form-container').removeClass('animate-fade-out');  
		$('.mobile-search-form-container').addClass('animate-fade-in');
		$('.mobile-search-form-container').css("display", "block");
	} else {
		$('.mobile-search-form-container').addClass('animate-fade-in');
		$('.mobile-search-form-container').css("display", "block");
	}

	$('html, body').css('overflow', 'hidden');
});

$("#search-form-close-button").on("click", function() {
	if ($('.mobile-search-form-container').hasClass('animate-fade-in')) 
	{
		$('.mobile-search-form-container').removeClass('animate-fade-in');  
		$('.mobile-search-form-container').addClass('animate-fade-out');
		$('.mobile-search-form-container').css("display", "none"); 
	}

	$('html, body').css('overflow', 'auto');
});