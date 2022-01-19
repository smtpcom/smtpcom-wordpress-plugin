<?php

use SmtpSdk\SmtpSdk;
/**
 * Settings on plugin main page
 *
 *
 * @since    1.0.0
 */
if ( !function_exists( 'smtpcom_mail_add_options_page' ) ) {
    function smtpcom_mail_add_options_page()
    {
        add_options_page(
            'SMTP Settings',
            'SMTP.com',
            'manage_options',
            'smtpcommail-setting',
            'smtpcom_mail_setting_display'
        );
    }
    add_action('admin_menu', 'smtpcom_mail_add_options_page');
}

if ( !function_exists( 'smtpcom_mail_setting_display' ) ) {
    function smtpcom_mail_setting_display()
    {   
        //Use with wp_kses()
        $smtp_allowedHTML = 
        array(
            'div' => array(
                'class' => true,
                'style' => true,
                'data-dateformat' => true
            ),
            'label' => array(
                'for' => true,
                'class' => true,
            ),
            'input' => array(
                'type' => true,
                'id' => true,
                'name' => true,
                'autocomplete' => true,
                'readonly' => true,
                'value' => true
            ),
            'img' => array(
                'src' => true,
                'alt' => true
            ),
            'span' => array(
                'class'=> true, 
            )
        );

        $ps = SmtpSdk::create(smtp_com_mail::get_options_sc('smtp_apikey'));
        $dateFormatWP = get_option('date_format');
        $timeFormatWP = get_option('time_format');
        $dateFrom = date($dateFormatWP);
        $dateFromStandart = date($dateFormatWP, strtotime(date('Y-m-d') . '-6 days'));
        $dateEnd = date($dateFormatWP);
        $headerMessDisplay = 'none';

        if (version_compare(phpversion(), '7.2', '<')) {
            $startDate = date(DateTime::RFC2822, strtotime(date('Y-m-d 00:00:00', strtotime('-6 days'))));
            $endDate = date(DateTime::RFC2822, strtotime(date('Y-m-d') . ' 23:59:59'));
        } else {
            $startDate = date(DateTimeInterface::RFC2822, strtotime(date('Y-m-d 00:00:00', strtotime("-6 days"))));
            $endDate = date(DateTimeInterface::RFC2822, strtotime(date('Y-m-d 23:59:59')));
        }

        /**
         * Get recent deliveries from SMTP.com API
         *
         *
         * @since    1.0.0
         */
        try {
            $channelName = smtp_com_mail::get_options_sc('smtp_channelname');

            $response = $ps->messages($channelName)->index([
                'start'  => $startDate,
                'end'    => $endDate,
                'event'  => array('accepted', 'failed', 'delivered'),
                'limit'  => 50,
                'offset' => 0,
            ]);
            $messages = $response->getItems();
            if (empty($messages)) {
                $resultMess = "<span class='message_settings__smtp mess_not_found'>Messages don't exist for last 7 days.</span>";
            } else {
                $countMessage = count($messages);
                if ($countMessage >= 50) {
                    $resultMess = "<span class='message_settings__smtp'>First 50 messages have been sent from " . date($dateFormatWP, strtotime($dateFromStandart)) . " to " . date($dateFormatWP, strtotime($dateEnd)) . "</span>";
                } else {
                    $resultMess = "<span class='message_settings__smtp'>". $countMessage ." messages have been sent from " . date($dateFormatWP, strtotime($dateFromStandart)) . " to " . date($dateFormatWP, strtotime($dateEnd)) . "</span>";
                }
                $headerMessDisplay = 'flex';
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
            $resultMess = "<span class='message_settings__smtp setup_settings__smtp'>Set up API settings.</span>";
        }

        $headerMess = '
        <div class="date_block__smtp" style="display: ' . $headerMessDisplay . ';" data-dateformat="' . $dateFormatWP . '" >
            <div class="item_date_block__smtp">
                <label for="date_from__smtp">Start Date</label>
                <input type="text" id="date_from__smtp" name="date_from__smtp" autocomplete="off" readonly value="' .$dateFromStandart . '">
                <label for="date_from__smtp" class="calendar_icon__smtp"><img src="'.  plugin_dir_url(dirname(__FILE__)) . 'admin/images/calendar.gif" alt=""></label>
            </div>
            <div class="item_date_block__smtp">
                <label for="date_end__smtp">End Date</label>
                <input type="text" id="date_end__smtp" name="date_end__smtp" autocomplete="off" readonly  value="' .$dateEnd . '">
                <label for="date_end__smtp" class="calendar_icon__smtp"><img src="'.  plugin_dir_url(dirname(__FILE__)) . 'admin/images/calendar.gif" alt=""></label>
            </div>
        </div>
    <div class="item_block_recent_deliveries header_block__smtp" style="display: '.$headerMessDisplay.';">
                <div class="block_recent_deliveries_id sub_item_recent_deliveries">From</div>
                <div class="block_recent_deliveries_id sub_item_recent_deliveries">To</div>
                <div class="block_recent_deliveries_id sub_item_recent_deliveries">Subject</div>
                <div class="block_recent_deliveries_id sub_item_recent_deliveries">Date</div>
            </div>';

        /**
         * Show main settings on plugin main page
         *
         *
         * @since    1.0.0
         */
        ?>
        <h1 class="title__smtp">
            <img src="<?php echo plugin_dir_url(dirname(__FILE__)) ?>admin/images/logoSMTP.png" alt="logoSMTP">
        </h1>

        <div class="tabs_title__smtp">
            <div class="item-tabs_title__smtp item-tabs_settings__smtp active__smtp">
                <?php _e('Mail Settings', 'smtp-com-mail'); ?>
            </div>
            <div class="item-tabs_title__smtp item-tabs_recent__smtp">
                <?php _e('Recent deliveries', 'smtp-com-mail'); ?>
            </div>
        </div>

        <div class="block_setting__smtp">
            <form action="#" id="saveSettings__smtp">
                <?php wp_nonce_field('wp_ajax_settings_smtp'); ?>
                <?php 
                /**
                 * Settings SMTP on plugin main page
                 *
                 *
                 * @since    1.0.0
                 */
                ?>
                <div class="main_item_block_settings__smtp">
                    <div class="item_block_settings__smtp"><?php _e('Send Via:', 'smtp-com-mail'); ?></div>
                    <div class="item_block_settings__smtp">
                        <select name="sendVia" id="sendVia">
                            <?php echo smtp_com_mail::optionsArray(array('api', 'smtp'), 'smtp_api'); ?>
                        </select>
                    </div>
                </div>

                <?php
                /**
                 * Settings SMTP.com API on plugin main page
                 *
                 *
                 * @since    1.0.0
                 */
                ?>
                <div class="block_api__smtp <?php if (smtp_com_mail::get_options_sc('smtp_api') == 'api') {
                    echo esc_attr('show');
                } ?>">
                    <div class="main_item_block_settings__smtp">
                        <div class="item_block_settings__smtp"><?php _e('API Key', 'smtp-com-mail'); ?>*:</div>
                        <div class="item_block_settings__smtp">
                            <span class="show-pass"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)"><path d="M12.3567 7.64141C12.1942 7.47891 11.93 7.47891 11.7675 7.64141C11.605 7.80391 11.605 8.06891 11.7675 8.23058C12.2392 8.70226 12.5 9.32976 12.5 9.99808C12.5 11.3764 11.3784 12.4981 10 12.4981C9.33172 12.4981 8.70422 12.2381 8.23254 11.7656C8.07004 11.6031 7.80586 11.6031 7.64336 11.7656C7.48086 11.9273 7.48086 12.1923 7.64336 12.3548C8.27168 12.9848 9.10918 13.3314 10 13.3314C11.8384 13.3314 13.3334 11.8364 13.3334 9.99812C13.3334 9.10723 12.9867 8.26973 12.3567 7.64141Z" fill="#C2C1D1"></path><path d="M10.5811 6.72352C10.392 6.6902 10.1986 6.66602 10.0003 6.66602C8.16199 6.66602 6.66699 8.16101 6.66699 9.99933C6.66699 10.1976 6.69117 10.391 6.72531 10.5801C6.76113 10.7818 6.93699 10.9243 7.13449 10.9243C7.15867 10.9243 7.18281 10.9226 7.20781 10.9176C7.43363 10.8776 7.58531 10.661 7.54531 10.4351C7.51949 10.2935 7.50031 10.1493 7.50031 9.99933C7.50031 8.62101 8.62199 7.49933 10.0003 7.49933C10.1503 7.49933 10.2945 7.51851 10.4361 7.54351C10.6578 7.58851 10.8786 7.43183 10.9186 7.20601C10.9586 6.98019 10.807 6.76352 10.5811 6.72352Z" fill="#C2C1D1"></path><path d="M19.9004 9.7301C19.8062 9.61842 17.5521 6.9876 14.4429 5.37679C14.2413 5.27097 13.9871 5.35097 13.8813 5.55597C13.7754 5.76015 13.8554 6.01179 14.0604 6.11765C16.4554 7.35764 18.3687 9.29264 19.0229 9.99932C18.0296 11.0751 14.1204 14.9993 9.99962 14.9993C8.60131 14.9993 7.19213 14.6618 5.80963 13.9951C5.60463 13.8943 5.35381 13.9818 5.25381 14.1893C5.15299 14.396 5.24049 14.6451 5.44799 14.7451C6.94381 15.4676 8.47549 15.8326 9.99966 15.8326C15.1338 15.8326 19.7088 10.496 19.9013 10.2685C20.0329 10.1134 20.0321 9.88592 19.9004 9.7301Z" fill="#C2C1D1"></path><path d="M12.7342 4.64601C11.7859 4.32684 10.8659 4.16602 10 4.16602C4.86587 4.16602 0.290876 9.50269 0.0983768 9.73019C-0.0233027 9.87351 -0.0333027 10.0819 0.0750565 10.2377C0.132556 10.3202 1.51005 12.276 3.89755 13.8619C3.96837 13.9094 4.04755 13.9319 4.12755 13.9319C4.26173 13.9319 4.39423 13.8669 4.47423 13.7444C4.60173 13.5535 4.54923 13.2944 4.35755 13.1677C2.60423 12.0019 1.40423 10.5944 0.955055 10.0219C1.91423 8.98019 5.84923 4.99937 10 4.99937C10.7759 4.99937 11.6067 5.14605 12.4684 5.43519C12.6867 5.51351 12.9234 5.39269 12.9959 5.17351C13.0692 4.95519 12.9525 4.71937 12.7342 4.64601Z" fill="#C2C1D1"></path><path d="M17.3777 2.62187C17.2152 2.45938 16.951 2.45938 16.7885 2.62187L2.62187 16.7885C2.45938 16.951 2.45938 17.2152 2.62187 17.3777C2.70355 17.4585 2.81019 17.4994 2.91687 17.4994C3.02355 17.4994 3.13019 17.4586 3.21105 17.3777L17.3777 3.21105C17.5402 3.04855 17.5402 2.78437 17.3777 2.62187Z" fill="#C2C1D1"></path></g><defs><clipPath id="clip0"><rect width="20" height="20" fill="white"></rect></clipPath></defs></svg></span>
                            <input type="password" name="apikey" id="apikey" placeholder="<?php _e('Enter API key', 'smtp-com-mail'); ?>"
                                value="<?php echo esc_textarea(smtp_com_mail::get_options_sc('smtp_apikey')); ?>">
                            <p class="error_mess__smtp API_empty" style="display: none;"><?php _e('The API key is empty', 'smtp-com-mail'); ?></p>
                            <p class="error_mess__smtp API_invalid" style="display: none;"><?php _e('The API key is invalid', 'smtp-com-mail'); ?></p>
                        </div>
                    </div>
                    <div class="main_item_block_settings__smtp">
                        <div class="item_block_settings__smtp"><?php _e('Channel Name', 'smtp-com-mail'); ?>*:</div>
                        <div class="item_block_settings__smtp">
                            <input type="text" name="channelname" id="channelname"
                                placeholder="<?php _e('Enter Channel/Sender name', 'smtp-com-mail'); ?>"
                                value="<?php echo esc_textarea(smtp_com_mail::get_options_sc('smtp_channelname')); ?>">
                            <p class="error_mess__smtp channel_empty" style="display: none;"><?php _e('The channel name is empty', 'smtp-com-mail'); ?></p>
                            <p class="error_mess__smtp channel_invalid" style="display: none;"><?php _e('The channel name is not correct', 'smtp-com-mail'); ?></p>
                            <p class="error_mess__smtp port_443" style="display: none;"><?php _e('Port '.API_PORT.' is closed by host', 'smtp-com-mail'); ?></p>
                            <p class="signature__smtp"><?php _e('also known as sender name', 'smtp-com-mail'); ?></p>
                        </div>
                    </div>
                </div>


                <div class="block_smtp__smtp <?php if (smtp_com_mail::get_options_sc('smtp_api') == 'smtp') {
                    echo esc_attr('show');
                } ?>">
                    <div class="main_item_block_settings__smtp">
                        <div class="item_block_settings__smtp"><?php _e('SMTP Server:', 'smtp-com-mail'); ?></div>
                        <div class="item_block_settings__smtp">
                            <input type="text" name="smtpServer" id="smtpServer" value="send.smtp.com" readonly>
                        </div>
                    </div>
                    <div class="main_item_block_settings__smtp">
                        <div class="item_block_settings__smtp"><?php _e('SMTP Port(s):', 'smtp-com-mail'); ?></div>
                        <div class="item_block_settings__smtp">
                            <?php
                            $ports = array(25, 80, 2525, 25025, 2082);
                            $avaliblePorts = array();

                            foreach ($ports as $port) {
                                $connection = @fsockopen(SEND_HOST_SMTP, $port, $errno, $errstr, $timeout = 1);
                                if (is_resource($connection)) {
                                    $avaliblePorts[] += $port;
                                    fclose($connection);
                                }
                            }
                            ?>
                            <select name="smtpPorts" id="smtpPorts">
                                <?php
                                $messageShow = 'none';
                                if (!empty($avaliblePorts)) {
                                    echo smtp_com_mail::optionsArray($avaliblePorts, 'smtp_port');
                                } else {
                                    if (smtp_com_mail::get_options_sc('smtp_security') != 'ssl') {
                                        $messageShow = 'block';
                                    }
                                }
                                ?>
                            </select>
                            <p class="error_mess__smtp active_ports" style="display: <?php echo $messageShow; ?>;">
                                <?php _e('All ports are closed by host', 'smtp-com-mail'); ?>
                            </p>
                            <p class="error_mess__smtp active_one_port" style="display: <?php echo $messageShow; ?>;">
                                <?php _e('Port was closed by host', 'smtp-com-mail'); ?>
                            </p>
                        </div>
                    </div>
                    <div class="main_item_block_settings__smtp">
                        <div class="item_block_settings__smtp"><?php _e('Security:', 'smtp-com-mail'); ?></div>
                        <div class="item_block_settings__smtp">
                            <select name="smtpSecurity" id="smtpSecurity">
                                <?php echo smtp_com_mail::optionsArray(array('None', 'STARTTLS', 'SSL'), 'smtp_security'); ?>
                            </select>
                            <p class="error_mess__smtp ssl_port" style="display: none;">
                                <?php _e('The SSL security works only with 465 port', 'smtp-com-mail'); ?>
                            </p>
                        </div>
                    </div>
                    <div class="main_item_block_settings__smtp">
                        <div class="item_block_settings__smtp"><?php _e('Encryption:', 'smtp-com-mail'); ?></div>
                        <div class="item_block_settings__smtp">
                            <select name="smtpEnc" id="smtpEnc">
                                <?php echo smtp_com_mail::optionsArray(array('PLAIN', 'LOGIN', 'DIGEST-MD5'), 'smtp_encryption'); ?>
                            </select>
                        </div>
                    </div>
                    <div class="main_item_block_settings__smtp">
                        <div class="item_block_settings__smtp"><?php _e('SMTP Login:', 'smtp-com-mail'); ?></div>
                        <div class="item_block_settings__smtp">
                            <input type="text" name="smtpLogin" id="smtpLogin"
                                value="<?php echo esc_textarea(smtp_com_mail::get_options_sc('smtp_login')); ?>">
                        </div>
                    </div>
                    <div class="main_item_block_settings__smtp">
                        <div class="item_block_settings__smtp"><?php _e('SMTP Password:', 'smtp-com-mail'); ?></div>
                        <div class="item_block_settings__smtp">
                            <input type="password" name="smtpPass" id="smtpPass"
                                value="<?php echo esc_textarea(smtp_com_mail::get_options_sc('smtp_password')); ?>">
                            <p class="error_mess__smtp smtp_failed" style="display: none;"><?php _e('SMTP configuration is incorrect', 'smtp-com-mail'); ?></p>
                        </div>
                    </div>
                </div>

                <div class="main_item_block_settings__smtp">
                    <div class="item_block_settings__smtp">
                        <button type="button" id="saveSettings_smtp" class="submitSettings"><?php _e('Save Settings', 'smtp-com-mail'); ?></button>
                    </div>
                    <div class="item_block_settings__smtp">
                        <button type="button" id="send_test_smtp_com" class="testEmailSettings"><?php _e('Send Test Email', 'smtp-com-mail'); ?></button>
                    </div>
                </div>
            </form>
            <?php
            /**
             * Support info plugin SMTP.com
             *
             *
             * @since    1.0.0
             */
            ?>
            <div class="bonus-info__smtp">
                <p>
                    <?php
                    echo sprintf(
                        __('Read our %1$s Wordpress Plugin Setup Guide %2$s if you need help or reach out to our
                        Support Team via email address support@smtp.com'),
                        '<a href="https://kb.smtp.com/article/2137-wp-plugin" target="_blank">',
                        '</a>'
                    );
                    ?>
                <p><?php _e('Create your own account with SMTP.com to send emails from 
                your Wordpress website.', 'smtp-com-mail'); ?></p>
                <p><?php _e('The setup is easy and you can get the first month for free. 
                Plans start at $25 per month after that.', 'smtp-com-mail'); ?></p>
                <p>
                    <?php
                    echo sprintf(
                        __('Go to %1$s to register right now or read about %2$s offers %3$s here. %4$s'),
                        '<a href="https://registration.smtp.com/?afid=wpplugin" target="_blank">SMTP.com website</a>',
                        '<a href="https://www.smtp.com/" target="_blank">SMTP.com</a>',
                        '<a href="https://www.smtp.com/pricing/" target="_blank">',
                        '</a>'
                    );
                    ?>
                </p>

            </div>
        </div>
        <?php
        /**
         * Block recent deliveries
         *
         *
         * @since    1.0.0
         */
        ?>

        <div class="block_recent_deliveries__smtp" style="display: none">
            <?php echo wp_kses($headerMess, $smtp_allowedHTML); ?>
            <div class="result_message__smtp">
                <?php $resultMess; ?>
            </div>
        </div>
        <?php
        /**
         * Modal for report
         *
         *
         * @since    1.0.0
         */
        ?>
        <div class="block_modal__smtp" style="display: none">
            <div class="background_modal__smtp"></div>
            <div class="modal__smtp">
                <button class="close_modal__smtp">x</button>
                <p class="message_modal__smtp"><?php _e('Thanks, settings have been saved!', 'smtp-com-mail'); ?></p>
            </div>
        </div>
        <?php
    }
}