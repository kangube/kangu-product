// Opening and closing the mobile menu panel
$("#top-bar-mobile-menu-button").on("click", function() {
	if ($('.mobile-menu-panel').hasClass('animate-slide-left')) 
	{
		$('.mobile-menu-panel').removeClass('animate-slide-left');  
		$('.mobile-menu-panel').addClass('animate-slide-right');  
	} else {
		$('.mobile-menu-panel').addClass('animate-slide-right');  
	}

	if ($('.mobile-menu-background').hasClass('animate-fade-out')) 
	{
		$('.mobile-menu-background').removeClass('animate-fade-out');
		$('.mobile-menu-background').addClass('animate-fade-in');
		$('.mobile-menu-background').css("display", "block");
	} else {
		$('.mobile-menu-background').addClass('animate-fade-in');
		$('.mobile-menu-background').css("display", "block");  
	}

	$('html, body').css('overflow', 'hidden');
});

$("#mobile-menu-close-button").on("click", function() {
	if ($('.mobile-menu-panel').hasClass('animate-slide-right')) 
	{
		$('.mobile-menu-panel').removeClass('animate-slide-right');  
		$('.mobile-menu-panel').addClass('animate-slide-left');  
	}

	if ($('.mobile-menu-background').hasClass('animate-fade-in')) 
	{
		$('.mobile-menu-background').removeClass('animate-fade-in'); 
		$('.mobile-menu-background').addClass('animate-fade-out');
		$('.mobile-menu-background').css("display", "none");
	}

	$('html, body').css('overflow', 'auto');
});