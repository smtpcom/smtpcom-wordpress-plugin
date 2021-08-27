<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use SmtpSdk\SmtpSdk;

add_action("wp_ajax_saveSettings_smtp", "saveSettings_smtp_function");
function saveSettings_smtp_function()
{
    if ($_POST['action'] == 'saveSettings_smtp') {
        $sendVida = $_POST['sendVia'];
        $apikey = $_POST['apikey'];
        $channelname = $_POST['channelname'];
        $smtpServer = 'send.smtp.com';
        $smtpPorts = $_POST['smtpPorts'];
        $smtpSecurity = $_POST['smtpSecurity'];
        $smtpEnc = $_POST['smtpEnc'];
        $smtpLogin = $_POST['smtpLogin'];
        $smtpPass = $_POST['smtpPass'];
        if ($sendVida == 'api') {
            if (!empty($apikey)) {
                if (!empty($channelname)) {
                    $port = 443;
                    $connection = fsockopen("ssl://" . HOST_SMTP, $port, $errno, $errstr, $timeout = 1);
                    if ($connection) {
                        fclose($connection);
                        try {
                            $ps = SmtpSdk::create($apikey);
                            $ps->keys($apikey)->show();
                            try {
                                $ps->channels($channelname)->show();

                                smtp_com_mail::update_options_sc('smtp_api', $sendVida);
                                smtp_com_mail::update_options_sc('smtp_apikey', $apikey);
                                smtp_com_mail::update_options_sc('smtp_channelname', $channelname);
                                smtp_com_mail::update_options_sc('smtp_server', $smtpServer);
                                smtp_com_mail::update_options_sc('smtp_port', $smtpPorts);
                                smtp_com_mail::update_options_sc('smtp_security', $smtpSecurity);
                                smtp_com_mail::update_options_sc('smtp_encryption', $smtpEnc);
                                smtp_com_mail::update_options_sc('smtp_login', $smtpLogin);
                                smtp_com_mail::update_options_sc('smtp_password', $smtpPass);
                                _e('Thanks, api settings have been saved!', 'smtp-com-mail');

                            } catch (Exception $e) {
                                echo 'channel_invalid';
                            }
                        } catch (Exception $e) {
                            echo 'API_invalid';
                        }
                    } else {
                        echo 'port_443';
                    }
                } else {
                    echo 'channel_empty';
                }
            } else {
                if (empty($channelname)) {
                    echo 'API_channel_empty';
                } else {
                    echo 'API_empty';
                }
            }
        } else {
            global $phpmailer;
            if (!($phpmailer instanceof PHPMailer\PHPMailer\PHPMailer)) {
                require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
                require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
                require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
            }
            $smtp = new SMTP;
//            $smtp->do_debug = SMTP::DEBUG_CONNECTION;
            try {
                //Connect to an SMTP server
                if ($smtpSecurity == 'SSL') {
                    if (!$smtp->connect("ssl://" . SEND_HOST_SMTP, $smtpPorts)) {
                        throw new Exception('Connect failed');
                    }
                } else {
                    if (!$smtp->connect(SEND_HOST_SMTP, $smtpPorts)) {
                        throw new Exception('Connect failed');
                    }
                }
                if (!$smtp->hello(gethostname())) {
                    throw new Exception('EHLO failed: ' . $smtp->getError()['error']);
                }
                $e = $smtp->getServerExtList();
                if ($smtpSecurity == 'STARTTLS') {
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
                    if ($smtp->authenticate($smtpLogin, $smtpPass)) {
                        smtp_com_mail::update_options_sc('smtp_api', $sendVida);
                        smtp_com_mail::update_options_sc('smtp_apikey', $apikey);
                        smtp_com_mail::update_options_sc('smtp_channelname', $channelname);
                        smtp_com_mail::update_options_sc('smtp_server', $smtpServer);
                        smtp_com_mail::update_options_sc('smtp_port', $smtpPorts);
                        smtp_com_mail::update_options_sc('smtp_security', $smtpSecurity);
                        smtp_com_mail::update_options_sc('smtp_encryption', $smtpEnc);
                        smtp_com_mail::update_options_sc('smtp_login', $smtpLogin);
                        smtp_com_mail::update_options_sc('smtp_password', $smtpPass);
                        _e('Thanks, settings have been saved!', 'smtp-com-mail');
                    } else {
                        throw new Exception('Authentication failed: ' . $smtp->getError()['error']);
                    }
                }
            } catch (Exception $e) {
                _e('SMTP error: ' . $e->getMessage(), 'smtp-com-mail');
            }
        }
    }
    wp_die();
}

