$(function () {

    $('#menu-toggle').on('click', function (e) {
        e.preventDefault();
        var deg = ($('#wrapper').hasClass('active')) ? 0 : 180;
        $('#wrapper').toggleClass('active');
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
                var tmp = $.parseJSON(result);
                if (tmp.html !== null) {
                    form[0].reset();
                }
                $('#modalError').html(tmp.html);
                $('#modalText').text(tmp.complete ? 'Save' : 'Error');
                $('#modalDialog').modal('show')
            }
        });
    });

    $('#formSettings').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (result) {
                var tmp = $.parseJSON(result);
                if (tmp.html !== null) {
                    form[0].reset();
                } else {
                    var head = form.find('input[name="Head"]').val().trim();
                    $('#linkSite').find('a').html('<i class="fa fa-home fa-lg" aria-hidden="true"></i>&nbsp;' + head + '</i>');
                    $('#butCV_path').attr("disabled", !tmp.cv);
                    $('#butPhoto_path').attr("disabled", !tmp.photo);
                }
                $('#modalError').html(tmp.html);
                $('#modalText').text(tmp.complete ? 'Save' : 'Error');
                $('#modalDialog').modal('show')
            }
        });
    });

    $('#butCV_path').on('click', function (e) {
        ajaxDelete($(this), e);
    });

    $('#butPhoto_path').on('click', function (e) {
        ajaxDelete($(this), e);
    });

    function ajaxDelete(button, event) {
        event.preventDefault();
        var url = button.closest('form').attr('action');
        url = url.substr(0, url.lastIndexOf('/')) + '/ajax_deleteFile';
        var data = {
            name: button.attr('id').substring(3)
        };
        $.post(url, data, function (result) {
            if (result == true) {
                button.attr("disabled", true);
            }
            $('#modalText').text(result ? 'File is deleted' : 'File can not delete');
            $('#modalDialog').modal('show')
        });
    };

    $('#tabLanguage button').on('click', function (e) {
        var tr = $(this).closest('tr');
        var id = tr.find('td:first').text();
        var table = $(this).closest('table').attr('id').substring(3).toLowerCase();
        $.post($(this).attr('data-url'), {
            'id': id,
            'table': table
        }, function (result) {
            if (result) {
                tr.remove();
            }
            $('#modalText').text(result ? 'Delete' : 'Error');
            $('#modalDialog').modal('show')
        });
    });

    $.fn.editable.defaults.mode = 'inline';
    $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="fa fa-fw fa-check"></i></button>' + '<button type="button" class="btn editable-cancel"><i class="fa fa-fw fa-remove"></i></button>';

    $('.language-ediatble').editable({
        success: function (response, newValue) {
            alert(response);
        }
    });

});