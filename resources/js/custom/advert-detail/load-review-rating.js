// Loading all of the reviews and corresponding ratings of an advert

$(document).ready(function() {
	var getUrlParameter = function getUrlParameter(sParam) {
	    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
	        sURLVariables = sPageURL.split('&'),
	        sParameterName,
	        i;

	    for (i = 0; i < sURLVariables.length; i++) {
	        sParameterName = sURLVariables[i].split('=');

	        if (sParameterName[0] === sParam) {
	            return sParameterName[1] === undefined ? true : sParameterName[1];
	        }
	    }
	};

	var advert_id = getUrlParameter('id');
	var user_id = $('.header-user-id').val();

	$(document).on('click', '.review-vote-button', function(e) { 
		e.preventDefault();
		var review_id = $(this).prev().val();
		var review_vote_button = $(this);

		$.ajax({
			type: 'post',
			dataType: 'html',
			url: '../php-assets/class.pagination-reviews.php',
			data: {UserId:user_id, ReviewId:review_id},
			cache: false,
			success: function(response) {
				review_vote_button.attr("disabled", true);
			}
		});
	});

	$("#reviews" ).load("../php-assets/class.pagination-reviews.php",{"id":advert_id, "user_id":user_id});

	$("#reviews").on("click", ".pagination a", function (e) {
		e.preventDefault();

		var page = $(this).attr("data-page");
		$("#reviews").load("../php-assets/class.pagination-reviews.php",{"page":page, "id":advert_id,  "user_id":user_id});
	});

	function RegulateMarginReviews() {
		var NumberOfReviews = $('.advert-detail-review-container').length;

		if (NumberOfReviews <= 2) {
			$('.advert-detail-review-container').css("margin-bottom", "0");
		}
	}

	RegulateMarginReviews();
});