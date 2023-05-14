<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Growtype_Cpt
 * @subpackage growtype_cpt/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Growtype_Cpt
 * @subpackage growtype_cpt/admin
 * @author     Your Name <email@example.com>
 */
class Growtype_Cpt_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $growtype_cpt The ID of this plugin.
     */
    private $growtype_cpt;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Traits
     */

    /**
     * Initialize the class and set its properties.
     *
     * @param string $growtype_cpt The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($growtype_cpt, $version)
    {
        $this->growtype_cpt = $growtype_cpt;
        $this->version = $version;

        if (is_admin()) {
            /**
             * Load methods
             */
            $this->load_methods();
        }
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->growtype_cpt, GROWTYPE_CPT_URL . 'admin/css/growtype-cpt-admin.css', array (), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->growtype_cpt, GROWTYPE_CPT_URL . 'admin/js/growtype-cpt-admin.js', array ('jquery'), $this->version, false);
    }

    /**
     * Load the required methods for this plugin.
     *
     */
    private function load_methods()
    {
        /**
         * Settings
         */
        require_once GROWTYPE_CPT_PATH . 'admin/methods/settings/index.php';
        $this->methods = new Growtype_Cpt_Admin_Settings();
    }
}
