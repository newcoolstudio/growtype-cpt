<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Growtype_Cpt
 * @subpackage growtype_cpt/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Growtype_Cpt
 * @subpackage growtype_cpt/public
 * @author     Your Name <email@example.com>
 */
class Growtype_Cpt_Public
{

    const GROWTYPE_CPT_AJAX_ACTION = 'growtype_cpt';

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
     * Initialize the class and set its properties.
     *
     * @param string $growtype_cpt The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($growtype_cpt, $version)
    {
        $this->growtype_cpt = $growtype_cpt;
        $this->version = $version;

        add_action('wp_footer', array ($this, 'add_scripts_to_footer'));
    }

    /***
     *
     */
    function add_scripts_to_footer()
    {
        ?>
        <script type="text/javascript">
            window.growtypeSearch = {};
        </script>
        <?php
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public
    function enqueue_styles()
    {
        wp_enqueue_style($this->growtype_cpt, GROWTYPE_CPT_URL_PUBLIC . 'styles/growtype-cpt.css', array (), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->growtype_cpt, GROWTYPE_CPT_URL_PUBLIC . 'scripts/growtype-cpt.js', array ('jquery'), $this->version, true);

        $ajax_url = admin_url('admin-ajax.php');

        if (class_exists('QTX_Translator')) {
            $ajax_url = admin_url('admin-ajax.php' . '?lang=' . qtranxf_getLanguage());
        }

        wp_localize_script($this->growtype_cpt, 'growtype_cpt_ajax', array (
            'url' => $ajax_url,
            'nonce' => wp_create_nonce('ajax-nonce'),
            'action' => self::GROWTYPE_CPT_AJAX_ACTION
        ));
    }

}
