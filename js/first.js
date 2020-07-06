$(document).ready(function () {

    /*carousel start*/
    var owl = $("#owl-demo");
    owl.owlCarousel({
        items: 5, //10 items above 1000px browser width
        itemsDesktop: [1200, 4], //991-1200 5 items 4
        itemsDesktopSmall: [991, 3], // 767-991 items 3
        itemsTablet: [767, 2], //420-767 items 2
        itemsMobile: [420, 1] // 0-420  items 1
    });
    // autoplay event
    $(window).load(function () {
        owl.trigger('owl.play', 5000);
    });
    /*carousel end*/


    /*window scroll event start*/
    $(window).scroll(function () {
        if ($(this).scrollTop() > 120) {
            $(".row.pricing-row.text-capitalize").parent().addClass("animated hinge zoomIn");/*select parent div*/
        }
    });
    /*window scroll event end*/

});