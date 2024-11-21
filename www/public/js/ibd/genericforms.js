/**
 * Обработчик запросов из  форм
 */

class GenericForms {
    rules = {};
    messages = {};
    mask;
    options;

    constructor() {
        // Инициализация объекта класса
        this.initialize();
        this._initAddMenu();
    }

    _initAddMenu() {
        const formM = document.querySelector('#addMenuForm');
        const descriptionNews = document.querySelector('#descriptionNews');
        if (descriptionNews) {
            $(descriptionNews).on('keyup', '.ql-editor', function(){
                $('textarea[name="text"]').html($(this).html());
            });
        }
        if (!formM) {
            return;
        } else {
                $('.btn-remove').on('click', function () {
                    var target = this;
                    Swal.fire({
                        title: 'Вы уверены, что хотите удалить выбранный сервис?',
                        icon: 'question',
                        showDenyButton: true,
                        confirmButtonText: 'Удалить',
                        denyButtonText: 'Отмена'
                    }).then((result) => {
                        if(result.isConfirmed) {
                            $.post(this.baseURI + '/deletesection', {id: $(target).attr('id'), _token: $('[name="_token"]').val()},
                                function (response) {
                                    $.notify(
                                        {title: response.title, message: response.message},
                                        {type: response.type, delay: 5000, placement: {from: 'top', align: 'center'}}
                                    );
                                    if (response.type == 'danger') {
                                        $(target).parents('.col-6').remove();
                                    }
                                });
                        }
                    });
                });
            $('#menuIcon').on('change', function () {
                $('#addMenuForm').find('#icon').html('<i class="text-primary mdi ' + $(this).find('option:selected').text() + '"></i>');
            });
        }
    }

    // метод для инициализации формы, в случае нахождения класса '.sendForm'
    initialize() {
        const forms = $('.form');
        if (forms.length === 0) {
            return;
        } else {
            console.log('Подключена(ы) форма(ы) для отправки данных...');
            let setValidate = (form) => this.validate(form); //ссылка на приватный метод формирования настроек валидации
            let setHandler = this.handler; //ссылка на приватный метод обработчика запроса
            forms.each(function () {
                //console.log(setValidate(this));
                $(this).validate(setValidate(this));
                $(this).bind('submit', setHandler);
            });
        }
    }

    //метод формирования параметров валидации реквизитов формы
    validate(form) {
        //параметры масок валидации реквизита
        this.mask = {
            fullname: [/^[А-ЯЁа-яё -]+$/i, "Только кириллица!"],
            login: [/^\w+$/i, "Только латиница и числа!"],
            number: [/^[0-9]+$/i, "Только число!"],
            nsc: [/^[А-ЯЁа-яёA-Za-z0-9 /.-]+$/i, "Без спецсимволов!"],
            required: [undefined, "Обязательное поле!"],
        };
        for (let props of $(form).serializeArray()) {
            this.rules[props.name] = {
                required: ($(form).find('[name="' + props.name + '"]').data('required') === true) ? true : false, //является ли реквизит обязательным
                minlength: (typeof $(form).find('[name="' + props.name + '"]').data('length') === 'number') ? $(form).find('[name="' + props.name + '"]').data('length') : false, //длина строки реквизита
            };
            this.messages[props.name] = {required: this.mask['required'][1]};
            //маска валидации реквизита
            if ($(form).find('[name="' + props.name + '"]').data('mask') !== undefined) {
                if ($(form).find('[name="' + props.name + '"]').data('mask') in this.mask) {
                    this.rules[props.name].regex = this.mask[$(form).find('[name="' + props.name + '"]').data('mask')][0];
                    this.messages[props.name]['regex'] = this.mask[$(form).find('[name="' + props.name + '"]').data('mask')][1];
                } else {
                    this.rules[props.name][$(form).find('[name="' + props.name + '"]').data('mask')] = true; //маска валидации реквизита
                }
            }
        }
        //возвращение настроек валидации существующих реквизитов
        return this.options = {rules: this.rules, messages: this.messages};
    }

