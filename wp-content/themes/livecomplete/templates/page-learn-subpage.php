<?php
/**
 * Template Name: Learn Sub Page
 * The template for displaying the learn sub page
 *
 * @package live-complete
 */

get_header();

$layout = live_complete_get_option('page_layout');

/**
 * Hook - live_complete_container_wrap_start 	
 *
 * @hooked live_complete_container_wrap_start	- 5
 */
do_action('live_complete_container_wrap_start', esc_attr($layout));
?>

<?php get_template_part('template-parts/learn/learn-section-header'); ?>

<?php
/**
 * Hook - live_complete_container_wrap_end	
 *
 * @hooked container_wrap_end - 999
 */
do_action('live_complete_container_wrap_end', esc_attr($layout));
get_footer(); 