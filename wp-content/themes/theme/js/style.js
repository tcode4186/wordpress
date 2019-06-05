$(document).ready(function () {
    // Slider owlCarousel
    $('.Class').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })

    // js Menu Mobile
    $('#mobile-menu-icon').click(function () {
        $('.show-menu-mobile').addClass('active')
    })
    $('.close-menu').click(function () {
        $('.show-menu-mobile').removeClass('active')
    })
    $('#nav-menu span').click(function () {
        $(this).parent().toggleClass('active');
        $(this).prev().slideToggle(400);
    })
})