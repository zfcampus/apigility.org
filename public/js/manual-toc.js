(function ($) {
    $('.toc ul').addClass('collapse');
    $('.toc li.current').parent().removeClass('collapse');
    $('.toc h2').on('click', function (e) {
        $(e.target).next('ul').toggleClass('collapse');
    });
})($);
