<?php
/**
 * Product quantity inputs
 *
 * @package WooCommerce\Templates
 */

defined( 'ABSPATH' ) || exit;

global $product;

do_action('woocommerce_before_add_to_cart_quantity');

?>
<div class="quantity-wrapper">    
    <div class="quantity-header">Quantity</div>    
<?php

woocommerce_quantity_input(
    array(
        'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
        'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
        'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
    )
);

?>
</div>
<?php
                     
do_action( 'woocommerce_after_add_to_cart_quantity' ); 