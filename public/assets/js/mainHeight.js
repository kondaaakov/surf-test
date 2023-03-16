let mainElement = $('main');

let footerHeight = $('.footer').outerHeight(true);
let headerHeight = $('.header').outerHeight(true);
let mainMargin = mainElement.outerHeight(true) - mainElement.outerHeight();
let windowHeight = $(window).height();
if (mainElement.outerHeight(true) < windowHeight) {
    mainElement.css({
        'height': (windowHeight - headerHeight - footerHeight - mainMargin) + 'px'
    });
}