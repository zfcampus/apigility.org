(function ($) {
    $('.toc>ul').addClass('collapse');
    $('.toc li.current').closest('ul.collapse').removeClass('collapse');
    $('.toc h2').on('click', function (e) {
        $(e.target).next('ul').toggleClass('collapse');
    });
})($);
