<?php

/**
 * @author Sulaiman Misri
 * This file will load all the style and script needed.
 */
class enqueueController
{
    public static function init()
    {
        add_action('wp_enqueue_scripts', [__CLASS__, 'loadFubicEnqueue']);
    }

    public static function loadFubicEnqueue()
    {
        wp_enqueue_style('fubic-two-style-1', plugin_dir_url(dirname(__FILE__)) . 'assets/css/style.css', '', false, 'all');
        wp_enqueue_script('fubic-two-script-1', plugin_dir_url(dirname(__FILE__)) . '/assets/js/script.js', ['jquery'], false, true);
    }
}

/**
 * Calling the initialize method
 */
enqueueController::init();
