<?php

/**
 * Plugin Name:       Fubic Two
 * Plugin URI:        https://github.com/Asia-Quest-Malaysia
 * Description:       Compilation of Fubic requirement (Task two) in one single plugin.
 * Version:           1.1
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
 */
require 'classes/woocommerceMyAccountController.php';
require 'classes/pageController.php';
require 'classes/shortcodeController.php';