add_action("wp_ajax_send_test_smtp_com", "send_test_smtp_com_function");
function send_test_smtp_com_function()
{
    if ($_POST['action'] == 'send_test_smtp_com') {
        $sendVida = $_POST['sendVia'];
        $apikey = $_POST['apikey'];
        $channelname = $_POST['channelname'];
        $smtpServer = 'send.smtp.com';
        $smtpPorts = $_POST['smtpPorts'];
        $smtpSecurity = $_POST['smtpSecurity'];
        $smtpEnc = $_POST['smtpEnc'];
        $smtpLogin = $_POST['smtpLogin'];
        $smtpPass = $_POST['smtpPass'];
        global $current_user;
        get_currentuserinfo();
        if (empty($smtpPorts)) {
            $smtpPorts = 0;
        }
        $to = (string) $current_user->user_email;
        $subject = 'Hello from your Wordpress Website via SMTP.com';
        $message = __('This email confirms that you have successfully installed your SMTP.com Wordpress Plugin. Congratulations and happy sending!');
        $headers = 'From: ' . FROM_SMTP . " \r\n";
        if ($sendVida == 'api') {
            if (!empty($apikey)) {
                if (!empty($channelname)) {
                    $port = 443;
                    $connection = fsockopen("ssl://" . HOST_SMTP, $port, $errno, $errstr, $timeout = 1);
                    if ($connection) {
                        fclose($connection);
                        try {
                            $ps = SmtpSdk::create($apikey);
                            $ps->keys($apikey)->show();
                            try {
                                $ps->channels($channelname)->show();
                                $ps->messages($channelname)->create(FROM_SMTP, $to, $subject, $message);
                                _e('The test email has been sent!', 'smtp-com-mail');

                            } catch (Exception $e) {
                                echo 'channel_invalid';
                            }
                        } catch (Exception $e) {
                            echo 'API_invalid';
                        }
                    } else {
                        echo 'port_443';
                    }
                } else {
                    echo 'channel_empty';
                }
            } else {
                if (empty($channelname)) {
                    echo 'API_channel_empty';
                } else {
                    echo 'API_empty';
                }
            }
        } else {
            global $phpmailer;
            if (!($phpmailer instanceof PHPMailer\PHPMailer\PHPMailer)) {
                require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
                require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
                require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
                $phpmailer = new PHPMailer(true);
                $phpmailer->IsSMTP();
                $phpmailer->CharSet = 'utf-8';
                if (strtolower($smtpSecurity) == 'none') {
                    $phpmailer->SMTPSecure = false;
                    $phpmailer->SMTPAutoTLS = false;
                } elseif (strtolower($smtpSecurity) == 'starttls') {
                    $phpmailer->SMTPSecure = 'tls';
                } else {
                    $phpmailer->SMTPSecure = strtolower($smtpSecurity);
                }
                $phpmailer->Host = strtolower($smtpServer);
                $phpmailer->Port = strtolower($smtpPorts);
                $phpmailer->SMTPAuth = true;
                $phpmailer->Username = strtolower($smtpLogin);
                $phpmailer->Password = $smtpPass;
                global $current_user;
                get_currentuserinfo();
                $to = (string) $current_user->user_email;
                $phpmailer->setFrom(FROM_SMTP, 'smtp.com');
                $phpmailer->AddAddress($to);
                $phpmailer->Subject = "Hello from your Wordpress Website via SMTP.com";
                $phpmailer->Body = "This email confirms that you have successfully installed your SMTP.com Wordpress Plugin. Congratulations and happy sending!";
            }
            try {
                $connection = @fsockopen(SEND_HOST_SMTP, $smtpPorts, $errno, $errstr, $timeout = 1);
                if (is_resource($connection)) {
                    fclose($connection);
                    $phpmailer->Send();
                    _e('The test email has been sent!', 'smtp-com-mail');
                } else {
                    echo _e('Port was closed by host', 'smtp-com-mail');
                }
            } catch (Exception $e) {
                echo 'smtp_failed';
            }
        }
    }
    wp_die();
}





add_action("wp_ajax_sort_messages__smtp", "sort_messages_smtp_function");
function sort_messages_smtp_function()
{
    if ($_POST['action'] == 'sort_messages__smtp') {
        $dateFrom = $_POST['dateFrom'];
        $dateEnd = $_POST['dateEnd'];
        show_messages($dateFrom, $dateEnd);
    }
    wp_die();
}

function show_messages ($dateFrom, $dateEnd){
    $resultMess = '';
    if (version_compare(phpversion(), '7.2', '<')) {
        $startDate = date(DateTime::RFC2822, strtotime($dateFrom));
        $endDate = date(DateTime::RFC2822, strtotime($dateEnd . ' 23:59:59'));
    } else {
        $startDate = date(DateTimeInterface::RFC2822, strtotime($dateFrom));
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
        $messages = array_reverse($response->getItems());
        if (empty($messages)) {
            $resultMess = "<span class='message_settings__smtp'>Messages have not been sent from ". date('m/d/Y', strtotime($dateFrom)) ." to ". date('m/d/Y', strtotime($dateEnd)) ."</span>";
        } else {
            $countMessage = count($messages);
            if ($countMessage >= 50) {
                $resultMess = "<span class='message_settings__smtp'>First 50 messages have been sent from " . date('m/d/Y', strtotime($dateFrom)) . " to " . date('m/d/Y', strtotime($dateEnd)) . "</span>";
            } else {
                $resultMess = "<span class='message_settings__smtp'>". $countMessage ." messages have been sent from " . date('m/d/Y', strtotime($dateFrom)) . " to " . date('m/d/Y', strtotime($dateEnd)) . "</span>";
            }
            foreach ($messages as $message) {
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
                    . $message->getDetails()["delivery"]["finished"] .
                    '</div>
        </div>';
            }
        }
    } catch (Exception $e) {
        $headerMess = "";
        $resultMess = "<span class='message_settings__smtp'>Set up your SMTP or API settings.</span>";
    }
    _e($resultMess, 'smtp-com-mail');
}