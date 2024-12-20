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

<style>
    .home-block-1,
    .home-block-1 * {
        box-sizing: border-box;
    }

    .home-block-1 {
        background: #f1f1f1;
        padding-top: 64px;
        padding-bottom: 64px;
        display: flex;
        flex-direction: row;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .column {
        display: flex;
        flex-direction: column;
        gap: 0px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        width: 504px;
        position: relative;
    }

    .medium-length-hero-headline-goes-here {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h1-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h1-font-size, 56px);
        line-height: var(--heading-desktop-h1-line-height, 120%);
        font-weight: var(--heading-desktop-h1-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .column2 {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
    }

    .lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-suspendisse-varius-enim-in-eros-elementum-tristique-duis-cursus-mi-quis-viverra-ornare-eros-dolor-interdum-nulla-ut-commodo-diam-libero-vitae-erat {
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

    .actions {
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .button-primary {
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .button-primary button {
        height: 48px;
    }

    .site-content {
        background: #f1f1f1;
    }
</style>


<div class="home-block-1 container">
    <div class="column">
        <div class="medium-length-hero-headline-goes-here">
            The plant-based lifestyle without compromise
        </div>
    </div>
    <div class="column2">
        <div
            class="lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-suspendisse-varius-enim-in-eros-elementum-tristique-duis-cursus-mi-quis-viverra-ornare-eros-dolor-interdum-nulla-ut-commodo-diam-libero-vitae-erat">
            Live Complete delivers plant-based nutrition that’s nutritionally
            identical to animal products —without the downsides. No compromises on
            taste, texture, or health. Join us in creating a sustainable, complete
            lifestyle for you and the planet.
        </div>
        <div class="actions">
            <div class="button-primary">
                <a href="shop">
                    <button>Shop now</button>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .shop-by-category,
    .shop-by-category * {
        box-sizing: border-box;
    }

    .shop-by-category {
        background: linear-gradient(to left, #f2e5d5, #f2e5d5),
            linear-gradient(to left, #ffffff, #ffffff);
        padding-top: 64px;
        padding-bottom: 64px;
        display: flex;
        flex-direction: column;
        gap: 80px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }

    .shop-by-category .container {
        display: flex;
        flex-direction: row;
        gap: 80px;
        align-items: center;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .shop-by-category .content {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        width: 644px;
        position: relative;
    }

    .shop-by-category .content2 {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 24px;
        align-items: center;
        justify-content: center;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .shop-by-category .heading {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h3-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h3-font-size, 40px);
        line-height: var(--heading-desktop-h3-line-height, 120%);
        font-weight: var(--heading-desktop-h3-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .shop-by-category .text {
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

    .shop-by-category .list {
        padding: 8px 0px 8px 0px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .shop-by-category .list-item {
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .shop-by-category .checkmark {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        position: relative;
        overflow: visible;
    }

    .shop-by-category .list-item .list-item-content {
        font-family: 'Roboto';
        font-size: 16px;
        line-height: 150%;
        color: #000000;
    }

    .shop-by-category .image-prev {
        flex-shrink: 0;
        width: 588px;
        height: 610px;
        position: relative;
        object-fit: cover;
        height: auto;
    }

    .shop-by-category-wrapper {
        background: linear-gradient(to left, #f2e5d5, #f2e5d5),
            linear-gradient(to left, #ffffff, #ffffff);
    }
</style>

<div class="shop-by-category-wrapper">
    <div class="shop-by-category container">
        <div class="container">
            <div class="content">
                <div class="content2">
                    <div class="heading">
                        Personalized nutrition for
                        <br />
                        every lifestyle
                    </div>
                    <div class="text">
                        Our plant-based products are thoughtfully crafted to meet the unique
                        needs of different lifestyles. Whether you&#039;re looking for
                        everyday nutrition, fueling your athletic performance, embracing a
                        vegan diet, or supporting women&#039;s health, our bioequivalent
                        formulations deliver the nutrients you need without compromise.
                    </div>
                </div>
                <div class="list">
                    <div class="list-item">
                        <img class="checkmark" src="<?php echo get_template_directory_uri() . '/assets/image/checkmark.svg'; ?>" />
                        <div class="list-item-content">
                            <u><b>For Everyone:</b></u>
                            Balanced, nutritious options that fit seamlessly into your daily routine.
                        </div>
                    </div>
                    <div class="list-item">
                        <img class="checkmark" src="<?php echo get_template_directory_uri() . '/assets/image/checkmark.svg'; ?>" />
                        <div class="list-item-content">
                            <u><b>For Everyone</b></u>
                            Balanced, nutritious options that fit seamlessly into your daily routine.
                        </div>
                    </div>
                    <div class="list-item">
                        <img class="checkmark" src="<?php echo get_template_directory_uri() . '/assets/image/checkmark.svg'; ?>" />
                        <div class="list-item-content">
                            <u><b>For Everyone</b></u>
                            Balanced, nutritious options that fit seamlessly into your daily routine.
                        </div>
                    </div>
                    <div class="list-item">
                        <img class="checkmark" src="<?php echo get_template_directory_uri() . '/assets/image/checkmark.svg'; ?>" />
                        <div class="list-item-content">
                            <u><b>For Everyone</b></u>
                            Balanced, nutritious options that fit seamlessly into your daily routine.
                        </div>
                    </div>
                </div>
            </div>
            <div class="content2">
                <img class="image-prev" src="<?php echo get_template_directory_uri() . '/assets/image/shop-by-category.png'; ?>" />
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
