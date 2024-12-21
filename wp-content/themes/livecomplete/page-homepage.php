<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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

<?php get_template_part('template-parts/home/block-1'); ?>

<?php get_template_part('template-parts/home/nutrition'); ?>

<?php get_template_part('template-parts/home/about-us'); ?>

<?php
/**
 * Hook - live_complete_container_wrap_end	
 *
 * @hooked container_wrap_end - 999
 */
do_action('live_complete_container_wrap_end', esc_attr($layout));
get_footer();
