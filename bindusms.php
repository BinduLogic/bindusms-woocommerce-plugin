<?php

/**
 * Plugin Name: BinduSms
 * Description: BinduSms lets you notify your customers about their WooCommerce order updates via SMS.
 * Plugin URI: https://wordpress.org/plugins/bindusms
 * Author: BinduSms
 * Author URI: https://www.sms.bindulogic.com
 * Version: 1.0.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: bindusms
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

$wc_order_notification_controller = new \BinduSms\BinduSms\Admin\WCOrderNotification();

/**
 * The main plugin class
 */
final class BinduSms
{

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0';

    /**
     * Class constructor
     */
    private function __construct()
    {
        $this->define_constants();

        register_activation_hook(__FILE__, [$this, 'activate']);

        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    /**
     * Initializes a singleton instance
     *
     * @return BinduSms
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants()
    {
        define('BINDUSMS_VERSION', self::version);
        define('BINDUSMS_FILE', __FILE__);
        define('BINDUSMS_PATH', __DIR__);
        define('BINDUSMS_URL', plugins_url('', BINDUSMS_FILE));
        define('BINDUSMS_ASSETS', BINDUSMS_URL . '/assets');
        define('BINDUSMS_WC_ORDER_NOTIFICATION_SETTINGS_KEY', 'bindusms_wc_order_notification_settings');
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin()
    {

        if (is_admin()) {
            new BinduSms\BinduSms\Admin();
        }
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate()
    {
        $installer = new BinduSms\BinduSms\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 *
 * @return BinduSms
 */
function bindusms()
{
    return BinduSms::init();
}

add_action('woocommerce_order_status_changed', [$wc_order_notification_controller, 'wc_order_status_change_handler']);
add_action('woocommerce_new_order', [$wc_order_notification_controller, 'send_new_order_notification']);

function bindusms_settings_link($links)
{
    $settings_link = array(
        '<a href="admin.php?page=bindusms" title="' . __('Settings ', 'bindusms') . '">' . __('Settings', 'bindusms') . '</a>',
    );

    foreach ($settings_link as $link) {
        array_unshift($links, $link);
    }

    return $links;
}

add_filter("plugin_action_links_" . plugin_basename(__FILE__), 'bindusms_settings_link');

// kick-off the plugin
bindusms();
