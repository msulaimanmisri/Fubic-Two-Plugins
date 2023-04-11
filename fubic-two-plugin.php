<?php

/**
 * Plugin Name:       Fubic Two
 * Plugin URI:        https://github.com/Asia-Quest-Malaysia
 * Description:       Compilation of Fubic requirement (Task two) in one single plugin.
 * Version:           1.3
 * Author:            Sulaiman Misri
 * Author URI:        https://github.com/msulaimanmisri
 * Text Domain:       sm-fubic-two
 * Domain Path:       /languages
 */

defined('ABSPATH') or die("Tak boleh masuk brother");

/**
 * Change this only when REQUIRED
 */
require 'classes/enqueueController.php';

/**
 * Controller Files
 * The plugin need a Actived WooCommerce Plugin.
 */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    require 'classes/woocommerceMyAccountController.php';
    require 'classes/pageController.php';
    require 'classes/shortcodeController.php';
}

/**
 * If WooCommerce is not active, then execute the handling dependency.
 */
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('admin_notices', 'fubicTwoNeedWooCommerceToBeActivated');
}

function fubicTwoNeedWooCommerceToBeActivated()
{
    $class = 'notice notice-error';
    $message = __('Fubic Two : You need to activate the WooCommerce plugin first in order to make this plugin work properly.', 'textdomain');
    printf('<div class="%1$s"><p><b>%2$s</b></p></div>', esc_attr($class), esc_html($message));
}
