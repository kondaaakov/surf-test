let mainElement = $('main');

let footerHeight = $('.footer').outerHeight(true);

let headerHeight = $('.header').outerHeight(true);

let mainMargin = mainElement.outerHeight(true) - mainElement.outerHeight();
let mainPadding = mainElement.innerHeight() - mainElement.height();

console.log('Margin: ' + mainMargin);
console.log("Padding" + mainPadding)

let windowHeight = $(window).height();

if (mainElement.outerHeight(true) < windowHeight) {
    mainElement.css({
        'min-height': (windowHeight - headerHeight - footerHeight - mainMargin) + 'px'
    });
}