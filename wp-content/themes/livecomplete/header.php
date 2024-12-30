<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package live-complete
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>

    <?php if (is_product_category() && !is_shop()) : ?>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/vendors/glide/assets/glide.core.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/vendors/glide/assets/glide.theme.min.css'; ?>">
        <script src="<?php echo get_template_directory_uri() . '/vendors/glide/glide.min.js'; ?>"></script>
    <?php endif; ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">

        <?php
        /**
         * Hook - live_complete_site_header
         *
         * @hooked site_header_layout
         */
        do_action('live_complete_site_header');

        ?>



        <div id="content" class="site-content">