/**
 *
 * NotifyStandard
 *
 * Index.Pages.Notify.Standard.html page content scripts. Initialized from scripts.js file.
 *
 *
 */

$(document).ready(function () {
    var notifies = [{
        title: '<span class="f-14 f-w-600 text-danger">Внимание!</span>',
        message: '<div class="mt-2 f-12"><p>Информация, обрабатываемая и хранящаяся в подсистемах ИБД-Р, представлена в ограниченном доступе.</p><p>Обращаем особое внимание, что использование возможно исключительно сотрудниками МВД России и только в служебных целях.</p><p>Передача третьим лицам строго запрещена!</p></div>',
        delay: 3000,
    }, {
        title: '<span class="f-14 f-w-600 text-danger">Напоминаем!</span>',
        message: '<p class="mt-2 f-12">Чётко соблюдайте положения документов по информационной безопасности.</p>',
        delay: 13000
    }];

    $('#authButton').on('click', function () {
        // $.post('');
        $.post('http://' + this.baseURI.split('/')[2] + '/compileauthquery', {_token: $('[name="_token"]').val()}, function (response) {
            console.log(response);
            if (response.hash) {
                $('#authBlock').html('<form id="authForm" method="post" action="http://idp.sgk.sudis.mvd.ru/idp/profile/SAML2/POSTGOST/SSO">' +
                    '<input type="hidden" name="SAMLRequest" value="' + response.hash + '" />' +
                    '<input type="hidden" name="RelayState" value="/index"/></form>');
                //$('#authForm').submit();
            }
        });
    });

    if (this.baseURI.split('/').pop() == 'giac') $('#iconAddNews').show();

    function getNotify(args) {
        return new Promise(function (resolve, reject) {
            setTimeout(function () {
                jQuery.notify({
                        title: args.title,
                        message: args.message,
                        icon: '/img/warning.svg'
                    },
                    {
                        type: 'primary',
                        icon_type: 'image',
                        delay: 9000,
                        placement: {
                            from: 'bottom',
                            align: 'right',
                        },
                    }
                );
                resolve();
            }, args.delay);
        })
    }

    getNotify(notifies[0]).then(function () {
        return getNotify(notifies[1]);
    });

    $('.init-modal-open').click(function () {
        document.querySelectorAll('.scroll-by-count').forEach((el) => {
            if (typeof ScrollbarByCount === 'undefined') {
                console.log('ScrollbarByCount is undefined!');
                return;
            }
            let scrollByCount = new ScrollbarByCount(el);
        });
    })
});
