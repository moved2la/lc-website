<?php
// Copyright WP Zone

$names = [ ['John','Smith'], ['Jane','Doe'] ];
$addresses = [
	[
		'address_1' => '123 Main Street',
		'city' => 'Smithers',
		'state' => 'BC',
		'postcode' => 'V0J 2N0',
		'country' => 'CA'
	],
	[
		'address_1' => '456 First Ave',
		'city' => 'Seattle',
		'state' => 'WA',
		'postcode' => 98259,
		'country' => 'US'
	]
];

for ($i = ($args[1] - 1) * $args[0]; $i < $args[1] * $args[0]; ++$i) {

	$order = new WC_Order();
	$orderAddressKey = rand(0, 1);
	switch ($i) {
		case 0:
			$orderTs = strtotime('midnight', current_time('timestamp'));
			break;
		case 1:
			$orderTs = strtotime('midnight', current_time('timestamp')) - 86400;
			break;
		case 2:
			$orderTs = strtotime('midnight', current_time('timestamp')) - (86400 * 7);
			break;
		case 3:
			$orderTs = strtotime('midnight', current_time('timestamp')) - (86400 * 30);
			break;
		default:
			$orderTs = rand(time() - (($i % 2 ? 365 : 30) * 86400), time());
	}
	$billingName = $names[rand(0, count($names) - 1)];
	$shippingName = $names[rand(0, count($names) - 1)];
	$billingPhone = rand(1111111111, 9999999999);
	$shippingPhone = rand(1111111111, 9999999999);
	$orderUserId = rand(1, 2);
	$order->set_customer_id($orderUserId);
	$order->set_billing_first_name($billingName[0]);
	$order->set_billing_last_name($billingName[1]);
	$order->set_billing_phone($billingPhone);
	$order->set_shipping_phone($shippingPhone);
	$order->set_shipping_first_name($shippingName[0]);
	$order->set_shipping_last_name($shippingName[1]);
	$order->set_date_created( date('Y-m-d H:i:s', $orderTs) );
	$order->set_billing_address($addresses[$orderAddressKey]);
	$order->set_shipping_address($addresses[$orderAddressKey]);
	$order->set_billing_email('example'.rand(1, 3).'@example.com');
	
	$numItems = rand(1, 5);
	$productIdsInOrder = [];
	for ($j = 0; $j < $numItems; ++$j) {
		$isVariableProduct = !rand(0, 2);
		
		if ($isVariableProduct) {
			$productId = current(get_posts([
				'post_type' => 'product_variation',
				'fields' => 'ids',
				'posts_per_page' => 1,
				'orderby' => 'rand'
			]));
		} else {
			$productId = current(get_posts([
				'post_type' => 'product',
				'fields' => 'ids',
				'posts_per_page' => 1,
				'orderby' => 'rand',
				'tax_query' => [
					'taxonomy' => 'product_type',
					'field' => 'slug',
					'terms' => 'simple'
				]
			]));
		}
		
		if (in_array($productId, $productIdsInOrder)) {
			--$j;
			continue;
		}
		
		$productIdsInOrder[] = $productId;
		
		$order->add_product( wc_get_product($productId), rand(1, 5) );
	}
	
	// Shipping
	$isLocalPickup = !rand(0, 3);
	$shipping = new WC_Order_Item_Shipping();
	$shipping->set_props(
		array(
			'method_title' => $isLocalPickup ? 'Local Pickup' : 'Flat Rate',
			'method_id'    => $isLocalPickup ? 'local_pickup' : 'flat_rate',
			'instance_id'  => $isLocalPickup  ? 2 : 1,
			'total'        => rand(5, 20)
		)
	);
	$order->add_item($shipping);
	
	$order->calculate_totals();
	$order->save();
	
	if (!rand(0, 2)) {
		$order->apply_coupon('50OFF');
	}
	
	$statuses = ['pending', 'processing', 'processing', 'completed', 'completed', 'completed', 'completed'];
	$statusIndex = rand(0, count($statuses) - 1);
	if ($statusIndex) {
		$order->update_status($statuses[$statusIndex]);
	}

	$customMeta = [];
	$customMeta[ 'wpz_custom_meta_'.rand(1, 2) ] = rand(111, 999);
	$order->update_meta_data( key($customMeta), current($customMeta) );
	$order->save_meta_data();
	
	$dataEntry = [
		'id' => $order->get_id(),
		'created' => date('Y-m-d H:i:s', $orderTs),
		'billing_name' => $billingName,
		'shipping_name' => $shippingName,
		'billing_phone' => $billingPhone,
		'shipping_phone' => $shippingPhone,
		'address' => $addresses[$orderAddressKey],
		'email' => $order->get_billing_email(),
		'total' => $order->get_total(),
		'tax' => $order->get_total_tax(),
		'user_nickname' => 'user'.$orderUserId,
		'custom_meta' => $customMeta,
		'items' => []
	];
	
	foreach ($order->get_items() as $item) {
		$itemTaxes = $item->get_taxes();
		
		$dataEntry['items'][] = [
			'product_id' => $item->get_product_id(),
			'variation_id' => $item->get_variation_id(),
			'product_name' => get_the_title($item->get_product_id()),
			'product_sku' => get_post_meta($item->get_product_id(), '_sku', true),
			'product_categories' => wp_get_object_terms($item->get_product_id(), 'product_cat', ['fields' => 'ids']),
			'product_categories_names' => wp_get_object_terms($item->get_product_id(), 'product_cat', ['fields' => 'names']),
			'quantity' => $item->get_quantity(),
			'subtotal' => $item->get_subtotal(),
			'total' => $item->get_total(),
			'tax' => $item->get_total_tax(),
			'tax_gst' => isset($itemTaxes['total'][1]) ? $itemTaxes['total'][1] : 0,
			'tax_pst' => isset($itemTaxes['total'][2]) ? $itemTaxes['total'][2] : 0
		];
		
	}
	
	$shippingItem = current($order->get_shipping_methods());
	$shippingItemTaxes = $shippingItem->get_taxes();
	$dataEntry['shipping'] = [
		'method' => $shippingItem->get_method_id(),
		'total' => $shippingItem->get_total(),
		'tax' => $shippingItem->get_total_tax(),
		'tax_gst' => isset($shippingItemTaxes['total'][1]) ? $shippingItemTaxes['total'][1] : 0,
		'tax_pst' => isset($shippingItemTaxes['total'][2]) ? $shippingItemTaxes['total'][2] : 0
	];
	
	$orderHasRefund = !rand(0, 4);
	
	if ($orderHasRefund) {
		
		$item = current($order->get_items());
		$refundAmount = round(( 1 / $item->get_quantity() ) * $item->get_total(), 2);
		
		$refundTaxAmount = array_map( function($amount) use ($item) {
			return round(( 1 / $item->get_quantity() ) * $amount, 2);
		}, ($item->get_taxes())['total'] );
		
		$refundItems = [];
		$refundItems[ $item->get_id() ] = [
			'qty' => 1,
			'refund_total' => $refundAmount,
			'refund_tax' => $refundTaxAmount,
		];
		
		$shippingItem = current($order->get_shipping_methods());
		if ($shippingItem) {
			$shippingRefundAmount = round(( 1 / $item->get_quantity() ) * $shippingItem->get_total(), 2);
			$shippingRefundTaxAmount = array_map( function($amount) use ($item) {
				return round(( 1 / $item->get_quantity() ) * $amount, 2);
			}, ($shippingItem->get_taxes())['total'] );
			
			
			$refundItems[ $shippingItem->get_id() ] = [
				'qty' => 1,
				'refund_total' => $shippingRefundAmount,
				'refund_tax' => $shippingRefundTaxAmount
			];
		}
		
		$refundTs = max(current_time('timestamp'), $orderTs + (86400 * rand(1, 14)));
		
		wc_create_refund([
			'amount' => $refundAmount + array_sum($refundTaxAmount) + (isset($shippingRefundAmount) ? $shippingRefundAmount + array_sum($shippingRefundTaxAmount) : 0),
			'order_id' => $order->get_id(),
			'line_items' => $refundItems,
			'date_created' => date('Y-m-d H:i:s', $refundTs)
		]);
		
		$dataEntry['refund'] = [
			'created' => date('Y-m-d H:i:s', $refundTs),
			'product_id' => $item->get_product_id(),
			'variation_id' => $item->get_variation_id(),
			'quantity' => -1,
			'amount' => $refundAmount * -1,
			'tax' => array_sum($refundTaxAmount) * -1,
			'tax_gst' => isset($refundTaxAmount[1]) ? $refundTaxAmount[1] * -1 : 0,
			'tax_pst' => isset($refundTaxAmount[2]) ? $refundTaxAmount[2] * -1 : 0,
		];
		
		if (isset($shippingItem)) {
			$dataEntry['refund']['shipping_amount'] = $shippingRefundAmount * -1;
			$dataEntry['refund']['shipping_tax'] = array_sum($shippingRefundTaxAmount) * -1;
			$dataEntry['refund']['shipping_tax_gst'] = isset($shippingRefundTaxAmount[1]) ? $shippingRefundTaxAmount[1] * -1 : 0;
			$dataEntry['refund']['shipping_tax_pst'] = isset($shippingRefundTaxAmount[2]) ? $shippingRefundTaxAmount[2] * -1 : 0;
		}
		
		// Reload the parent order
		$order = wc_get_order($order->get_id());
	}
	
	$dataEntry['status'] = $order->get_status(); // status can change during refund sometimes
	$dataEntry['status_name'] = (wc_get_order_statuses())['wc-'.$dataEntry['status']];
	
	$data[] = $dataEntry;
	
	echo('Created order on '.date('Y-m-d H:i:s', $orderTs).' with '.array_sum(array_column($dataEntry['items'], 'quantity')).' items'."\n");
}

file_put_contents(ABSPATH.'/orders.json', json_encode($data, JSON_PRETTY_PRINT));
