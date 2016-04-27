$(document).ready(function() {
	var filter = "";

	$(".advert-search-form, .advert-search-form-mobile").on("submit", function (e) {
		e.preventDefault();
		var school = $('.search-region').val();
		var price = $('.search-price').val();
		var spots = $('.search-spots').val();

		$.ajax({
			type: 'post',
			dataType: 'html',
			url: '../php-assets/class.search.php',
			data: {school:school, price:price, spots:spots},
			cache: false,
			success: function(response) {
				$(".advert-overview-container").css("display", "none");
				$(".search-advert-overview-container" ).html(response);
			}
		});
	});

	$(".search-advert-overview-container").on("change", ".search-advert-overview-filter", function(e) {
		filter = $(this).val();
		var school = $('.search-region').val();
		var price = $('.search-price').val();
		var spots = $('.search-spots').val();

		$.ajax({
			type: 'post',
			dataType: 'html',
			url: '../php-assets/class.search.php',
			data: {chosenFilter:filter, filterSchool:school, filterPrice:price, filterSpots:spots},
			cache: false,
			success: function(response) {
				$(".advert-overview-container").css("display", "none");
				$(".search-advert-overview-container").html(response);
				$(".search-advert-overview-filter").val(filter);
			}
		});
	});

	$(".search-advert-overview-container").on("click", ".pagination a", function (e) {
		e.preventDefault();
		var school = $('.search-region').val();
		var price = $('.search-price').val();
		var spots = $('.search-spots').val();
		var page = $(this).attr("data-page");

		if (!filter) {
			$(".search-advert-overview-container").load("../php-assets/class.search.php", {page:page, school:school, price:price, spots:spots});
		}
		else if (filter) {
    		//alert("chosen filter: "+filter+", school: "+school+", price: "+price+", spots: "+spots+".");
			$(".search-advert-overview-container").load("../php-assets/class.search.php", {page:page, chosenFilter:filter, filterSchool:school, filterPrice:price, filterSpots:spots});
		}
	});
});