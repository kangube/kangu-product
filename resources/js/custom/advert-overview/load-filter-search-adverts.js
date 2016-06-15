// Loading all adverts that match the search criteria

$(document).ready(function() {
	var filter = "";
	var school = "";
	var date = "";
	var spots = "";

	$(".advert-search-form").on("submit", function (e) {
		e.preventDefault();
		school = $('.search-region').val();
		date = $('.search-date').val();
		spots = $('.search-spots').val();

		$.ajax({
			type: 'post',
			dataType: 'html',
			url: '../php-assets/class.search.php',
			data: {school:school, date:date, spots:spots},
			cache: false,
			success: function(response) {
				$(".advert-overview-container").css("display", "none");
				$(".search-advert-overview-container" ).html(response);
			}
		});
	});

	$(".advert-search-form-mobile").on("submit", function (e) {
		e.preventDefault();
		school = $('.search-region-mobile').val();
		date = $('.search-date-mobile-alt').val();
		spots = $('.search-spots-mobile').val();

		$.ajax({
			type: 'post',
			dataType: 'html',
			url: '../php-assets/class.search.php',
			data: {school:school, date:date, spots:spots},
			cache: false,
			success: function(response) {
				$(".advert-overview-container").css("display", "none");
				$(".search-advert-overview-container" ).html(response);
			}
		});
	});

	$(".search-advert-overview-container").on("change", ".search-advert-overview-filter", function(e) {
		filter = $(this).val();

		$.ajax({
			type: 'post',
			dataType: 'html',
			url: '../php-assets/class.search.php',
			data: {chosenFilter:filter, filterSchool:school, filterDate:date, filterSpots:spots},
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
		var page = $(this).attr("data-page");

		if (!filter) {
			$(".search-advert-overview-container").load("../php-assets/class.search.php", {page:page, school:school, date:date, spots:spots});
		}
		else if (filter) {
			$(".search-advert-overview-container").load("../php-assets/class.search.php", {page:page, chosenFilter:filter, filterSchool:school, filterDate:date, filterSpots:spots});
		}
	});
});