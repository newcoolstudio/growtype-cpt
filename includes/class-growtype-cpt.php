<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Growtype_Cpt
 * @subpackage growtype_cpt/includes
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
 * @package    Growtype_Cpt
 * @subpackage growtype_cpt/includes
 * @author     Your Name <email@example.com>
 */
class Growtype_Cpt
{
    public $session = null;

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Growtype_Cpt_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $Growtype_Cpt The string used to uniquely identify this plugin.
     */
    protected $Growtype_Cpt;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * @var null
     */
    protected static $_instance = null;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('GROWTYPE_CPT_VERSION')) {
            $this->version = GROWTYPE_CPT_VERSION;
        } else {
            $this->version = '1.0.0';
        }

        $this->growtype_cpt = 'growtype-cpt';

        $this->load_frontend_traits();
        $this->load_admin_traits();

        $this->load_dependencies();
        $this->set_locale();
        $this->set_session();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Load the required traits for this plugin.
     */
    private function load_frontend_traits()
    {
        /**
         * Frontend traits
         */
        spl_autoload_register(function ($traitName) {
            $fileName = GROWTYPE_CPT_PATH . 'includes/traits/' . $traitName . '.php';

            if (file_exists($fileName)) {
                include $fileName;
            }
        });
    }

    /**
     * Load the required traits for this plugin.
     */
    private function load_admin_traits()
    {
        /**
         * Admin traits
         */
        spl_autoload_register(function ($traitName) {
            $fileName = GROWTYPE_CPT_PATH . 'admin/traits/' . $traitName . '.php';

            if (file_exists($fileName)) {
                include $fileName;
            }
        });
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Growtype_Cpt_Loader. Orchestrates the hooks of the plugin.
     * - Growtype_Cpt_i18n. Defines internationalization functionality.
     * - Growtype_Cpt_Admin. Defines all hooks for the admin area.
     * - Growtype_Cpt_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once GROWTYPE_CPT_PATH . 'includes/class-growtype-cpt-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once GROWTYPE_CPT_PATH . 'includes/class-growtype-cpt-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once GROWTYPE_CPT_PATH . 'admin/class-growtype-cpt-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once GROWTYPE_CPT_PATH . 'public/class-growtype-cpt-public.php';

        $this->loader = new Growtype_Cpt_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Growtype_Cpt_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new Growtype_Cpt_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Growtype_Cpt_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_session()
    {
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Growtype_Cpt_Admin($this->get_growtype_cpt(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Growtype_Cpt_Public($this->get_Growtype_Cpt(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     * @since     1.0.0
     */
    public function get_growtype_cpt()
    {
        return $this->growtype_cpt;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Growtype_Cpt_Loader    Orchestrates the hooks of the plugin.
     * @since     1.0.0
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * @return array[]
     */
    public static function get_keys()
    {
        $default_options = self::get_default_options();

        return [
            [
                'name' => 'Cpt 1',
                'value' => 'cpt_1',
                'options' => $default_options
            ],
            [
                'name' => 'Cpt 2',
                'value' => 'cpt_2',
                'options' => $default_options
            ],
            [
                'name' => 'Cpt 3',
                'value' => 'cpt_3',
                'options' => $default_options
            ],
            [
                'name' => 'Cpt 4',
                'value' => 'cpt_4',
                'options' => $default_options
            ],
            [
                'name' => 'Cpt 5',
                'value' => 'cpt_5',
                'options' => $default_options
            ]
        ];
    }

    /**
     * @return string[][]
     */
    public static function get_default_options()
    {
        return [
            [
                'title' => 'Enabled',
                'name' => 'enabled',
                'type' => 'checkbox',
                'default_value' => ''
            ],
            [
                'title' => 'Value',
                'name' => 'value'
            ],
            [
                'title' => 'Label',
                'name' => 'label',
            ],
            [
                'title' => 'Slug',
                'name' => 'slug'
            ],
            [
                'title' => 'Archive Enabled',
                'name' => 'archive_enabled',
                'type' => 'checkbox'
            ],
            [
                'title' => 'Single Page Enabled',
                'name' => 'single_page_enabled',
                'type' => 'checkbox'
            ],
            [
                'title' => 'Tags Enabled (Same tags for posts)',
                'name' => 'tags_enabled',
                'type' => 'checkbox'
            ]
        ];
    }

    /**
     * @return array
     */
    public static function get_active_post_types()
    {
        $keys = self::get_keys();

        $active_pt = [];
        foreach ($keys as $key) {
            if (isset($key['value'])) {
                $enabled = get_option($key['value'] . '_enabled');
                $value = get_option($key['value'] . '_value');
                $label = get_option($key['value'] . '_label');

                if ($enabled && !empty($value)) {
                    $active_pt[] = [
                        'label' => $label,
                        'value' => $value
                    ];
                }
            }
        }

        return $active_pt;
    }
}
