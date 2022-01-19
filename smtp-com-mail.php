<?php

/**
 *
 * @link    http://smtp.com
 * @since   1.0.0
 * @package smtp-com-mail
 *
 * @wordpress-plugin
 * Plugin Name:       SMTP.com
 * Plugin URI:        https://www.smtp.com/
 * Description:       SMTP.com is a powerful and reliable SMTP delivery service that enables you to send and track high volume emails effortlessly.
 * Version:           1.0.0
 * Author:            SMTP.com
 * Author URI:        https://www.smtp.com/about-us/
 * Network:           True
 * License:           GPLv3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}
$GLOBALS['wpmdb_meta']['smtp-com-mail']['version'] = '1.0.0';
/**
 * Currently plugin version.
 * Main constants for plugin
 */

define('smtp_com_mail_VERSION', '1.0.0');
const HOST_SMTP = "api.smtp.com";
const SEND_HOST_SMTP = "send.smtp.com";
const API_PORT = 443;

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-smtp-com-mail-activator.php
 */

if (is_readable(__DIR__ . '/vendor/autoload.php')) {
    include __DIR__ . '/vendor/autoload.php';
}

add_filter('plugin_action_links', 'smtp_com_plugin_action_links', 10, 2);
function smtp_com_plugin_action_links($actions, $plugin_file)
{
    if (false === strpos($plugin_file, basename(__FILE__))) {
        return $actions;
    }

    $settings_link = '<a href="options-general.php?page=smtpcommail-setting' . '">Settings</a>';
    array_unshift($actions, $settings_link);
    return $actions;
}

function activate_smtp_com_mail()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-smtp-com-mail-activator.php';
    smtp_com_mail_Activator::activate();
    smtp_com_mail_Activator::createTable();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-smtp-com-mail-deactivator.php
 */
function deactivate_smtp_com_mail()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-smtp-com-mail-deactivator.php';
    smtp_com_mail_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_smtp_com_mail');
register_deactivation_hook(__FILE__, 'deactivate_smtp_com_mail');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-smtp-com-mail.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */


//smtp_com_mail_Deactivator::settingsPage();


function run_smtp_com_mail()
{

    $plugin = new smtp_com_mail();
    $plugin->run();
}
run_smtp_com_mail();
