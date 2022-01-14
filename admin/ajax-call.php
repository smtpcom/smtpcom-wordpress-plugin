<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use SmtpSdk\SmtpSdk;

/**
 * Ajax call for saving settings
 *
 * @since 1.0.0
 */

if ( !function_exists( 'smtpcom_mail_saveSettings_function' ) ) {
    add_action("wp_ajax_saveSettings_smtp", "smtpcom_mail_saveSettings_function");
    function smtpcom_mail_saveSettings_function()
    {
        if(!is_admin()){
            echo esc_attr('You must have administrator rights!');
            wp_die();
        }

        $sanitizedData = smtpcom_mail_sanitizeData($_POST);
        if ($sanitizedData['action'] == 'saveSettings_smtp') {
            /**
             * Ajax call for saving API settings
             *
             * @since 1.0.0
             */
            if ($sanitizedData['sendVia'] == 'api') {
                if (empty($sanitizedData['channelname'])) {
                    echo esc_attr('API_channel_empty');
                    wp_die();
                }

                if (empty($sanitizedData['apikey'])) {
                    echo esc_attr('API_empty');
                    wp_die();
                }

                $sanitizedData['smtpPorts'] = API_PORT;
                $connection = fsockopen("ssl://" . HOST_SMTP, $sanitizedData['smtpPorts'], $errno, $errstr, $timeout = 1);
                if (!is_resource($connection)) {
                    echo esc_attr('port_443');
                    wp_die();
                }
                fclose($connection);
            
                try {
                    $ps = SmtpSdk::create($sanitizedData['apikey']);
                    $ps->keys($sanitizedData['apikey'])->show();
                } catch (Exception $e) {
                    echo esc_attr('API_invalid');
                    wp_die();
                }

                try {
                    $ps->channels($sanitizedData['channelname'])->show();

                    if(smtpcom_mail_saveSettings($sanitizedData)) {
                        _e('Thanks, api settings have been saved!', 'smtp-com-mail');
                        wp_die();
                    } else {
                        echo esc_attr('Oops.. Looks like something went completely wrong');
                        wp_die();
                    }

                } catch (Exception $e) {
                    echo esc_attr('channel_invalid');
                    wp_die();
                }

            } else {
                /**
                 * Ajax call for saving SMTP settings
                 *
                 * @since 1.0.0
                 */
                global $phpmailer;
                if (!($phpmailer instanceof PHPMailer\PHPMailer\PHPMailer)) {
                    include_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
                    include_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
                    include_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
                }
                $smtp = new SMTP;
                /**
                 * Debug SMTP connection
                 *
                 * @since 1.0.0
                 */
                //            $smtp->do_debug = SMTP::DEBUG_CONNECTION;
                $connection = @fsockopen(SEND_HOST_SMTP, $sanitizedData['smtpPorts'], $errno, $errstr, $timeout = 1);
                if (!is_resource($connection)) {
                    echo esc_attr('closed_port');
                    wp_die();
                }
                fclose($connection);
                try {
                    if ($sanitizedData['smtpSecurity'] == 'SSL') {
                        if (!$smtp->connect("ssl://" . SEND_HOST_SMTP, $sanitizedData['smtpPorts'])) {
                            throw new Exception('Connect failed');
                        }
                    } else {
                        if (!$smtp->connect(SEND_HOST_SMTP, $sanitizedData['smtpPorts'])) {
                            throw new Exception('Connect failed');
                        }
                    }
                    if (!$smtp->hello(gethostname())) {
                        throw new Exception('EHLO failed: ' . $smtp->getError()['error']);
                    }
                    $e = $smtp->getServerExtList();
                    if ($sanitizedData['smtpSecurity'] == 'STARTTLS') {
                        if (is_array($e) && array_key_exists('STARTTLS', $e)) {
                            $tlsok = $smtp->startTLS();
                            if (!$tlsok) {
                                throw new Exception('Failed to start encryption: ' . $smtp->getError()['error']);
                            }
                            if (!$smtp->hello(gethostname())) {
                                throw new Exception('EHLO (2) failed: ' . $smtp->getError()['error']);
                            }
                            $e = $smtp->getServerExtList();
                        }
                    }
                    if (is_array($e) && array_key_exists('AUTH', $e)) {
                        if ($smtp->authenticate($sanitizedData['smtpLogin'], $sanitizedData['smtpPass'])) {
                            if(smtpcom_mail_saveSettings($sanitizedData)) {
                                _e('Thanks, settings have been saved!', 'smtp-com-mail');
                            } else {
                                echo esc_attr('Oops.. Looks like something went completely wrong');
                            }
                        } else {
                            throw new Exception('Authentication failed: ' . $smtp->getError()['error']);
                        }
                    }
                } catch (Exception $e) {
                    _e('SMTP login or password is incorrect', 'smtp-com-mail');
                    // open for debug
                    // _e('SMTP error: ' . $e->getMessage(), 'smtp-com-mail');
                }
            }
        }
        wp_die();
    }
}

