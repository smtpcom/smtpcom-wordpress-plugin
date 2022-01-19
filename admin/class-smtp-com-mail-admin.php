<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link  http://smtp.com
 * @since 1.0.0
 *
 * @package    smtp_com_mail
 * @subpackage smtp_com_mail/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    smtp_com_mail
 * @subpackage smtp_com_mail/admin
 * @author     Your Name <email@example.com>
 */
class smtp_com_mail_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $smtp_com_mail    The ID of this plugin.
     */
    private $smtp_com_mail;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     * @param string $smtp_com_mail The name of this plugin.
     * @param string $version       The version of this plugin.
     */
    public function __construct($smtp_com_mail, $version)
    {

        $this->smtp_com_mail = $smtp_com_mail;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since 1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in smtp_com_mail_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The smtp_com_mail_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style(
            'datepicker', plugin_dir_url(__FILE__) .
            'css/datepicker.css', array(), $this->version, 'all'
        );
        wp_enqueue_style(
            $this->smtp_com_mail, plugin_dir_url(__FILE__) .
            'css/smtp-com-mail-admin.css', array(), $this->version, 'all'
        );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in smtp_com_mail_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The smtp_com_mail_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script('datepicker', plugin_dir_url(__FILE__) . 'js/datepicker.js', array(  ), $this->version, false);
        wp_enqueue_script(
            $this->smtp_com_mail, plugin_dir_url(__FILE__) .
            'js/smtp-com-mail-admin.js', array( 'jquery' ), $this->version, false
        );
    }
}
