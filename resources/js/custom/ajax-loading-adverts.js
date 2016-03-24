$(document).ready(function() {
	$("#results" ).load( "../php-assets/class.pagination.php");
	
	$("#results").on( "click", ".pagination a", function (e) {
		e.preventDefault();
		var page = $(this).attr("data-page");
		$("#results").load("../php-assets/class.pagination.php",{"page":page});
	});
});