/**
 * Ajax call for test send message
 *
 * @since 1.0.0
 */
if ( !function_exists( 'smtpcom_mail_send_test_function' ) ) {
    add_action("wp_ajax_send_test_smtp_com", "smtpcom_mail_send_test_function");
    function smtpcom_mail_send_test_function()
    {
        if(!is_admin()){
            echo esc_attr('You must have administrator rights!');
            wp_die();
        }

        $sanitizedData = smtpcom_mail_sanitizeData($_POST);

        if ($sanitizedData['action'] == 'send_test_smtp_com') {
            
            global $current_user;
            get_currentuserinfo();
            if (empty($sanitizedData['smtpPorts'])) {
                $sanitizedData['smtpPorts'] = 0;
            }
            $to = (string) $current_user->user_email;
            $fromSmtp = get_option('admin_email');

            $subject = 'Hello from your Wordpress Website via SMTP.com';
            $message = __('This email confirms that you have successfully installed your SMTP.com Wordpress Plugin. Congratulations and happy sending!');
            $headers = 'From: ' . $fromSmtp . " \r\n";
            if ($sanitizedData['sendVia'] == 'api') {
                /**
                 * Ajax call for test API send message
                 *
                 * @since 1.0.0
                 */
                if (empty($sanitizedData['channelname'])) {
                    echo esc_attr('API_channel_empty');
                    wp_die();
                }

                if (empty($sanitizedData['apikey'])) {
                    echo esc_attr('API_empty');
                    wp_die();
                }

                $port = API_PORT;
                $connection = fsockopen("ssl://" . HOST_SMTP, $port, $errno, $errstr, $timeout = 1);
                if (!is_resource($connection)) {
                    echo esc_attr('port_443');
                    wp_die();
                }
                fclose($connection);

                try {
                    $ps = SmtpSdk::create($sanitizedData['apikey']);
                    $ps->keys($sanitizedData['apikey'])->show();
                } catch (Exception $e) {
                    echo esc_attr('API_invalid');
                    wp_die();
                }

                try {
                    $ps->channels($sanitizedData['channelname'])->show();
                    $ps->messages($sanitizedData['channelname'])->create($fromSmtp, $to, $subject, $message);
                    _e('The test email has been sent!', 'smtp-com-mail');
                } catch (Exception $e) {
                    echo esc_attr('channel_invalid');
                    wp_die();
                }

            } else {
                /**
                 * Ajax call for test SMTP send message
                 *
                 * @since 1.0.0
                 */
                global $phpmailer;
                if (!($phpmailer instanceof PHPMailer\PHPMailer\PHPMailer)) {
                    include_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
                    include_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
                    include_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
                    $phpmailer = new PHPMailer(true);
                    $phpmailer->IsSMTP();
                    $phpmailer->CharSet = 'utf-8';
                    if (strtolower($sanitizedData['smtpSecurity']) == 'none') {
                        $phpmailer->SMTPSecure = false;
                        $phpmailer->SMTPAutoTLS = false;
                    } elseif (strtolower($sanitizedData['smtpSecurity']) == 'starttls') {
                        $phpmailer->SMTPSecure = 'tls';
                    } else {
                        $phpmailer->SMTPSecure = strtolower($sanitizedData['smtpSecurity']);
                    }
                    $phpmailer->Host = strtolower($sanitizedData['smtpServer']);
                    $phpmailer->Port = strtolower($sanitizedData['smtpPorts']);
                    $phpmailer->SMTPAuth = true;
                    $phpmailer->Username = strtolower($sanitizedData['smtpLogin']);
                    $phpmailer->Password = $sanitizedData['smtpPass'];
                    global $current_user;
                    get_currentuserinfo();
                    $to = (string) $current_user->user_email;
                    $phpmailer->setFrom($fromSmtp);
                    $phpmailer->AddAddress($to);
                    $phpmailer->Subject = "Hello from your Wordpress Website via SMTP.com";
                    $phpmailer->Body = "This email confirms that you have successfully installed your SMTP.com Wordpress Plugin. Congratulations and happy sending!";
                }
                try {
                    $connection = @fsockopen(SEND_HOST_SMTP, $sanitizedData['smtpPorts'], $errno, $errstr, $timeout = 1);
                    if (is_resource($connection)) {
                        fclose($connection);
                        $phpmailer->Send();
                        _e('The test email has been sent!', 'smtp-com-mail');
                    } else {
                        echo _e('Port was closed by host', 'smtp-com-mail');
                    }
                } catch (Exception $e) {
                    echo esc_attr('smtp_failed');
                }
            }
        }
        wp_die();
    }
}

