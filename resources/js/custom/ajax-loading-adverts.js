$(document).ready(function() {
	$("#results" ).load( "../php-assets/class.pagination.php");

	$("#hide").click(function(e) {
		$("#results").hide();
		$("#searchresults").show();
	});
	
	$("#results").on( "click", ".pagination a", function (e) {
		e.preventDefault();
		var page = $(this).attr("data-page");
		$("#results").load("../php-assets/class.pagination.php",{"page":page});
	});
});