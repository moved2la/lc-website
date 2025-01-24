<?php

/**
 * Template Name: Support Page
 * The template for displaying the support page
 *
 * @package live-complete
 */

get_header();

$layout = live_complete_get_option('page_layout');

?>

<style>
    .live-complete-breadcrumbs-wrap {
        background: #ffffff;
        padding-bottom: 40px;
    }

    ul.live-complete-breadcrumbs {
        margin-bottom: 0;
    }

    .support-header-wrapper {
        background: #ffffff;
        /* padding: 112px 64px 60px 64px; */
        display: flex;
        flex-direction: column;
        gap: 40px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
        margin-bottom: 60px;
    }


    .header-content {

        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        max-width: 768px;
        position: relative;
        padding: 0px 10px;
    }

    .header-title {
        color: var(--border-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h1-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h1-font-size, 56px);
        line-height: var(--heading-desktop-h1-line-height, 120%);
        font-weight: var(--heading-desktop-h1-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .header-desc {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--text-medium-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-medium-normal-font-size, 18px);
        line-height: var(--text-medium-normal-line-height, 150%);
        font-weight: var(--text-medium-normal-font-weight, 400);
        position: relative;
        align-self: stretch;
    }

    .live-complete-blogwrap {
        margin-bottom: 0;
    }

    .live-complete-blogwrap .page-content {
        padding: 0;
    }

    .live-complete-blogwrap .entry-footer {
        display: none;
    }
</style>

<div class="support-header-wrapper">
    <div class="container">
        <div class="header-content">
            <div class="header-title">We’re here to help</div>
            <div class="header-desc">
                We’re excited to hear from you! Whether you have questions, feedback, or
                just want to chat, our team is ready to assist you.
            </div>
        </div>
    </div>
</div>

<?php
/**
 * Hook - live_complete_container_wrap_start 	
 *
 * @hooked live_complete_container_wrap_start - 5
 */
do_action('live_complete_container_wrap_start', esc_attr($layout));
?>

<div class="support-page-content">
    <?php
    while (have_posts()) :
        the_post();
        get_template_part('template-parts/content', 'page');
    endwhile;
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
