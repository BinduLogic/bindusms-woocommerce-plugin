<?php

namespace BinduSms\BinduSms\Admin;

/**
 * The Menu handler class
 */
class Menu
{

    /**
     * Initialize the class
     */
    function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu()
    {
        add_submenu_page('woocommerce', __('BinduSms', 'bindusms'), __('BinduSms Notifications', 'bindusms'), 'manage_woocommerce', 'bindusms', [$this, 'order_notification']);
    }

    /**
     * Render the plugin page
     *
     * @return void
     */
    public function order_notification()
    {
        $wc_order_notification = new WCOrderNotification();
        $wc_order_notification->plugin_page();
    }
}
