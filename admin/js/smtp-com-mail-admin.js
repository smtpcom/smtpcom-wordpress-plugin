(function ( $ ) {
    'use strict';

    $(document).on('click','.show-pass',function () {
        $('#apikey').attr('type','text');
        $('.show-pass').addClass('active');
    });
    $(document).on('click','.show-pass.active',function () {
        $('#apikey').attr('type','password');
        $('.show-pass').removeClass('active');
    });

    $(document).on('change', '#sendVia',function () {
        let sendVia = $(this).val();
        $('.block_api__smtp, .block_smtp__smtp').removeClass('show');
        if (sendVia == 'smtp') {
            $('.block_smtp__smtp').addClass('show');
            $('.item-tabs_recent__smtp').hide();
        } else {
            // $('#date_from__smtp').change();
            $('.block_api__smtp').addClass('show');
            $('.item-tabs_recent__smtp').show();
        }
    });

    $(document).on('change', '#date_from__smtp, #date_end__smtp',function () {
        $('.date_block__smtp, .header_block__smtp').show();
        let dateFrom = $('#date_from__smtp').val();
        let dateEnd = $('#date_end__smtp').val();
        $('.result_message__smtp').html('<p class="loading_message__smtp">loading...</p>');
        $.ajax({
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
        });
        return false;
    });

    $(document).on('change', '#smtpSecurity',function () {
        let security = $(this).val().toLowerCase();
        if (security == 'ssl') {
            $('#smtpPorts').find('option').attr("disabled", "disabled");
            $('#smtpPorts').append('<option value="465">465</option>').val(465);
            $('.ssl_port').slideDown();
            $('.active_ports').slideUp();
        } else {
            let firstOp = $('#smtpPorts option:first-child').val();
            $('#smtpPorts').val(firstOp).find('option').removeAttr("disabled");
            $('#smtpPorts option[value=465]').each(function () {
                $(this).remove();
            });
            $('.ssl_port').slideUp();
            if ($('#smtpPorts option').length == 0) {
                $('.active_ports').slideDown();
            }
        }
    });

    $(document).ready(function () {
        if ($('#smtpSecurity').val().toLowerCase() == 'ssl') {
            $('#smtpPorts').find('option').attr("disabled", "disabled");
            $('#smtpPorts').append('<option value="465">465</option>').val(465);
        }
    });

    $(document).on('submit','#saveSettings__smtp',function () {
        $('.message_modal__smtp').html('saving...');
        $('.error_mess__smtp').slideUp();
        $('.inpur_error__smtp').removeClass('inpur_error__smtp');
        $('.block_modal__smtp').fadeIn();
        let str = $(this).serialize();
        str = str + '&action=' + 'saveSettings_smtp';
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: "POST",
            data: str,
            success: function (data) {
                checkData(data)
            }
        });
        return false;
    });

    $(document).on('click','.testEmailSettings',function () {
        $('.message_modal__smtp').html('sending...');
        $('.error_mess__smtp').slideUp();
        $('.inpur_error__smtp').removeClass('inpur_error__smtp');
        $('.block_modal__smtp').fadeIn();
        let sendVia = $('#sendVia').val();
        let apikey = $('#apikey').val();
        let channelname = $('#channelname').val();
        let smtpPorts = $('#smtpPorts').val();
        let smtpSecurity = $('#smtpSecurity').val();
        let smtpEnc = $('#smtpEnc').val();
        let smtpLogin = $('#smtpLogin').val();
        let smtpPass = $('#smtpPass').val();
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: "POST",
            data: {
                action: 'send_test_smtp_com',
                sendVia: sendVia,
                apikey: apikey,
                channelname: channelname,
                smtpPorts: smtpPorts,
                smtpSecurity: smtpSecurity,
                smtpEnc: smtpEnc,
                smtpLogin: smtpLogin,
                smtpPass: smtpPass,
            },
            success: function (data) {
                checkData(data)
            }
        });
        return false;
    });

    $(document).on('click','.item-tabs_settings__smtp',function () {
        $('.item-tabs_title__smtp').removeClass('active__smtp');
        $(this).addClass('active__smtp');
        $('.block_recent_deliveries__smtp').hide();
        $('.block_setting__smtp').show();
    });

    $(document).on('click','.item-tabs_recent__smtp',function () {
        $('.item-tabs_title__smtp').removeClass('active__smtp');
        $(this).addClass('active__smtp');
        $('.block_setting__smtp').hide();
        $('.block_recent_deliveries__smtp').show();
    });

    $(document).on('click','.close_modal__smtp, .background_modal__smtp',function () {
        $('.block_modal__smtp').fadeOut();
    })

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
            case 'Thanks, api settings have been saved!':
                $('#date_from__smtp').change();
                $('.message_modal__smtp').html(data);
                break;
            default:
                $('.message_modal__smtp').html(data);
                break;
        }
    }


})(jQuery);