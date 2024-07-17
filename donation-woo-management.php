<?php
/**
 *plugin name:Woocommerce Donation by Dipro
 *Author:NR Abdullah
 *Version:1.0.0
 *Description:This is a custom plugin for accepting donation by woocommerce.
 */

//For Security.
defined("ABSPATH") or die("Sorry ,You cannot access it");

include plugin_dir_path(__FILE__) . "include/ajax.php";
include plugin_dir_path(__FILE__) . "include/functions.php";

class nr_donation_woo_management_class {

    public function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'nr_dowooma_scripts_fn'));
        add_action('wp_enqueue_scripts', array($this, 'nr_dowooma_scripts_fn'));
        add_action('init', array($this, 'nr_dowooma_init_shortcode_fn'));
        add_action('init', array($this, 'nr_dowooma_init_shortcode_v2_fn'));
        add_action("admin_menu", array($this, 'nr_dowooma_admin_menu_fn'));
        register_activation_hook(__FILE__, array($this, 'nr_dowooma_r_activation_fn'));

    }

    public function nr_dowooma_r_activation_fn() {

        $option = get_option('nr_dowooma_products_categories');
        $fee = get_option('nr_dowooma_products_fees');

        if ($option == false) {

            add_option('nr_dowooma_products_categories', array());

        }

        if ($fee == false) {

            add_option('nr_dowooma_products_fees', 2);

        }

    }

    public function nr_dowooma_admin_menu_fn() {

        add_submenu_page('edit.php?post_type=product', 'Donation Settings', 'Donation Settings', 'manage_options', 'dowooma', array($this, 'nr_dowooma_add_submenu_fn'));

    }

    public function nr_dowooma_add_submenu_fn() {

        include plugin_dir_path(__FILE__) . "include/do_categories.php";

    }

    public function nr_dowooma_init_shortcode_v2_fn() {

        add_shortcode('donation_woo_table', function () {

            include plugin_dir_path(__FILE__) . "include/shortcode2.php";

            return ob_get_clean();

        });

    }

    public function nr_dowooma_init_shortcode_fn() {
        add_shortcode('donation_woo_management', function ($atts) {
            $atts = shortcode_atts(array(
                'product_ids' => '',
            ), $atts);
            $_GET['product_ids'] = $atts['product_ids'];
            include plugin_dir_path(__FILE__) . "include/shortcode.php";
            return ob_get_clean();
        });
    }

    public function nr_dowooma_scripts_fn() {
        wp_enqueue_style('dowooma_style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
        wp_enqueue_script("jquery");
        wp_enqueue_style('dowooma_iconstyle', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
        wp_enqueue_script('dowooma_script', plugin_dir_url(__FILE__) . "assets/js/script.js", array(), '1.0.0', true);
        wp_localize_script("dowooma_script", "dowooma_script_objects", array("ajax_url" => admin_url("admin-ajax.php")));

    }

}

new nr_donation_woo_management_class();
