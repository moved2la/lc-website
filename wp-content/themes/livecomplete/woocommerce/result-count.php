<?php
/**
 * Number of products on shop page
 *
 * @package Fastest Shop WordPress theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( is_single() || ! have_posts() ) {
    return;
}

$products_per_page = get_theme_mod( 'live_complete_posts_per_page', '12' );

$num_prod = ( isset( $_GET['products-per-page'] ) ) ? sanitize_text_field( wp_unslash( $_GET['products-per-page'] ) ) : $products_per_page;

$num_prod_x1 = $products_per_page;
$num_prod_x2 = $num_prod_x1 * 2;

$obj  = get_queried_object();
$link = '';

if ( isset( $obj->term_id ) ) {

    $link = get_term_link( $obj->term_id, 'product_cat' );

    if ( is_wp_error( $link ) ) {
        $link = get_term_link( $obj->term_id, 'product_tag' );
    }

} else {

    if ( get_option( 'permalink_structure' ) == '' ) {
        $link = get_post_type_archive_link( 'product' );
    } else {
        $link = get_permalink( wc_get_page_id( 'shop' ) );
    }

}

/**
 * Filter query link for products number
 *
 * @since 1.0.8
 * @param string $link The old query url
 */
$link = apply_filters( 'grocery_store_num_products_link', $link );

if( ! empty( $_GET ) ) {
    foreach( $_GET as $key => $value ){
        $link = add_query_arg( $key, $value, $link  );
    }
} ?>

<ul class="result-count">
    <li class="view-title"><?php echo esc_html__('View:','live-complete'); ?>
	</li>
    <li><a class="view-first<?php if ( $num_prod == $num_prod_x1 ) echo esc_attr('active'); ?>" href="<?php echo esc_url( add_query_arg( 'products-per-page', $num_prod_x1, $link  ) ) ?>"><?php echo esc_html( $num_prod_x1 ); ?></a></li>
    <li><a class="view-second<?php if ( $num_prod == $num_prod_x2 ) echo ' active'; ?>" href="<?php echo esc_url( add_query_arg( 'products-per-page', $num_prod_x2, $link  ) ) ?>"><?php echo esc_html( $num_prod_x2 ); ?></a></li>
    <li><a class="view-all<?php if ( $num_prod == 'all' ) echo esc_attr('active'); ?>" href="<?php echo esc_url( add_query_arg( 'products-per-page', 'all', $link  ) ) ?>"><?php echo esc_html__('ALL:','live-complete'); ?></a></li>
</ul>
