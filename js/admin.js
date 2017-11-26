$(function () {

    //АКТИВАЦІЯ/ДЕАКТИВАЦІЯ БІЧНОЇ ПАНЕЛІ
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

    //ОБРОБКА ПОДІЇ ЗАКРИТТЯ ДІАЛОГОВОГО ВІКНА
    $('#modalDialog').on('hidden.bs.modal', function (e) {
        $('#modalError').html('');
    })

    //AJAX ВІДПРАВКА ДАНИХ ФОРМИ Settings НА СЕРВЕР ТА ОБРОБКА РЕЗУЛЬТАТУ
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

    //ОБРОБНИК ДЛЯ КНОПКИ ВИДАЛЕННЯ ФАЙЛА CV
    $('#butCV_path').on('click', function (e) {
        ajaxDelete($(this), e);
    });

    //ОБРОБНИК ДЛЯ КНОПКИ ВИДАЛЕННЯ ФАЙЛА Photo
    $('#butPhoto_path').on('click', function (e) {
        ajaxDelete($(this), e);
    });

    //AJAX ФУНКЦІЯ ВІДПРАВЛЯЄ НА СЕРВЕР НАЗВУ ФАЙЛА ДЛЯ ВИДАЛЕННЯ ТА ОБРОБЛЯЄ РЕЗУЛЬТАТ
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

    //AJAX ВІДПРАВКА ДАНИХ ФОРМИ Contact НА СЕРВЕР ТА ОБРОБКА РЕЗУЛЬТАТУ
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

    //ЗАГАЛЬНІ НАЛАШТУВАННЯ X-editable 
    $.fn.editable.defaults.mode = 'inline';
    $.fn.editable.defaults.highlight = '#5BC0DE';
    $.fn.editableform.buttons = '<button type="submit" class="editable-submit btn btn-primary"><i class="fa fa-check"></i></button><button type="button" class="editable-cancel btn btn-outline-primary"><i class="fa fa-remove"></i></button>&nbsp';

    //ФУНКЦІЯ ДЛЯ ВАЛІДАЦІї "СТАНДАРТНИХ" ПОЛІВ (ОБОВ'ЯЗКОВІ + НЕ БІЛЬШЕ 100 СИМВОЛІВ)
    function validateFields(value) {
        if ($.trim(value) == '') {
            return 'This field is required';
        } else if ($.trim(value).length > 100) {
            return 'The maximum length is 100 characters';
        }
    };

    //ФУНКЦІЯ ДЛЯ ВАЛІДАЦІї ПОЛІВ З ДАТОЮ (ФОРМАТ ДАТИ)
    function validateDateFields(value) {
        var pattern = /^([0-9]{4})-([0-9]{2})-([0-9]{2})$/;
        if (!pattern.test(value) || isNaN(Date.parse(value))) {
            return 'Please enter the date in the format YYYY-MM-DD';
        }
    };

    //ФУНКЦІЯ ДЛЯ ВАЛІДАЦІї ПОЛІВ З ДАТОЮ (НЕ ОБОВ'ЯЗКОВЕ + ФОРМАТ ДАТИ)
    function validateDateFieldsNotReq(value) {
        var pattern = /^([0-9]{4})-([0-9]{2})-([0-9]{2})$/;
        if ($.trim(value) !== '' && (!pattern.test(value) || isNaN(Date.parse(value)))) {
            return 'Please enter the date in the format YYYY-MM-DD';
        }
    };

    //ФУНКЦІЯ ДЛЯ ОБРОБКИ ПОМИЛКИ ПРИ ДОДАВАННІ РЯДКА(ЗАПИСУ) В ТАБЛИЦЮ(БАЗУ ДАНИХ)
    function addRowError(error) {
        $('#modalError').html('');
        if (error && error.responseText) {
            $('#modalError').html(error.responseText);
        } else {
            $.each(error, function (k, v) {
                $('#modalError').append('<small class="form-text text-muted text-danger">' + k + ': ' + v + '</small>');
            });
        }
        $('#modalText').text('Error');
        $('#modalDialog').modal('show');
    }

    //ФУНКЦІЯ ДЛЯ ВИДАЛЕННЯ РЯДКА З ТАБЛИЦІ
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
            validate: validateDateFields
        });
        $('.education-ediatble-date-not-req').editable({
            params: function (params) {
                params.table = 'education';
                return params;
            },
            validate: validateDateFieldsNotReq
        });
    };

    function validateEducationFields(value) {
        if ($.trim(value).length > 100) {
            return 'The maximum length is 100 characters';
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
        validate: validateDateFields
    });
    $('.education-ediatble-add-date-not-req').editable({
        validate: validateDateFieldsNotReq
    });

    $('#butAddEducation').on('click', function () {
        var url = $(this).attr('data-ajax');
        $('.education-ediatble-add').editable('submit', {
            url: url,
            success: function (response, config) {
                $('.education-ediatble-add').editable('setValue', '');
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
                tr.css('display', '');
                $('#tabEducation').append(tr);
                setEducationEditable();
            },
            error: addRowError
        });
    });

    $('#tabEducation button[data-url]').on('click', function (e) {
        deleteRow($(this));
    });

    // НАЛАШТУВАННЯ X-editable ДЛЯ ПАНЕЛІ Work
    setWorkEditable();

    function setWorkEditable() {
        $('.work-ediatble-req').editable({
            params: function (params) {
                params.table = 'work';
                return params;
            },
            validate: validateFields
        });
        $('.work-ediatble-date-req').editable({
            params: function (params) {
                params.table = 'work';
                return params;
            },
            validate: validateDateFields
        });
        $('.work-ediatble-date-not-req').editable({
            params: function (params) {
                params.table = 'work';
                return params;
            },
            validate: validateDateFieldsNotReq
        });
    };

    $('.work-ediatble').on('save', function (e, params) {
        $(this).closest('tr').find('td:eq(5)').text(params.response);
    });

    $('.work-ediatble-add-req').editable({
        validate: validateFields
    });
    $('.work-ediatble-add-date-req').editable({
        validate: validateDateFields
    });
    $('.work-ediatble-add-date-not-req').editable({
        validate: validateDateFieldsNotReq
    });

    $('#butAddWork').on('click', function () {
        var url = $(this).attr('data-ajax');
        $('.work-ediatble-add').editable('submit', {
            url: url,
            success: function (response, config) {
                $('.work-ediatble-add').editable('setValue', '');
                data = $.parseJSON(response);
                var tr = $('#tabWork tbody tr:first').clone();
                tr.addClass('table-info');
                tr.find('td:eq(0)').text(data.id);
                tr.find('td:eq(1) a').attr('data-pk', data.id);
                tr.find('td:eq(1) a').text(data.organisation);
                tr.find('td:eq(2) a').attr('data-pk', data.id);
                tr.find('td:eq(2) a').text(data.position);
                tr.find('td:eq(3) a').attr('data-pk', data.id);
                tr.find('td:eq(3) a').text(data.start);
                tr.find('td:eq(4) a').attr('data-pk', data.id);
                tr.find('td:eq(4) a').text(data.stop);
                tr.find('td:eq(5)').text(data.dateChange);
                tr.find('button').on('click', function (e) {
                    deleteRow($(this));
                });
                tr.css('display', '');
                $('#tabWork').append(tr);
                setWorkEditable();
            },
            error: addRowError
        });
    });

    $('#tabWork button[data-url]').on('click', function (e) {
        deleteRow($(this));
    });

    // НАЛАШТУВАННЯ X-editable ДЛЯ ПАНЕЛІ Skill
    setSkillEditable();

    function setSkillEditable() {
        $('.skill-ediatble').editable({
            params: function (params) {
                params.table = 'skill';
                return params;
            },
            validate: validateFields
        });
    };

    $('.skill-ediatble').on('save', function (e, params) {
        $(this).closest('tr').find('td:eq(4)').text(params.response);
    });

    $('.skill-ediatble-add').editable({
        validate: validateFields
    });

    $('#butAddSkill').on('click', function () {
        var url = $(this).attr('data-ajax');
        $('.skill-ediatble-add').editable('submit', {
            url: url,
            success: function (response, config) {
                $('.skill-ediatble-add').editable('setValue', '');
                data = $.parseJSON(response);
                var tr = $('#tabSkill tbody tr:first').clone();
                tr.addClass('table-info');
                tr.find('td:eq(0)').text(data.id);
                tr.find('td:eq(1) a').attr('data-pk', data.id);
                tr.find('td:eq(1) a').text(data.type);
                tr.find('td:eq(2) a').attr('data-pk', data.id);
                tr.find('td:eq(2) a').text(data.name);
                tr.find('td:eq(3) a').attr('data-pk', data.id);
                tr.find('td:eq(3) a').text(data.level);
                tr.find('td:eq(4)').text(data.dateChange);
                tr.find('button').on('click', function (e) {
                    deleteRow($(this));
                });
                tr.css('display', '');
                $('#tabSkill').append(tr);
                setSkillEditable();
            },
            error: addRowError
        });
    });

    $('#tabSkill button[data-url]').on('click', function (e) {
        deleteRow($(this));
    });

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
                $('.language-ediatble-add').editable('setValue', '');
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
                tr.css('display', '');
                $('#tabLanguage').append(tr);
                setLanguageEditable();
            },
            error: addRowError
        });
    });

    $('#tabLanguage button[data-url]').on('click', function (e) {
        deleteRow($(this));
    });

});