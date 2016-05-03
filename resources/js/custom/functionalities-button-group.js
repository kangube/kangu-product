// Opening and closing of the appropiate functionality containers
$(".functionalities-button-group .button:first-child").on("click", function() {
    $('.functionalities-button-group .button:last-child').removeClass("selected");
    $('.functionalities-button-group .button:first-child').addClass("selected");
    $('.functionalities-offer-container').css("display", "none");
    $('.functionalities-search-container').css("display", "block");
    $('.functionalities-search-container').addClass("animated fadeInLeft");
});

$(".functionalities-button-group .button:last-child").on("click", function() {
    $('.functionalities-button-group .button:first-child').removeClass("selected");
    $('.functionalities-button-group .button:last-child').addClass("selected");
    $('.functionalities-search-container').css("display", "none");
    $('.functionalities-offer-container').css("display", "block");
    $('.functionalities-offer-container').addClass("animated fadeInRight");
});