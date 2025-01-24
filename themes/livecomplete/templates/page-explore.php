<?php

/**
 * Template Name: Explore Page
 * The template for displaying the explore page
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


<style>
    .live-complete-breadcrumbs-wrap {
        background-color: #fff;
    }

    .explore-page-wrapper {
        background: var(--background-color-primary, #ffffff);
        padding-bottom: 60px;
        display: flex;
        flex-direction: column;
        gap: 80px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }

    .heading {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h1-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h1-font-size, 56px);
        line-height: var(--heading-desktop-h1-line-height, 120%);
        font-weight: var(--heading-desktop-h1-font-weight, 700);
        position: relative;
        width: 768px;
    }

    .content {
        display: flex;
        flex-direction: column;
        gap: 64px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .content-row {
        display: flex;
        flex-direction: row;
        gap: 48px;
        align-items: flex-start;
        justify-content: center;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .column {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
        overflow: hidden;
    }

    .placeholder-image {
        align-self: stretch;
        flex-shrink: 0;
        height: 240px;
        position: relative;
        object-fit: cover;
    }

    .content2 {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .content3 {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .heading2 {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h5-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h5-font-size, 24px);
        line-height: var(--heading-desktop-h5-line-height, 140%);
        font-weight: var(--heading-desktop-h5-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .text {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--text-regular-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-regular-normal-font-size, 16px);
        line-height: var(--text-regular-normal-line-height, 150%);
        font-weight: var(--text-regular-normal-font-weight, 400);
        position: relative;
        align-self: stretch;
    }

    .action {
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .style-link-small-false-alternate-false-icon-position-trailing {
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .button {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
    }

    .icon-chevron-right {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }

    .icon-chevron-right2 {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }
</style>


<div class="explore-page-wrapper">
    <div class="heading">Lorem ipsum dolor sit amet</div>
    <div class="content">
        <div class="content-row">
            <div class="column">
                <img class="placeholder-image" src="<?php echo get_template_directory_uri() . '/assets/image/placeholder.png'; ?>" />
                <div class="content2">
                    <div class="content3">
                        <div class="heading2">Blog</div>
                        <div class="text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce
                            interdum justo orci, sed suscipit elit pretium vitae.
                        </div>
                    </div>
                    <div class="action">
                        <a href="<?php echo home_url() . '/explore/blog'; ?>"
                            class="style-link-small-false-alternate-false-icon-position-trailing">
                            <div class="button">View our list of articles</div>
                            <img class="icon-chevron-right" src="<?php echo get_template_directory_uri() . '/assets/image/icon-chevron.svg'; ?>" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="column">
                <img class="placeholder-image" src="<?php echo get_template_directory_uri() . '/assets/image/placeholder.png'; ?>" />
                <div class="content2">
                    <div class="content3">
                        <div class="heading2">Recipes</div>
                        <div class="text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce
                            interdum justo orci, sed suscipit elit pretium vitae.
                        </div>
                    </div>
                    <div class="action">
                        <a href="<?php echo home_url() . '/explore/recipes'; ?>"
                            class="style-link-small-false-alternate-false-icon-position-trailing">
                            <div class="button">View our list of recipes</div>
                            <img class="icon-chevron-right" src="<?php echo get_template_directory_uri() . '/assets/image/icon-chevron.svg'; ?>" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
/**
 * Hook - live_complete_container_wrap_end	
 *
 * @hooked container_wrap_end - 999
 */
do_action('live_complete_container_wrap_end', esc_attr($layout));
get_footer();
