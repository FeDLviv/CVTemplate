$(function () {

    //АКТИВАЦІЯ/ДЕАКТИВАЦІЯ БІЧНОЇ ПЕНЕЛІ
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

    // ЗАГАЛЬНІ НАЛАШТУВАННЯ X-editable 
    $.fn.editable.defaults.mode = 'inline';
    $.fn.editable.defaults.highlight = '#5BC0DE';
    $.fn.editableform.buttons = '<button type="submit" class="editable-submit btn btn-primary"><i class="fa fa-check"></i></button><button type="button" class="editable-cancel btn btn-outline-primary"><i class="fa fa-remove"></i></button>&nbsp';

    function validateFields(value) {
        if ($.trim(value) == '') {
            return 'This field is required';
        } else if ($.trim(value).length > 100) {
            return 'The maximum length is 100 characters';
        }
    };

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
    };

    // НАЛАШТУВАННЯ X-editable ДЛЯ ПАНЕЛІ Language
    setLanguageEditable();

    function setLanguageEditable() {
        $('.language-ediatble').editable({
            params: function (params) {
                params.table = 'language';
                return params;
            },
            validate: validateFields
        });
    };

    $('.language-ediatble').on('save', function (e, params) {
        $(this).closest('tr').find('td:eq(3)').text(params.response);
    });

    $('.language-ediatble-add').editable({
        validate: validateFields
    });

    $('#butAddLanguage').on('click', function () {
        var url = $(this).attr('data-ajax');
        $('.language-ediatble-add').editable('submit', {
            url: url,
            success: function (response, config) {
                $('.language-ediatble-add').editable('setValue', null);
                data = $.parseJSON(response);
                var tr = $('#tabLanguage tbody tr:first').clone();
                tr.addClass('table-info');
                tr.find('td:eq(0)').text(data.id);
                tr.find('td:eq(1) a').attr('data-pk', data.id);
                tr.find('td:eq(1) a').text(data.name);
                tr.find('td:eq(2) a').attr('data-pk', data.id);
                tr.find('td:eq(2) a').text(data.level);
                tr.find('td:eq(3)').text(data.dateChange);
                tr.find('button').on('click', function (e) {
                    deleteRow($(this));
                });
                $('#tabLanguage').append(tr);
                setLanguageEditable();
            },
            error: function (error) {
                if (error && error.responseText) {
                    $('#modalError').html(error.responseText);
                }
                $('#modalText').text('Error');
                $('#modalDialog').modal('show')
            }
        });
    });

    $('#tabLanguage button[data-url]').on('click', function (e) {
        deleteRow($(this));
    });

    // НАЛАШТУВАННЯ X-editable ДЛЯ ПАНЕЛІ Education
    setEducationEditable();

    function setEducationEditable() {
        $('.education-ediatble-req').editable({
            params: function (params) {
                params.table = 'education';
                return params;
            },
            validate: validateFields
        });
        $('.education-ediatble-not-req').editable({
            params: function (params) {
                params.table = 'education';
                return params;
            },
            validate: validateEducationFields
        });
        $('.education-ediatble-date-req').editable({
            params: function (params) {
                params.table = 'education';
                return params;
            },
            validate: validateEducationFieldsDate
        });
        $('.education-ediatble-date-not-req').editable({
            params: function (params) {
                params.table = 'education';
                return params;
            },
            validate: validateEducationFieldsDateNotReq
        });
    };

    function validateEducationFields(value) {
        if ($.trim(value).length > 100) {
            return 'The maximum length is 100 characters';
        }
    };

    function validateEducationFieldsDate(value) {
        var pattern = /^([0-9]{4})-([0-9]{2})-([0-9]{2})$/;
        if (!pattern.test(value) || isNaN(Date.parse(value))) {
            return 'Please enter the date in the format YYYY-MM-DD';
        }
    };

    function validateEducationFieldsDateNotReq(value) {
        var pattern = /^([0-9]{4})-([0-9]{2})-([0-9]{2})$/;
        if ($.trim(value) !== '' && (!pattern.test(value) || isNaN(Date.parse(value)))) {
            return 'Please enter the date in the format YYYY-MM-DD';
        }
    };

    $('.education-ediatble').on('save', function (e, params) {
        $(this).closest('tr').find('td:eq(7)').text(params.response);
    });

    $('.education-ediatble-add-req').editable({
        validate: validateFields
    });
    $('.education-ediatble-add-not-req').editable({
        validate: validateEducationFields
    });
    $('.education-ediatble-add-date-req').editable({
        validate: validateEducationFieldsDate
    });
    $('.education-ediatble-add-date-not-req').editable({
        validate: validateEducationFieldsDateNotReq
    });

    $('#butAddEducation').on('click', function () {
        var url = $(this).attr('data-ajax');
        $('.education-ediatble-add').editable('submit', {
            url: url,
            success: function (response, config) {
                $('.education-ediatble-add').editable('setValue', null);
                data = $.parseJSON(response);
                var tr = $('#tabEducation tbody tr:first').clone();
                tr.addClass('table-info');
                tr.find('td:eq(0)').text(data.id);
                tr.find('td:eq(1) a').attr('data-pk', data.id);
                tr.find('td:eq(1) a').text(data.institute);
                tr.find('td:eq(2) a').attr('data-pk', data.id);
                tr.find('td:eq(2) a').text(data.title);
                tr.find('td:eq(3) a').attr('data-pk', data.id);
                tr.find('td:eq(3) a').text(data.speciality);
                tr.find('td:eq(4) a').attr('data-pk', data.id);
                tr.find('td:eq(4) a').text(data.specialization);
                tr.find('td:eq(5) a').attr('data-pk', data.id);
                tr.find('td:eq(5) a').text(data.start);
                tr.find('td:eq(6) a').attr('data-pk', data.id);
                tr.find('td:eq(6) a').text(data.stop);
                tr.find('td:eq(7)').text(data.dateChange);
                tr.find('button').on('click', function (e) {
                    deleteRow($(this));
                });
                $('#tabEducation').append(tr);
                setEducationEditable();
            },
            error: function (error) {
                if (error && error.responseText) {
                    $('#modalError').html(error.responseText);
                }
                $('#modalText').text('Error');
                $('#modalDialog').modal('show')
            }
        });
    });

    $('#tabEducation button[data-url]').on('click', function (e) {
        deleteRow($(this));
    });

});