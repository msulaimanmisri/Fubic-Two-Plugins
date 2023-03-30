<?php

/**
 * @author Sulaiman Misri
 * This file will load all the logic needed to make the pages in Fubic Site
 */
class PageController
{
    public static function init()
    {
        add_action('wp_enqueue_scripts', [__CLASS__, 'changeHomepageViewBasedOnCondition']);
    }

    public static function queryTheData()
    {
        global $wpdb;
        $current_user_id = get_current_user_id();

        $results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT meta_key, meta_value
                FROM {$wpdb->prefix}postmeta AS pm
                INNER JOIN {$wpdb->prefix}posts AS p ON pm.post_id = p.ID
                WHERE p.post_author = %d AND pm.meta_key = 'member_expiry'",
                $current_user_id
            )
        );

        return $results;
    }

    public static function changeHomepageViewBasedOnCondition()
    {
        $results = self::queryTheData();

        if (!is_user_logged_in() || empty($results)) {
            wp_enqueue_style('sm-fubic-two-style-2', plugin_dir_url(dirname(__FILE__)) . 'assets/css/show-product-table.css', '', false, 'all');
        }

        if (!empty($results)) {
            wp_enqueue_style('sm-fubic-two-style-3', plugin_dir_url(dirname(__FILE__)) . 'assets/css/hide-product-table.css', '', false, 'all');
        }
    }
}

/**
 * Calling the initialize method
 */
PageController::init();
