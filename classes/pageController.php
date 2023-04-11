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
                WHERE p.post_author = %d AND pm.meta_key = 'member_expiry'
                ORDER BY p.post_date DESC
                LIMIT 1",
                $current_user_id
            )
        );
        return $results;
    }

    public static function getTheLatestOrder()
    {
        $current_user = get_current_user_id();
        $orderArgs = [
            'numberposts' => 1,
            'meta_key'    => '_customer_user',
            'meta_value'  => $current_user,
            'post_type'   => wc_get_order_types(),
            'post_status' => array_keys(wc_get_order_statuses()),
        ];

        $getTheLatestOrder = wc_get_orders($orderArgs);
        $order = array_shift($getTheLatestOrder);

        return $order;
    }

    public static function changeHomepageViewBasedOnCondition()
    {
        $results = self::queryTheData();
        $order = self::getTheLatestOrder();

        /**
         * Case 1
         * If the user already buy the membership, then :
         * Hide the #fubic-membership-table.
         * Show the #fubic-membership-card.
         */
        if (!empty($results)) {
            wp_enqueue_style('fubic-two-style-3', plugin_dir_url(dirname(__FILE__)) . 'assets/css/show-membership-card.css', '', false, 'all');
        }

        /**
         * Case 2
         * If the user is not login OR have an expired Membership, then :
         * Show the #fubic-membership-table.
         * Hide the #fubic-membership-card.
         */
        if (!is_user_logged_in() || empty($results) || ($order && 'cancelled' == $order->get_status())) {
            wp_enqueue_style('fubic-two-style-2', plugin_dir_url(dirname(__FILE__)) . 'assets/css/show-product-table.css', '', false, 'all');
        }
    }
}

/**
 * Calling the initialize method
 */
PageController::init();
