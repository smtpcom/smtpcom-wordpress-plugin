<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       http://smtp.com
 * @since      1.0.0
 *
 * @package    smtp_com_mail
 */

// If uninstall not called from WordPress, then exit.
if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}
global $wpdb;
$sc_table_name = $wpdb->prefix . 'smtp_com_mail';
$sqlDrop = "DROP TABLE IF EXISTS $sc_table_name";
$wpdb->query($sqlDrop);