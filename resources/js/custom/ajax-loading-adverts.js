$(document).ready(function() {
	$("#results" ).load( "../php-assets/class.pagination.php");

	$("#hide").click(function(e) {
		$("#results").hide();
		$("#searchresults").show();
	});
	
	$("#results").on( "click", ".pagination a", function (e) {
		e.preventDefault();
		$(".loading-div").show();
		var page = $(this).attr("data-page");
		$("#results").load("../php-assets/class.pagination.php",{"page":page}, function() {
			$(".loading-div").hide();
		});
	});
});