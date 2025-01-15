<?php
/**
 * Admin new order email
 *
 * @package WooCommerce\Templates\Emails\HTML
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

// Prepare subject line
$subject = sprintf('New Order #%s', $order->get_order_number());

// Format order data for SendGrid template, stripping HTML and entities
$order_data = array(
	'template_id' => 'd-a074b85fe1a340edaa9adcbf431469d6', // Set your specific template ID for new order emails
	'template_type' => 'admin-new-order',
	'subject' => html_entity_decode(wp_strip_all_tags($subject)),
	'customer_name' => html_entity_decode(wp_strip_all_tags($order->get_formatted_billing_full_name())),
	'order_number' => wp_strip_all_tags($order->get_order_number()),
	'order_date' => wp_strip_all_tags($order->get_date_created()->format('Y-m-d H:i:s')),
	'order_total' => wp_strip_all_tags($order->get_formatted_order_total()),
	'payment_method' => wp_strip_all_tags($order->get_payment_method_title()),
	'shipping_method' => wp_strip_all_tags($order->get_shipping_method()),
	'billing_address' => wp_strip_all_tags($order->get_formatted_billing_address()),
	'shipping_address' => wp_strip_all_tags($order->get_formatted_shipping_address()),
	'customer_email' => sanitize_email($order->get_billing_email()),
	'customer_phone' => wp_strip_all_tags($order->get_billing_phone())
);

// Format order items, stripping HTML
$items = $order->get_items();
$order_data['items'] = array();

foreach ($items as $item) {
	$order_data['items'][] = array(
		'name' => wp_strip_all_tags($item->get_name()),
		'quantity' => intval($item->get_quantity()),
		'price' => wp_strip_all_tags($order->get_item_total($item))
	);
}

// Debug log the order data
if (function_exists('lcsg_set_template_data')) {
	error_log('Setting SendGrid template data: ' . print_r($order_data, true));
	lcsg_set_template_data($order_data);
} else {
	error_log('lcsg_set_template_data function not found');
}

// Send the email using wp_mail with explicit arguments
wp_mail(
	array('to' => get_option('admin_email')),
	array('subject' => $subject),
	array('message' => sprintf('You have received an order from %s', $order->get_formatted_billing_full_name()))
);
