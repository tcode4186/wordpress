$(document).ready(function () {
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