<?php
/*
Plugin Name: Hide Wordpress And Woocommerce Version
Description: Hide the WordPress and WooCommerce version numbers from the front end of your site
Version: 1.0
Author: Salehn
Author URL: https://salehn.ir
*/

// Hide the WordPress version number from the front end
function hide_wordpress_version() {
    return '';
}
add_filter('the_generator', 'hide_wordpress_version');

// Hide the WooCommerce version number from the front end
function hide_woocommerce_version() {
    remove_action( 'wp_head', 'wc_generator_tag' );
}
add_action('init', 'hide_woocommerce_version');

// Add a settings page to the WordPress admin area
function hide_version_numbers_add_settings_page() {
    add_options_page('Hide Wordpress And Woocommerce Version Numbers Settings', 'Hide Version Numbers', 'manage_options', 'hide_version_numbers', 'hide_version_numbers_settings_page');
}
add_action('admin_menu', 'hide_version_numbers_add_settings_page');

// Callback function to display the settings page
function hide_version_numbers_settings_page() {
    ?>
    <div class="wrap">
        <h1>Hide Wordpress And Woocommerce Version Numbers Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('hide_version_numbers_settings'); ?>
            <?php do_settings_sections('hide_version_numbers_settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Hide WordPress Version Number</th>
                    <td><input type="checkbox" name="hide_wordpress_version_number" value="1" <?php checked(get_option('hide_wordpress_version_number'), 1); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Hide WooCommerce Version Number</th>
                    <td><input type="checkbox" name="hide_woocommerce_version_number" value="1" <?php checked(get_option('hide_woocommerce_version_number'), 1); ?> /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register the settings and add the fields
function hide_version_numbers_register_settings() {
    register_setting('hide_version_numbers_settings', 'hide_wordpress_version_number');
    register_setting('hide_version_numbers_settings', 'hide_woocommerce_version_number');
}
add_action('admin_init', 'hide_version_numbers_register_settings');

// Check the settings and hide the version numbers if necessary
function hide_version_numbers_check_settings() {
    if (get_option('hide_wordpress_version_number') == 1) {
        add_filter('the_generator', 'hide_wordpress_version');
    }
    if (get_option('hide_woocommerce_version_number') == 1) {
        remove_action('wp_head', 'wc_generator_tag');
    }
}
add_action('wp', 'hide_version_numbers_check_settings');
