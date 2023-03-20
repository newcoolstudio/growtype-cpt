<?php

class Growtype_Cpt_Crud
{
    public function __construct()
    {
        $this->cpt_keys = Growtype_Cpt::get_keys();

        add_action('init', array ($this, 'growtype_extended_cpt_register'));

        add_action('template_redirect', array ($this, 'growtype_extended_cpt_template_redirect'));

        foreach ($this->cpt_keys as $cpt_key) {
            $cpt_name = $this->get_cpt_name($cpt_key['value']);
            add_filter('manage_' . $cpt_name . '_posts_columns', array ($this, 'growtype_extended_cpt_extra_columns'));
            add_action('manage_' . $cpt_name . '_posts_custom_column', array ($this, 'growtype_extended_cpt_custom_extra_columns'), 10, 2);
        }

        add_filter('growtype_customizer_extend_available_pages', array ($this, 'extend_available_pages'), 1);
    }

    function extend_available_pages($customizer_available_pages)
    {
        foreach (Growtype_Cpt::get_active_post_types() as $active_post_type) {
            $customizer_available_pages[$active_post_type['value']] = 'CPT - ' . $active_post_type['label'];
        }

        return $customizer_available_pages;
    }

    /**
     * @param $key_value
     * @return string
     */
    function get_cpt_name($key_value)
    {
        $cpt_name = get_option($key_value . '_value');
        $cpt_name = str_replace(' ', '_', $cpt_name);
        $cpt_name = strtolower($cpt_name);

        return $cpt_name;
    }

    /**
     * @param $columns
     * @return mixed
     * Custom columns
     */
    function growtype_extended_cpt_extra_columns($columns)
    {
        $columns = apply_filters('growtype_extended_cpt_extra_columns', $columns);

        return $columns;
    }

    /**
     * @param $column
     * @param $post_id
     * @return void
     * Custom column values
     */
    function growtype_extended_cpt_custom_extra_columns($column, $post_id)
    {
        apply_filters('growtype_extended_cpt_custom_extra_columns', $column, $post_id);
    }

    /**
     * @return void
     */
    function growtype_extended_cpt_register()
    {
        foreach ($this->cpt_keys as $cpt_key) {

            $key_name = $cpt_key['name'];
            $key_value = $cpt_key['value'];

            $enabled = get_option($key_value . '_enabled');

            if (!$enabled || empty($key_name) || empty($key_value)) {
                continue;
            }

            $cpt_name = $this->get_cpt_name($key_value);
            $cpt_label = get_option($key_value . '_label');

            if (empty($cpt_name) || !$cpt_name || empty($cpt_label) || !$cpt_label) {
                continue;
            }

            $cpt_slug = get_option($key_value . '_slug') ? get_option($key_value . '_slug') : $cpt_name;

            $archive_enabled = get_option($key_value . '_archive_enabled') ? true : false;

            $tags_enabled = get_option($key_value . '_tags_enabled') ? true : false;

            $pt_args = array (

                # Add the post type to the site's main RSS feed:
                'show_in_feed' => false,

                'has_archive' => $archive_enabled, //Hides archive page

                'show_in_rest' => true,

//        'menu_icon' => 'dashicons-admin-users',

//        'menu_position' => 4,

                'supports' => array ('title', 'thumbnail', 'editor', 'page-attributes', 'excerpt', 'author', 'custom-fields'),

                'taxonomies' => $tags_enabled ? array ('post_tag') : [],

                'hierarchical' => true,

                # Show all posts on the post type archive:
                'archive' => array (
                    'nopaging' => true,
                    'order_by' => 'menu_order',
                ),

                # Add some custom columns to the admin screen:
                'admin_cols' => [
                    'post_modified' => [
                        'title' => 'Last Modified',
                        'post_field' => 'post_modified',
//                        'date_format' => 'Y-m-d'
                    ],
                    $cpt_name . '_tax' => [
                        'taxonomy' => $cpt_name . '_tax'
                    ]
                ],

                'admin_filters' => [
                    $cpt_name . '_tax' => [
                        'taxonomy' => $cpt_name . '_tax'
                    ]
                ],
            );

            $pt_args = apply_filters('growtype_extended_cpt_' . $key_value . '_pt_args', $pt_args, $cpt_name);

            $pt_names = array (
                'singular' => $cpt_label,
                'plural' => $cpt_label,
                'slug' => $cpt_slug
            );

            $pt_names = apply_filters('growtype_extended_cpt_' . $key_value . '_pt_names', $pt_names, $cpt_name);

            /**
             * Register the post type
             */
            register_extended_post_type($cpt_name, $pt_args, $pt_names);

            /**
             * Tax
             */
            $tax_args = array (
                'checked_ontop' => true,
                'dashboard_glance' => true,
                'show_in_rest' => true,
                'admin_cols' => array (
                    'title',
                    'published' => array (
                        'title' => 'Published',
                        'meta_key' => 'published_date',
                        'date_format' => 'd/m/Y'
                    ),
                ),
                'allow_hierarchy' => false
            );

            $tax_args = apply_filters('growtype_extended_cpt_' . $key_value . '_tax_args', $tax_args, $cpt_name);

            $tax_names = array (
                'singular' => 'Category',
                'plural' => 'Categories',
                'slug' => 'categories'
            );

            $tax_names = apply_filters('growtype_extended_cpt_' . $key_value . '_tax_names', $tax_names, $cpt_name);

            /**
             * Register the taxonomy
             */
            register_extended_taxonomy($cpt_name . '_tax', $cpt_name, $tax_args, $tax_names);

            /**
             * Extend post type 1
             */
            apply_filters('growtype_extended_cpt_' . $key_value . '_extend', $cpt_name);
        }
    }

    /**
     * @return void
     */
    function growtype_extended_cpt_template_redirect()
    {


        if (is_single()) {
            foreach ($this->cpt_keys as $cpt_key) {
                $key_value = $cpt_key['value'];

                if (!empty(get_option($key_value . '_value')) && is_singular(get_option($key_value . '_value')) && !get_option($key_value . '_single_page_enabled')) {
                    global $wp_query;
                    $wp_query->posts = [];
                    $wp_query->post = null;
                    $wp_query->set_404();
                    status_header(404);
                    nocache_headers();
                }
            }
        }
    }
}