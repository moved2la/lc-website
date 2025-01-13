<?php

class LiveComplete_SendGrid_WooCommerce
{
    public function __construct()
    {
        // Override WooCommerce email templates path
        add_filter('woocommerce_template_directory', array($this, 'set_woocommerce_template_dir'), 10, 2);

        // Add settings to WooCommerce email settings page
        add_filter('woocommerce_email_settings', array($this, 'add_sendgrid_template_settings'));
    }

    public function set_woocommerce_template_dir($directory, $template)
    {
        if (strpos($template, 'emails/') !== false) {
            return 'woocommerce';
        }
        return $directory;
    }

    public function add_sendgrid_template_settings($settings)
    {
        $sendgrid_settings = array(
            array(
                'title' => __('SendGrid Template Settings', 'livecomplete-sendgrid'),
                'type'  => 'title',
                'desc'  => __('Configure SendGrid template IDs for different email types.', 'livecomplete-sendgrid'),
                'id'    => 'sendgrid_template_settings'
            ),
            array(
                'title'    => __('New Order Template ID', 'livecomplete-sendgrid'),
                'desc'     => __('SendGrid template ID for new order notifications', 'livecomplete-sendgrid'),
                'id'       => 'lcsg_new_order_template_id',
                'type'     => 'text',
                'default'  => '',
            ),
            // Add more template settings for other email types as needed
            array(
                'type' => 'sectionend',
                'id'   => 'sendgrid_template_settings'
            )
        );

        return array_merge($settings, $sendgrid_settings);
    }
}
