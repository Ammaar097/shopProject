$(document).ready(function () {
    const url = window.location.href.split('/')
    const href = url[url.length - 1]
    $('.bar-link').each(function (index) {
        if ($(this).attr('href') === href) {
            $(this).css("color", "#ffffff")
        }
    })
});