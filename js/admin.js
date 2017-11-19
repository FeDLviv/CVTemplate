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
        url = url.substr(0, url.lastIndexOf('/')) + '/ajax_delete_file';
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

    $.fn.editable.defaults.mode = 'inline';
    $.fn.editable.defaults.highlight = '#5BC0DE';
    $.fn.editableform.buttons = '<button type="submit" class="editable-submit btn btn-primary"><i class="fa fa-check"></i></button><button type="button" class="editable-cancel btn btn-outline-primary"><i class="fa fa-remove"></i></button>&nbsp';

    $('.language-ediatble').editable({
        params: function (params) {
            params.table = 'language';
            return params;
        },
        validate: validateLanguageFields
    });

    function validateLanguageFields(value) {
        if ($.trim(value) == '') {
            return 'This field is required';
        } else if ($.trim(value).length > 100) {
            return 'The maximum length is 100 characters';
        }
    }

    $('.language-ediatble').on('save', function (e, params) {
        $(this).closest('tr').find('td:eq(3)').text(params.response);
    });

    $('.language-ediatble-add').editable({
        validate: validateLanguageFields
    });

    $('#butAddLanguage').on('click', function () {
        var url = $(this).attr('data-ajax');
        $('.language-ediatble-add').editable('submit', {
            url: url
            //succes (add tr, clear data), error
        });
    });

    $('#tabLanguage button[data-url]').on('click', function (e) {
        deleteRow($(this));
    });

    function deleteRow(button) {
        var tr = button.closest('tr');
        var id = tr.find('td:first').text();
        var table = button.closest('table').attr('id').substring(3).toLowerCase();
        $.post(button.attr('data-url'), {
            'id': id,
            'table': table
        }, function (result) {
            if (result) {
                tr.remove();
            }
            $('#modalText').text(result ? 'Delete' : 'Error');
            $('#modalDialog').modal('show')
        });
    }

});