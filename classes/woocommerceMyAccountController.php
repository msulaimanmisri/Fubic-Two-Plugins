<?php

/**
 * @author Sulaiman Misri
 * This file will load all the logic needed to remove the card (payment) details in `/my-account' page
 */
class MyAccountController
{

    public static function init()
    {
        add_filter('woocommerce_account_menu_items', [__CLASS__, 'fubicRemoveUserPaymentDetails']);
        add_action('template_redirect', [__CLASS__, 'fubicDisablePaymentMethodsPage']);
        add_action('woocommerce_account_dashboard', [__CLASS__, 'showExpiredDate']);
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

    public static function fubicRemoveUserPaymentDetails($menu_links)
    {
        unset($menu_links['payment-methods']);
        unset($menu_links['add-payment-method']);
        return $menu_links;
    }

    public static function fubicDisablePaymentMethodsPage()
    {
        if (is_wc_endpoint_url('payment-methods')) {
            wp_redirect(home_url());
            exit();
        }
    }

    public static function showExpiredDate($results)
    {
        $results = self::queryTheData();

        if (empty($results)) {
            echo "Please subscribe to our membership in order to see this details.";
        }

        if (!empty($results)) {
            echo "Your next Payment date is : " . do_shortcode('[expired_date]');
        }
    }
}

/**
 * Calling the initialize method
 */
MyAccountController::init();
