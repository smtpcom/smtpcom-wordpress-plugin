(function ( $ ) {
    'use strict';

    $(window).load(
        function () {

            initDatePickers();

            $(document).on(
                'change', '#date_from__smtp, #date_end__smtp',function () {
                    $('.date_block__smtp, .header_block__smtp').show();
                    getMessagesHistory();
                }
            );
        }
    );


    $(document).on(
        'click','.show-pass',function () {
            $('#apikey').attr('type','text');
            $('.show-pass').addClass('active');
        }
    );
    $(document).on(
        'click','.show-pass.active',function () {
            $('#apikey').attr('type','password');
            $('.show-pass').removeClass('active');
        }
    );

    $(document).on(
        'change', '#sendVia',function () {
            let sendVia = $(this).val();
            $('.block_api__smtp, .block_smtp__smtp').removeClass('show');
            if (sendVia == 'smtp') {
                $('.block_smtp__smtp').addClass('show');
            } else {
                $('.block_api__smtp').addClass('show');
            }
        }
    );



    $(document).on(
        'change', '#smtpSecurity',function () {
            let security = $(this).val().toLowerCase();
            if (security == 'ssl') {
                $('#smtpPorts').find('option').attr("disabled", "disabled");
                $('#smtpPorts').append('<option value="465">465</option>').val(465);
                $('.ssl_port').slideDown();
                $('.active_ports').slideUp();
            } else {
                let firstOp = $('#smtpPorts option:first-child').val();
                $('#smtpPorts').val(firstOp).find('option').removeAttr("disabled");
                $('#smtpPorts option[value=465]').each(
                    function () {
                        $(this).remove();
                    }
                );
                $('.ssl_port').slideUp();
                if ($('#smtpPorts option').length == 0) {
                    $('.active_ports').slideDown();
                }
            }
        }
    );

    $(document).ready(
        function () {
            if ($('#smtpSecurity').val().toLowerCase() == 'ssl') {
                $('#smtpPorts').find('option').attr("disabled", "disabled");
                $('#smtpPorts').append('<option value="465">465</option>').val(465);
            }
        }
    );

    $(document).on(
        'click','.submitSettings',function () {
            initModal();
            $.ajax(
                {
                    url: '/wp-admin/admin-ajax.php',
                    type: "POST",
                    data: getFormData(this),
                    success: function (data) {
                        checkData(data)
                    }
                }
            );
            return false;
        }
    );

    $(document).on(
        'click','.testEmailSettings',function () {
            initModal();
            $.ajax(
                {
                    url: '/wp-admin/admin-ajax.php',
                    type: "POST",
                    data: getFormData(this),
                    success: function (data) {
                        checkData(data)
                    }
                }
            );
            return false;
        }
    );

    $(document).on(
        'click','.item-tabs_settings__smtp',function () {
            $('.item-tabs_title__smtp').removeClass('active__smtp');
            $(this).addClass('active__smtp');
            $('.block_recent_deliveries__smtp').hide();
            $('.block_setting__smtp').show();
        }
    );

    $(document).on(
        'click','.item-tabs_recent__smtp',function () {
            $('.item-tabs_title__smtp').removeClass('active__smtp');
            $(this).addClass('active__smtp');
            $('.block_setting__smtp').hide();
            $('.block_recent_deliveries__smtp').show();
            getMessagesHistory();
        }
    );

    $(document).on(
        'click','.close_modal__smtp, .background_modal__smtp',function () {
            $('.block_modal__smtp').fadeOut();
        }
    )

    function formatDate(date)
    {
        let d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

        if (month.length < 2) {
            month = '0' + month;
        }
        if (day.length < 2) {
            day = '0' + day;
        }

        return [year, month, day].join('-');
    }

    function checkData(data)
    {
        switch (data) {
        case 'API_channel_empty':
            $('.block_modal__smtp').fadeOut();
            $('.API_empty').slideDown();
            $('.channel_empty').slideDown();
            $('#apikey').addClass('inpur_error__smtp');
            $('#channelname').addClass('inpur_error__smtp');
                break;
        case 'API_empty':
            $('.block_modal__smtp').fadeOut();
            $('.API_empty').slideDown();
            $('#apikey').addClass('inpur_error__smtp');
                break;
        case 'channel_empty':
            $('.block_modal__smtp').fadeOut();
            $('.channel_empty').slideDown();
            $('#channelname').addClass('inpur_error__smtp');
                break;
        case 'API_invalid':
            $('.block_modal__smtp').fadeOut();
            $('.API_invalid').slideDown();
            $('#apikey').addClass('inpur_error__smtp');
                break;
        case 'channel_invalid':
            $('.block_modal__smtp').fadeOut();
            $('.channel_invalid').slideDown();
            $('#channelname').addClass('inpur_error__smtp');
                break;
        case 'port_443':
            $('.block_modal__smtp').fadeOut();
            $('.port_443').slideDown();
                break;
        case 'smtp_failed':
            $('.block_modal__smtp').fadeOut();
            $('.smtp_failed').slideDown();
                break;
        case 'closed_port':
            $('.block_modal__smtp').fadeOut();
            $('.active_one_port').slideDown();
                break;
        case 'Thanks, api settings have been saved!':
            $('#date_from__smtp').change();
            $('.message_modal__smtp').html(data);
                break;
        default:
            $('.message_modal__smtp').html(data);
                break;
        }
    }

    function getFormData(e)
    {
        const data = {
            action: $(e).attr('id'),
            sendVia: $('#sendVia').val(),
            apikey : $('#apikey').val(),
            channelname : $('#channelname').val(),
            smtpPorts : $('#smtpPorts').val(),
            smtpSecurity : $('#smtpSecurity').val(),
            smtpEnc : $('#smtpEnc').val(),
            smtpLogin : $('#smtpLogin').val(),
            smtpPass : $('#smtpPass').val(),
            _wpnonce : $('#_wpnonce').val(),
            _wp_http_referer : $("input[name=_wp_http_referer]").val()
        }
    
        return data;
    }

    function initModal()
    {
        $('.message_modal__smtp').html('sending...');
        $('.error_mess__smtp').slideUp();
        $('.inpur_error__smtp').removeClass('inpur_error__smtp');
        $('.block_modal__smtp').fadeIn();
    }

    function getMessagesHistory(){
        let dateFrom = formatDate($('#date_from__smtp').datepicker('getDate'));
        let dateEnd = formatDate($('#date_end__smtp').datepicker('getDate'));
        $("#date_from__smtp").datepicker('destroy');
        $("#date_end__smtp").datepicker('destroy');
        initDatePickers();
        $('.result_message__smtp').html('<p class="loading_message__smtp">loading...</p>');
        $.ajax(
            {
                url: '/wp-admin/admin-ajax.php',
                type: "POST",
                data: {
                    action: 'sort_messages__smtp',
                    dateFrom: dateFrom,
                    dateEnd: dateEnd
                },
                success: function (data) {
                    $('.result_message__smtp').html(data);
                }
            }
        );
        return false;
    }

    function initDatePickers()
    {
        let dateFormat = replaceBulk($('.date_block__smtp').data('dateformat').toLowerCase(),['m','d','y','j','l','f'],['mm','dd','yy','d','DD','MM']);
        $("#date_from__smtp").datepicker(
            {
                dateFormat: dateFormat,
                firstDay: 1,
                maxDate: new Date($('#date_end__smtp').val()),
            },
        );
        $("#date_end__smtp").datepicker(
            {
                dateFormat: dateFormat,
                maxDate: 0,
                firstDay: 1,
                minDate: new Date($('#date_from__smtp').val()),
            },
        );
    }

    function replaceBulk( str, findArray, replaceArray )
    {
        var i, regex = [], map = {};
        for( i=0; i<findArray.length; i++ ){
            regex.push(findArray[i].replace(/([-[\]{}()*+?.\\^$|#,])/g,'\\$1'));
            map[findArray[i]] = replaceArray[i];
        }
        regex = regex.join('|');
        str = str.replace(
            new RegExp(regex, 'g'), function (matched) {
                return map[matched];
            }
        );
        return str;
    }

})(jQuery);
