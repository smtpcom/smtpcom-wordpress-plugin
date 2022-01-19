<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use SmtpSdk\SmtpSdk;

class smtp_com_action_mail
{
    public function init_smtp_com()
    {
        /**
         * ReInit mail from field
        *
        * @since 1.0.0
        */
        
        if (!function_exists('wp_mail_from_smtp')) {
            add_filter('wp_mail_from', 'wp_mail_from_smtp');
            function wp_mail_from_smtp( $from_email )
            {
                try {
                    $phpmailer = new PHPMailer(true);
                    $phpmailer->setFrom($from_email, '', false);
                } catch (Exception $e) {
                    $from_email = get_option('admin_email');
                }

                return $from_email;
            }
        }
        /**
         * ReInit phpmailer for custom SMTP settings
         *
         * @since 1.0.0
         */
        if (!function_exists('phpmailer_init_smtp')) {
            add_action('phpmailer_init', 'phpmailer_init_smtp', 10, 1);
            function phpmailer_init_smtp($phpmailer)
            {
                if (smtp_com_mail::get_options_sc('smtp_api') == 'smtp') {
                    $phpmailer->IsSMTP();
                    $phpmailer->CharSet = 'utf-8';
                    if (smtp_com_mail::get_options_sc('smtp_security') == 'none') {
                        $phpmailer->SMTPSecure = false;
                        $phpmailer->SMTPAutoTLS = false;
                    } elseif (smtp_com_mail::get_options_sc('smtp_security') == 'starttls') {
                        $phpmailer->SMTPSecure = 'tls';
                    } else {
                        $phpmailer->SMTPSecure = smtp_com_mail::get_options_sc('smtp_security');
                    }
                    $phpmailer->Host = smtp_com_mail::get_options_sc('smtp_server');
                    $phpmailer->Port = smtp_com_mail::get_options_sc('smtp_port');

                    $phpmailer->SMTPAuth = true;
                    $phpmailer->Username = smtp_com_mail::get_options_sc('smtp_login');
                    $phpmailer->Password = smtp_com_mail::get_options_sc('smtp_password');
                }
            }
        }
        /**
         * Catch wp_mail() errors
         *
         * @since 1.0.0
         */
        add_action(
            'wp_mail_failed', function ($error) {
                if (smtp_com_mail::get_options_sc('smtp_port') == API_PORT) {
                    $connection = fsockopen("ssl://" . HOST_SMTP, API_PORT, $errno, $errstr, $timeout = 1);
                } else {
                    $connection = @fsockopen(SEND_HOST_SMTP, smtp_com_mail::get_options_sc('smtp_port'), $errno, $errstr, $timeout = 1);
                }
                if (is_resource($connection)) {
                    fclose($connection);
                    _e('SMTP login or password is incorrect', 'smtp-com-mail');
                } else {
                    _e('Port was closed by host', 'smtp-com-mail');
                }
            }
        );
    }
}
