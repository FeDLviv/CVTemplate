$(function () {

    $('#menu-toggle').on('click', function (e) {
        e.preventDefault();
        var deg = ($('#sidebar').hasClass('active')) ? 0 : 180;
        $('#sidebar').toggleClass('active');
        $(this).find('i').stop(true, true).animate({
            borderSpacing: deg
        }, {
            step: function (now, fx) {
                $(this).css('-webkit-transform', 'rotate(' + now + 'deg)');
                $(this).css('-moz-transform', 'rotate(' + now + 'deg)');
                $(this).css('transform', 'rotate(' + now + 'deg)');
            },
            duration: 300
        }, 'ease');
    });

    $('#formContact').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function (result) {
                $tmp = $.parseJSON(result);
                if ($tmp.html !== null) {
                    form[0].reset();
                }
                $('#modalError').html($tmp.html);
                $('#modalText').text($tmp.complete ? 'Save' : 'Error');
                $('#modalDialog').modal('show')
            }
        });
    });

});