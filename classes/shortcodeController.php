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
        $currentUser = wp_get_current_user();
        $firstName = $currentUser->first_name;
        $lastName = $currentUser->last_name;

        return $firstName . " " . $lastName;
    }
}

/**
 * Calling the initialize method
 */
ShortCodeController::init();
