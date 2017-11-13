$(function () {

    $('#menu-toggle').click('on', function (e) {
        e.preventDefault();
        var deg = ($('#sidebar').hasClass('active')) ? 0 : 180;
        $('#sidebar').toggleClass('active');
        $(this).find('i').animate({
            borderSpacing: deg
        }, {
            step: function (now, fx) {
                $(this).css('-webkit-transform', 'rotate(' + now + 'deg)');
                $(this).css('-moz-transform', 'rotate(' + now + 'deg)');
                $(this).css('transform', 'rotate(' + now + 'deg)');
            },
            duration: 300
        }, 'linear');
    });

});