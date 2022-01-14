<?php

/**
 * Fired during plugin activation
 *
 * @link  http://smtp.com
 * @since 1.0.0
 *
 * @package    smtp_com_mail
 * @subpackage smtp_com_mail/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    smtp_com_mail
 * @subpackage smtp_com_mail/includes
 * @author     Your Name <email@example.com>
 */
class smtp_com_mail_Activator
{
    /**
     * Create table smtp_com_mail and add options on plugin active
     *
     * @since 1.0.0
     */
    public static function activate()
    {
    }
    public static function createTable()
    {
        global $wpdb;
        $sc_table_name = $wpdb->prefix . 'smtp_com_mail';
        $xmlitua_sql = "CREATE TABLE $sc_table_name (
          id int(11) NOT NULL AUTO_INCREMENT,
          option_name varchar(255) NOT NULL,
          option_value varchar(255) NOT NULL,
          UNIQUE KEY id (id)
        );";
        include_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($xmlitua_sql);

        smtp_com_mail::add_options_sc('smtp_api');
        smtp_com_mail::add_options_sc('smtp_apikey');
        smtp_com_mail::add_options_sc('smtp_channelname');
        smtp_com_mail::add_options_sc('smtp_server');
        smtp_com_mail::add_options_sc('smtp_port');
        smtp_com_mail::add_options_sc('smtp_security');
        smtp_com_mail::add_options_sc('smtp_encryption');
        smtp_com_mail::add_options_sc('smtp_login');
        smtp_com_mail::add_options_sc('smtp_password');
        smtp_com_mail::update_options_sc('smtp_api', 'api');
    }
}
