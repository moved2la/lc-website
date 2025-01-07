<?php
/*
Template Name: Article Post Template
Template Post Type: post
*/

/**
 * The template for displaying article post
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

<?php get_template_part('template-parts/blocks/post-article-header'); ?>

<style>
    .article-content-container {
        max-width: 768px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 60px;
    }


    .post-article-heading {
        padding: 24px 0px 24px 0px;
        color: #000000;
        text-align: left;
        font-family: "Roboto-Bold", sans-serif;
        font-size: 40px;
        line-height: 120%;
        font-weight: 700;
        position: relative;
        align-self: stretch;
    }

    .post-article-paragraph {
        font-family: "Roboto-Regular", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 400;
        color: #000000;
        text-align: left;
    }

    .post-article-image {
        padding: 48px 0px 48px 0px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .post-article-image .image-container {
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        object-fit: cover;
    }

    .post-article-image .caption-figure {
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .post-article-image .caption-figure .image-caption-rectangle {
        background: #000;
        align-self: stretch;
        flex-shrink: 0;
        width: 2px;
        position: relative;
    }

    .post-article-image .caption-figure .image-caption {
        color: #000;
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 14px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
        flex: 1;
    }
</style>

<div class="article-content-container">
    <?php
    while (have_posts()) :
        the_post();

        get_template_part('template-parts/content', 'page');

        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;

    endwhile; // End of the loop.
    ?>
</div>

<?php
/**
 * Hook - live_complete_container_wrap_end	
 *
 * @hooked container_wrap_end - 999
 */
do_action('live_complete_container_wrap_end', esc_attr($layout));
get_footer();
