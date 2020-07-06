/*back to top start*/
degrees = 0;
degrees1 = 180;
//Check to see if the window is top if not then display button
$(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $('.back-to-top').fadeIn().css({'transform': 'rotate(' + degrees + 'deg)'});
    } else {
        $('.back-to-top').fadeOut().css({'transform': 'rotate(' + degrees1 + 'deg)'});
    }
});
//Click event to scroll to top
$('.back-to-top').click(function () {
    $('html, body').animate({scrollTop: 0}, 800);
    return false;
});
/*back to top end*/