/**
 * Ajax call for sort recent deliveries
 *
 * @since 1.0.0
 */
if ( !function_exists( 'smtpcom_mail_sort_messages_function' ) ) {
    add_action("wp_ajax_sort_messages__smtp", "smtpcom_mail_sort_messages_function");
    function smtpcom_mail_sort_messages_function()
    {
        if ($_POST['action'] == 'sort_messages__smtp') {
            $dateFrom = sanitize_option('date_format', $_POST['dateFrom']);
            $dateEnd = sanitize_option('date_format', $_POST['dateEnd']);
            smtpcom_mail_show_messages($dateFrom, $dateEnd);
        }
        wp_die();
    }
}

/**
 * Function for sort recent deliveries
 *
 * @since 1.0.0
 */
if ( !function_exists( 'smtpcom_mail_show_messages' ) ) {
    function smtpcom_mail_show_messages($dateFrom, $dateEnd)
    {
        $dateFormatWP = get_option('date_format');
        $timeFormatWP = get_option('time_format');
        if (version_compare(phpversion(), '7.2', '<')) {
            $startDate = date(DateTime::RFC2822, strtotime($dateFrom . ' 00:00:00'));
            $endDate = date(DateTime::RFC2822, strtotime($dateEnd . ' 23:59:59'));
        } else {
            $startDate = date(DateTimeInterface::RFC2822, strtotime($dateFrom . ' 00:00:00'));
            $endDate = date(DateTimeInterface::RFC2822, strtotime($dateEnd . ' 23:59:59'));
        }

        $parameters = [
            'start' => $startDate,
            'end'     => $endDate,
            'event' => array('accepted', 'failed', 'delivered'),
            'limit' => 50,
            'offset' => 0,
        ];

        try {
            $ps = SmtpSdk::create(smtp_com_mail::get_options_sc('smtp_apikey'));
            $response = $ps->messages(smtp_com_mail::get_options_sc('smtp_channelname'))->index($parameters);
            $messages = $response->getItems();
            if (empty($messages)) {
                $resultMess = "<span class='message_settings__smtp'>Messages have not been sent from ". date($dateFormatWP, strtotime($dateFrom)) ." to ". date($dateFormatWP, strtotime($dateEnd)) ."</span>";
            } else {
                $countMessage = count($messages);
                if ($countMessage >= 50) {
                    $resultMess = "<span class='message_settings__smtp'>First 50 messages have been sent from " . date($dateFormatWP, strtotime($dateFrom)) . " to " . date($dateFormatWP, strtotime($dateEnd)) . "</span>";
                } else {
                    $resultMess = "<span class='message_settings__smtp'>". $countMessage ." messages have been sent from " . date($dateFormatWP, strtotime($dateFrom)) . " to " . date($dateFormatWP, strtotime($dateEnd)) . "</span>";
                }
                foreach ($messages as $message) {
                    $dateMessage = date($dateFormatWP . ' ' . $timeFormatWP, strtotime($message->getDetails()["delivery"]["finished"]));
                    $resultMess .= '
            <div class="item_block_recent_deliveries">
                <div class="block_recent_deliveries_id sub_item_recent_deliveries">'
                        . htmlspecialchars($message->getMsgData()['from']) .
                        '</div>
                <div class="block_recent_deliveries_id sub_item_recent_deliveries">'
                        . htmlspecialchars($message->getMsgData()['rcpt_to']) .
                        '</div>
                <div class="block_recent_deliveries_id sub_item_recent_deliveries">'
                        . htmlspecialchars($message->getMsgData()["subject"]) .
                        '</div>
                <div class="block_recent_deliveries_id sub_item_recent_deliveries">'
                        . $dateMessage .
                        '</div>
            </div>';
                }
            }
        } catch (Exception $e) {
            $headerMess = "";
            $resultMess = "
            <div class='setup_settings__smtp'>
                <span class='message_settings__smtp setup_settings__smtp'>Set up API settings.</span>
            </div>";
        }
        _e($resultMess, 'smtp-com-mail');
    }
}

