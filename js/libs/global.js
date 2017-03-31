
/* Header
------------------------------------*/
var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('.header-wraper').outerHeight();

$(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    var st = $(this).scrollTop();
    
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
        return;
    
    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        $('.header-wrapper').removeClass('header-down').addClass('header-up');
    } else {
        // Scroll Up
        if(st + $(window).height() < $(document).height()) {
            $('.header-wrapper').removeClass('header-up').addClass('header-down');
        }
    }
    
    lastScrollTop = st;
}


/* Menu Button
------------------------------------*/

$('.menu-button').on('click', function(event) {
    event.preventDefault();
    $('.bar').toggleClass('animate');
    $('.main-menu').toggleClass('open');
});




/* Search Button
------------------------------------*/

$('.search-button').on('click', function(event) {
    event.preventDefault();
    $('.search-albums').toggleClass('open');
});


/* Grid/List View
------------------------------------*/

$('.view-button').on('click', function(event) {
    event.preventDefault();
    $(this).toggleClass('change-view');
    $('.album-entry').toggleClass('change-view');
});
