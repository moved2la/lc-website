<?php
/**
 * Link to Subscribe Form Modal.
 *
 * This template can be overridden by copying it to yourtheme/subscribe-and-save-for-woocommerce-subscriptions/link-to-modal.php.
 * 
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 */
defined( 'ABSPATH' ) || exit;
?>
<a href="#" 
   class="asp-ssws-subscribe-via-modal <?php echo esc_attr( implode( ' ', $href_classes ) ); ?>" 
   data-product-id="<?php echo esc_attr( $subscribe_product_id ); ?>" 
   >
	   <?php echo esc_html( $subscribe_now_label ); ?>
</a>
