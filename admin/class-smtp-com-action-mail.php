<?php

use SmtpSdk\SmtpSdk;

class smtp_com_action_mail
{
    public function init_smtp_com()
    {
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


        add_action('wp_mail_failed', function ($error) {
            $connection = @fsockopen('send.smtp.com', smtp_com_mail::get_options_sc('smtp_port'), $errno, $errstr, $timeout = 1);
            if (is_resource($connection)) {
                fclose($connection);
                _e('Error SMTP connect failed. Please check settings ', 'smtp-com-mail');
                _e('<a href="' . get_site_url() . '/wp-admin/options-general.php?page=smtpcommail-setting">Here</a>', 'smtp-com-mail');
            } else {
                _e('Port ' . smtp_com_mail::get_options_sc('smtp_port') . ' is closed', 'smtp-com-mail');
            }
        });
    }
}