    //метод обработки события 'submit' (отправки данных из формы)
    handler(event) {
        //отключение события загрузки страницы
        event.preventDefault();
        event.stopPropagation();

        //отправка запроса на файл обработчик
        if ($(event.currentTarget).valid()) {
            let submitText = $(event.currentTarget).find('[type="submit"]').html();
            let formValues = {};
            for (let props of $(event.currentTarget).serializeArray()) {
                formValues[props.name] = props.value;
            }
            let formData = new FormData(event.currentTarget);

            if ($(event.currentTarget).data('type') !== undefined && $(event.currentTarget).data('type').includes('create-datatable-')) {
                if (!jQuery().DataTable) {
                    console.log('DataTable is null!');
                    return;
                } else {
                    $('#' + $(event.currentTarget).data('type').substring(17)).DataTable({
                        destroy: true, processing: true, serverSide: true, pageLength: 10,
                        buttons: ['copy', 'excel', 'csv', 'print'],
                        searching: false, ordering: false,
                        ajax: {
                            url: event.currentTarget.action,
                            type: event.currentTarget.method,
                            data: formValues
                        },
                        sDom: '<"row"<"col-sm-12"<"table-container"t>r>><"row"<"col-12"p>>',
                        responsive: true,
                        language: {
                            paginate: {
                                previous: '<i class="cs-chevron-left"></i>',
                                next: '<i class="cs-chevron-right"></i>',
                            },
                        },
                    });
                    new DatatableExtend();
                }
            } else {
                function clearForm(target) {
                    $(target).find('input').each(function () {
                        if ($(this).attr('name') != '_token') {
                            $(this).val('');
                        }
                    });
                    $(target).find('textarea').text('');
                    $(target).find('select').val('').trigger('change');
                }

                $.ajax({
                    url: event.currentTarget.action,
                    type: event.currentTarget.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        submitText = $(event.currentTarget).find('[type="submit"]').text();
                        $(event.currentTarget).find('[type="submit"]').attr('disabled', 'disabled');
                        $(event.currentTarget).find('[type="submit"]').html('<i class="fa fa-spin fa-spinner"></i> Подождите');
                    },
                    //обработка возвращаемого результата
                    success: function (response) {
                        $(event.currentTarget).find('[type="submit"]').attr('disabled', false);
                        $(event.currentTarget).find('[type="submit"]').html(submitText);
                        if (typeof response === 'object' && response !== null) {
                            //подключение модуля уведомлений
                            $.notify(
                                {title: response.title, message: response.message},
                                {type: response.type, delay: 5000, placement: {from: 'top', align: 'center'}}
                            );
                            if (response.type == 'info' && event.currentTarget.action.includes('addsection')) {
                                $('#addBlock').before('<div class="col-6 col-xl-3 sh-19">' +
                                    '<button id="' + response.id + '" type="button" class="btn btn-link btn-card btn-remove"><i class="icon-trash"></i></button>' +
                                    '<div class="card h-100 hover-scale-down hover-shadow-light">' +
                                    '<a class="card-body text-center m-t--10" href="' + formValues.project_url + '">' +
                                    '<i class="mdi ' + $('#menuIcon').find('option:selected').text() + ' f-42"></i><p class="heading text-body">' + formValues.project_title + '</p>' +
                                    '<div class="text-extra-small fw-medium text-muted">' + formValues.project_subtitle + '</div></a></div></div>');
                                $(event.currentTarget).parents('.modal').modal('toggle');
                                clearForm(event.currentTarget);
                                $('#icon').html('<i class="ti-gallery text-light"></i>');
                                $('.btn-remove').on('click', function () {
                                    var target = this;
                                    Swal.fire({
                                        title: 'Вы уверены, что хотите удалить выбранный сервис?',
                                        icon: 'question',
                                        showDenyButton: true,
                                        confirmButtonText: 'Удалить',
                                        denyButtonText: 'Отмена'
                                    }).then((result) => {
                                        if(result.isConfirmed) {
                                            $.post(this.baseURI + '/deletesection', {id: $(target).attr('id'), _token: $('[name="_token"]').val()},
                                                function (response) {
                                                    $.notify(
                                                        {title: response.title, message: response.message},
                                                        {type: response.type, delay: 5000, placement: {from: 'top', align: 'center'}}
                                                    );
                                                    if (response.type == 'danger') {
                                                        $(target).parents('.col-6').remove();
                                                    }
                                                });
                                        }
                                    });
                                });
                            }

                            if (response.link) {
                                setTimeout(function () {
                                    window.location.href = response.link;
                                }, 1000);
                            }
                            if (response.list) {
                                if (response.list.length > 0) {
                                    let html = '<table class="table table-striped align-middle"><thead>' +
                                        '<tr><th class="text-muted text-small text-uppercase">ФИО</th>' +
                                        '<th class="text-muted text-small text-uppercase">Дата рождения</th>' +
                                        '<th class="text-muted text-small text-uppercase">#</th></tr></thead><tbody>';
                                    for (let row of response.list) {
                                        html += '<tr><td>' + row.fio_ru + '</td><td>' + row.dt_rojd + '</td>' +
                                            '<td><a class="btn btn-xs btn-info" href="' + row.link + '">Перейти</a></td></tr>';
                                    }
                                    html += '</tbody></table>';
                                    console.log(html);
                                    $('#addMoreModal').modal('toggle');
                                    $('#addMoreModal').find('.modal-body').html(html);
                                }
                            }
                            //работа в массивом данных (по необходимости, например, для формирования ответа по результату поискового запроса)
                            // if (response.data) {
                            //     let html = '';
                            //     console.log(response.data.length);
                            //     if (response.data.length > 0) {
                            //         for (let row of response.data) {
                            //             html += '<tr><td>' + row.fam + '</td><td>' + row.imj + '</td><td>' + row.otch + '</td><td>' + row.dt_rojd + '</td></tr>';
                            //         }
                            //     }
                            //     $('.data-table').find('tbody').html(html);
                            // }
                        } else {
                            location.reload();
                        }
                    }
                });
            }
        }
    }
}
