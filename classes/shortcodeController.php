<?php

/**
 * @author Sulaiman Misri
 * This file will load all the logic needed to add a custom shortcode.
 */
class ShortCodeController
{
    public static function init()
    {
        add_shortcode('show_fullname', [__CLASS__, 'showFullName']);
    }

    public static function showFullName()
    {
        $current_user = wp_get_current_user();
        $first_name = $current_user->first_name;
        $last_name = $current_user->last_name;

        return $first_name . " " . $last_name;
    }
}

/**
 * Calling the initialize method
 */
ShortCodeController::init();
