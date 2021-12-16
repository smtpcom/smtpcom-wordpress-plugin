<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link  http://smtp.com
 * @since 1.0.0
 *
 * @package    smtp_com_mail
 * @subpackage smtp_com_mail/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    smtp_com_mail
 * @subpackage smtp_com_mail/includes
 * @author     Your Name <email@example.com>
 */
class smtp_com_mail
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    smtp_com_mail_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $smtp_com_mail    The string used to uniquely identify this plugin.
     */
    protected $smtp_com_mail;

    /**
     * The current version of the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        if (defined('smtp_com_mail_VERSION')) {
            $this->version = smtp_com_mail_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->smtp_com_mail = 'smtp-com-mail';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - smtp_com_mail_Loader. Orchestrates the hooks of the plugin.
     * - smtp_com_mail_i18n. Defines internationalization functionality.
     * - smtp_com_mail_Admin. Defines all hooks for the admin area.
     * - smtp_com_mail_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since  1.0.0
     * @access private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-smtp-com-mail-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        include_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-smtp-com-mail-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */


        include_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-smtp-com-mail-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */

        include_once plugin_dir_path(dirname(__FILE__)) . 'includes/settings.php';

        include_once plugin_dir_path(dirname(__FILE__)) . 'admin/mail-api.php';

        include_once plugin_dir_path(dirname(__FILE__)) . 'admin/ajax-call.php';

        include_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-smtp-com-action-mail.php';

        $maile = new smtp_com_action_mail();
        $maile->init_smtp_com();
        $this->loader = new smtp_com_mail_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the smtp_com_mail_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since  1.0.0
     * @access private
     */
    private function set_locale()
    {

        $plugin_i18n = new smtp_com_mail_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new smtp_com_mail_Admin($this->get_smtp_com_mail(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     */


    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since 1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since  1.0.0
     * @return string    The name of the plugin.
     */
    public function get_smtp_com_mail()
    {
        return $this->smtp_com_mail;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since  1.0.0
     * @return smtp_com_mail_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since  1.0.0
     * @return string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }




    /**
     * Output array options
     *
     * @since 1.0.0
     */
    public static function optionsArray($options = array(), $optionName = 'default'): string
    {
        $output = '';
        for ($i = 0; $i < count($options); $i++) {
            $output .= '<option '
                . ( smtp_com_mail::get_options_sc($optionName) == strtolower($options[$i]) ? 'selected="selected"' : '' ) . '>'
                . esc_textarea($options[$i])
                . '</option>';
        }
        return $output;
    }
    /**
     * Check standard date format
     *
     * @since 1.0.0
     */
    public static function format_custom_date($format)
    {
        if ($format == 'd.m.Y' || $format == 'Y-m-d' || $format == 'm/d/Y' || $format == 'd/m/Y') {
            return $format;
        } else {
            return 'm/d/y';
        }
    }

    /**
     * Get options from smtp_com_mail table
     *
     * @since 1.0.0
     */
    public static function get_options_sc($option_name)
    {
        global $wpdb;
        $sc_table_name = $wpdb->prefix . 'smtp_com_mail';
        $result = $wpdb->get_row($wpdb->prepare("SELECT option_value FROM $sc_table_name WHERE option_name = %s LIMIT 1", $option_name))->option_value;
        return $result;
    }

    /**
     * Add options to smtp_com_mail table
     *
     * @since 1.0.0
     */
    public static function add_options_sc($option_name, $option_value = '')
    {
        global $wpdb;
        $sc_table_name = $wpdb->prefix . 'smtp_com_mail';
        $exist_option = $wpdb->get_row($wpdb->prepare("SELECT option_name FROM $sc_table_name WHERE option_name = %s LIMIT 1", $option_name));
        if (!$exist_option) {
            $wpdb->query($wpdb->prepare("INSERT INTO $sc_table_name (option_name, option_value) VALUES (%s,%s)", $option_name, $option_value));
        }
    }

    /**
     * Remove options from smtp_com_mail table
     *
     * @since 1.0.0
     */
    public static function remove_options_sc($option_name)
    {
        global $wpdb;
        $sc_table_name = $wpdb->prefix . 'smtp_com_mail';
        $wpdb->delete("$sc_table_name WHERE option_name = %s LIMIT 1", $option_name);
    }

    /**
     * Update options to smtp_com_mail table
     *
     * @since 1.0.0
     */
    public static function update_options_sc($option_name, $option_value)
    {
        global $wpdb;
        $sc_table_name = $wpdb->prefix . 'smtp_com_mail';
        $statement = $wpdb->get_row($wpdb->prepare("SELECT * FROM $sc_table_name WHERE option_name = %s LIMIT 1", $option_name))->id;
        if ($statement) {
            $wpdb->update(
                $sc_table_name,
                array('option_value' => strtolower($option_value)),  // change fields
                array('id' => $statement) // where Id is
            );
        }
    }
}
