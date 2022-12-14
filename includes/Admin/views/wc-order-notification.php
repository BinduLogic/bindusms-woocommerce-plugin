<?php
$notification_controller = new BinduSms\BinduSms\Admin\WCOrderNotification();
$settings = get_option(BINDUSMS_WC_ORDER_NOTIFICATION_SETTINGS_KEY);

$check_enable = '';
$enabled = $settings['enabled'];
if ($enabled) $check_enable = ' checked';

$check_new_order_notification = '';
$new_order_notification_enabled = $settings['new_order_notification_enabled'];
if ($new_order_notification_enabled) $check_new_order_notification = ' checked';

$check_debug = '';
$debug_enabled = $settings['debug_enabled'];
if ($debug_enabled) $check_debug = ' checked';
?>

<style>
    .bindusms-section {
        padding: 50px 0 10px !important;
        margin-top: 19px;
    }

    .bindusms-section h2 {
        margin: 0;
        font-size: 26px;
        font-weight: 500;
    }

    .bindusms-hidden {
        display: none;
    }
</style>

<div class="wrap">
    <h1><?php _e('BinduSms SMS Notification', 'bindusms'); ?></h1>

    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="enabled"><?php _e('Enable', 'bindusms'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="enabled" id="enabled" <?php echo esc_attr($check_enable) ?>>
                    </td>
                </tr>

                <tr>
                    <td class="bindusms-section">
                        <h2>Credentials</h2>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="api_key"><?php _e('API Key', 'bindusms'); ?></label>
                    </th>
                    <td>
                        <input type="password" name="api_key" id="api_key" class="regular-text" value="<?php echo esc_attr($settings['api_key']) ?>">
                    </td>
                </tr>

                <tr>
                    <td class="bindusms-section">
                        <h2>Settings</h2>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="new_order_notification_enabled"><?php _e('Receive new order notification', 'bindusms'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="new_order_notification_enabled" id="new_order_notification_enabled" <?php echo esc_attr($check_new_order_notification) ?>>
                    </td>
                </tr>
                <tr id="new_order_notification--phone" class="bindusms-hidden">
                    <th scope="row">
                        <label for="new_order_notification_phone"><?php _e('Receiver phone number', 'bindusms'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="new_order_notification_phone" id="new_order_notification_phone" class="regular-text" value="<?php echo esc_attr($settings['new_order_notification_phone']) ?>">
                    </td>
                </tr>
                <tr id="new_order_notification--message" class="bindusms-hidden">
                    <th scope="row">
                        <label for="new_order_notification_message"><?php _e('Message', 'bindusms'); ?></label>
                    </th>
                    <td>
                        <textarea rows="5" type="text" name="new_order_notification_message" id="new_order_notification_message" class="regular-text"><?php echo esc_attr($settings['new_order_notification_message']) ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="debug_enabled"><?php _e('Enable Custom Integration', 'bindusms'); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="debug_enabled" id="debug_enabled" <?php echo esc_attr($check_debug) ?>>
                    </td>
                </tr>
                <tr id="debug" class="bindusms-hidden">
                    <th scope="row">
                        <label for="from"><?php _e('Registered SenderId', 'bindusms'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="from" id="from" class="regular-text" value="<?php echo esc_attr($settings['from']) ?>">
                    </td>
                </tr>


                <tr>

                </tr>

                <tr>
                    <td class="bindusms-section">
                        <h2>Order statuses</h2>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="apiSecret"><?php _e('Select status', 'bindusms'); ?></label>
                    </th>
                    <td>
                        <?php $notification_controller->wc_statuses(); ?>
                    </td>
                </tr>
                <?php $notification_controller->wc_status_messages(); ?>
            </tbody>
        </table>

        <?php wp_nonce_field('wc-order-notification-settings') ?>
        <?php submit_button(__('Save Changes', 'bindusms'), 'primary', 'wc_order_notification_settings'); ?>
    </form>
</div>

<script>
    jQuery(document).ready(function($) {
        function hideOrShow(checkboxId, targetFieldId) {
            const checkbox = $(`#${checkboxId}`);
            const targetField = $(`#${targetFieldId}`);

            if (checkbox.is(':checked')) {
                targetField.show();
            } else {
                targetField.hide();
            }
        }

        function handleCheckboxHideShow(checkboxId, targetFieldId) {
            const checkbox = $(`#${checkboxId}`);
            hideOrShow(checkboxId, targetFieldId);
            checkbox.on('change', function() {
                hideOrShow(checkboxId, targetFieldId)
            });
        }

        handleCheckboxHideShow('debug_enabled', 'debug');
        handleCheckboxHideShow('new_order_notification_enabled', 'new_order_notification--phone');
        handleCheckboxHideShow('new_order_notification_enabled', 'new_order_notification--message');
    });
</script>