if ( !function_exists( 'smtpcom_mail_sanitizeData' ) ) {
    function smtpcom_mail_sanitizeData($data)
    {
        try {
            if(!check_ajax_referer('wp_ajax_settings_smtp', false, false)) {
                throw new Exception("Error Processing Request", 1);
            }
        } catch (Exception $e) {
            echo esc_attr('Access denied');
            wp_die();
        }

        return [
            'action' => sanitize_text_field($data['action']),
            'sendVia' => sanitize_text_field($data['sendVia']),
            'apikey' => sanitize_key($data['apikey']),
            'channelname' => sanitize_text_field($data['channelname']),
            'smtpServer' => SEND_HOST_SMTP,
            'smtpPorts' => intval($data['smtpPorts']),
            'smtpSecurity' => sanitize_text_field($data['smtpSecurity']),
            'smtpEnc' => sanitize_text_field($data['smtpEnc']),
            'smtpLogin' => sanitize_text_field($data['smtpLogin']),
            'smtpPass' => sanitize_text_field($data['smtpPass']),
        ];
    }
}

if ( !function_exists( 'smtpcom_mail_saveSettings' ) ) {
    function smtpcom_mail_saveSettings($sanitizedData)
    {
        try {
            smtp_com_mail::update_options_sc('smtp_api', $sanitizedData['sendVia']);
            smtp_com_mail::update_options_sc('smtp_apikey', $sanitizedData['apikey']);
            smtp_com_mail::update_options_sc('smtp_channelname', $sanitizedData['channelname']);
            smtp_com_mail::update_options_sc('smtp_server', $sanitizedData['smtpServer']);
            smtp_com_mail::update_options_sc('smtp_port', $sanitizedData['smtpPorts']);
            smtp_com_mail::update_options_sc('smtp_security', $sanitizedData['smtpSecurity']);
            smtp_com_mail::update_options_sc('smtp_encryption', $sanitizedData['smtpEnc']);
            smtp_com_mail::update_options_sc('smtp_login', $sanitizedData['smtpLogin']);
            smtp_com_mail::update_options_sc('smtp_password', $sanitizedData['smtpPass']);
        } catch (Exception $e) {
            return 0;
        }
        return 1;
    }
}