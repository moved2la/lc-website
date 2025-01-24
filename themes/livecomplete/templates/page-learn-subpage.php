<?php

/**
 * Template Name: Learn Sub Page
 * The template for displaying the learn sub page
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

get_header();

$layout = live_complete_get_option('page_layout');

$layout = 'full-container';

/**
 * Hook - live_complete_container_wrap_start 	
 *
 * @hooked live_complete_container_wrap_start	- 5
 */
do_action('live_complete_container_wrap_start', esc_attr($layout));

get_template_part('template-parts/learn/learn-section-header');
get_template_part('template-parts/learn/learn-section-1');
get_template_part('template-parts/learn/learn-section-2');

/**
 * Hook - live_complete_container_wrap_end	
 *
 * @hooked container_wrap_end - 999
 */
do_action('live_complete_container_wrap_end', esc_attr($layout));
get_footer(); 

?>