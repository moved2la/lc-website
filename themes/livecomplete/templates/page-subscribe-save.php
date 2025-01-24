<?php

/**
 * Template Name: Subscribe & Save Page
 * The template for displaying the subscribe and save page
 *
 * @package live-complete
 */

get_header();

$layout = live_complete_get_option('page_layout');

/**
 * Hook - live_complete_container_wrap_start 	
 *
 * @hooked live_complete_container_wrap_start - 5
 */
do_action('live_complete_container_wrap_start', esc_attr($layout));

?>


<style>
    /* Header */
    .live-complete-breadcrumbs-wrap {
        background-color: #fff;
    }

    .subscribe-save-header {
        background: var(--background-color-primary, #ffffff);
        display: flex;
        flex-direction: column;
        gap: 80px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
        margin-bottom: 60px;
    }

    .subscribe-save-header .content {
        display: flex;
        flex-direction: row;
        gap: 40px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .subscribe-save-header .column {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
    }

    .subscribe-save-header .header-title {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h1-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h1-font-size, 56px);
        line-height: var(--heading-desktop-h1-line-height, 120%);
        font-weight: var(--heading-desktop-h1-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .subscribe-save-header .header-description {
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
        margin-bottom: 0;
    }

    /* Section 1 */
    .subscribe-save-section-1-wrapper {
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        width: 100vw;
        background: linear-gradient(to left, #f2e5d5, #f2e5d5),
            linear-gradient(to left, #ffffff, #ffffff);
        display: flex;
        flex-direction: column;
        gap: 80px;
        align-items: center;
        justify-content: flex-start;
        overflow: hidden;

    }

    .subscribe-save-section-1 {
        width: 100%;
        background: linear-gradient(to left, #f2e5d5, #f2e5d5),
            linear-gradient(to left, #ffffff, #ffffff);
        padding-top: 60px;
        padding-bottom: 60px;
        display: flex;
        flex-direction: column;
        gap: 80px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }

    .subscribe-save-section-1 .content {
        display: flex;
        flex-direction: row;
        gap: 80px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        flex-wrap: wrap;
    }

    .subscribe-save-section-1 .column {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
        /* max-width:  */
    }

    /* .subscribe-save-section-1 .content2 {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    } */

    .subscribe-save-section-1 .heading {
        color: #000;
        text-align: left;
        font-family: "Roboto-Bold", sans-serif;
        font-size: 48px;
        line-height: 120%;
        font-weight: 700;
        position: relative;
        align-self: stretch;
    }

    .subscribe-save-section-1 .actions {
        display: flex;
        flex-direction: row;
        gap: 24px;
        align-items: center;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .subscribe-save-section-1 .button-secondary {
        border-style: solid;
        border-color: #0e4c73;
        border-width: 2px;
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
    }

    .subscribe-save-section-1 .button {
        background-color: transparent;
        color: #0e4c73;
        text-align: left;
        font-family: "Roboto-SemiBold", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 600;
        position: relative;
    }

    .subscribe-save-section-1 .timeline {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-start;
        /* flex: 1; */
        position: relative;
    }

    .subscribe-save-section-1 .timeline-item {
        display: flex;
        flex-direction: row;
        gap: 40px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        margin: 0;
        padding: 0;
    }

    .subscribe-save-section-1 .timeline-iconography {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: center;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .subscribe-save-section-1 .subscribe-save-icon {
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        position: relative;
        overflow: visible;
    }

    .subscribe-save-section-1 .divider {
        background: #000;
        border-style: solid;
        border-color: #000;
        border-width: 2px 0 0 0;
        width: 2px;
        height: 100px;
        margin-bottom: 16px;
    }

    .subscribe-save-section-1 .timeline-content {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
    }

    .subscribe-save-section-1 .timeline-heading {
        color: #000;
        text-align: left;
        font-family: "Roboto-Bold", sans-serif;
        font-size: 20px;
        line-height: 140%;
        font-weight: 700;
        position: relative;
        align-self: stretch;
    }

    .subscribe-save-section-1 .timeline-text {
        color: #000;
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
        align-self: stretch;
    }


    /* About Subscribe & Save */
    .about-subscribe-save {
        background: #ffffff;
        padding-top: 60px;
        padding-bottom: 60px;
        display: flex;
        flex-direction: column;
        gap: 40px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }

    .about-subscribe-save-title {
        color: #000;
        text-align: left;
        font-family: "Roboto-Bold", sans-serif;
        font-size: 48px;
        line-height: 120%;
        font-weight: 700;
        position: relative;
        align-self: stretch;
    }

    .about-subscribe-save-row {
        display: flex;
        flex-direction: row;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        flex-wrap: wrap;
    }

    .about-subscribe-save-row-item {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
        min-width: 300px;
    }

    .about-subscribe-save-row-item-icon {
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        position: relative;
        overflow: visible;
    }

    .about-subscribe-save-row-item-content {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .about-subscribe-save-row-item-content-title {
        color: #000;
        text-align: left;
        font-family: "Roboto-Bold", sans-serif;
        font-size: var(--heading-desktop-h5-font-size, 24px);
        line-height: var(--heading-desktop-h5-line-height, 140%);
        font-weight: var(--heading-desktop-h5-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .about-subscribe-save-row-item-content-text {
        color: var(--border-primary, #000000);
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
</style>

<div class="subscribe-save-header">
    <div class="content">
        <div class="column">
            <h1 class="header-title">Save with ease</h1>
        </div>
        <div class="column">
            <p class="header-description">
                Join our Subscribe &amp; Save program to enjoy hassle-free deliveries of
                your favorite plant-based products. Experience the convenience of
                savings while nourishing your body with the best alternatives to
                traditional animal products.
            </p>
        </div>
    </div>
</div>

<div class="subscribe-save-section-1-wrapper">
    <div class="subscribe-save-section-1 container">
        <div class="content">
            <div class="column">
                <div class="heading">As simple as …</div>
                <div class="actions">
                    <div class="button-secondary">
                        <a href="<?php echo get_permalink(get_page_by_path('shop')); ?>"><button class="button">Shop now</button></a>
                    </div>
                </div>
            </div>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-iconography">
                        <img class="subscribe-save-icon" src="<?php echo get_template_directory_uri() . '/assets/image/icon-subcribe.svg'; ?>" />
                        <div class="divider"></div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-heading">Select your products</div>
                        <div class="timeline-text">
                            Select any product and get special subscriber pricing from the menu.
                        </div>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-iconography">
                        <img class="subscribe-save-icon" src="<?php echo get_template_directory_uri() . '/assets/image/icon-subcribe.svg'; ?>" />
                        <div class="divider"></div>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-heading">Choose frequency</div>
                        <div class="timeline-text">
                            Have them delivered with the frequency that you want.
                        </div>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-iconography">
                        <img class="subscribe-save-icon" src="<?php echo get_template_directory_uri() . '/assets/image/icon-subcribe.svg'; ?>" />
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-heading">Change anytime</div>
                        <div class="timeline-text">
                            Need to change products? Cancel? Skip a month? Anytime. No problem.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="about-subscribe-save">
    <div class="section-title">
        <h2 class="about-subscribe-save-title">
            Shipped right to your door
        </h2>
    </div>
    <div class="about-subscribe-save-row">
        <div class="about-subscribe-save-row-item">
            <img class="about-subscribe-save-row-item-icon" src="<?php echo get_template_directory_uri() . '/assets/image/icon-subcribe.svg'; ?>" />
            <div class="about-subscribe-save-row-item-content">
                <div class="about-subscribe-save-row-item-content-title">
                    20% off + Free Shipping
                </div>
                <div
                    class="about-subscribe-save-row-item-content-text">
                    Discover how Live Complete began with a bold vision: to
                    revolutionize plant-based living with products that offer complete
                    nutrition, unparalleled taste, and zero compromise. Learn more about
                    the passion driving us forward.
                </div>
            </div>
        </div>
        <div class="about-subscribe-save-row-item">
            <img class="about-subscribe-save-row-item-icon" src="<?php echo get_template_directory_uri() . '/assets/image/icon-subcribe.svg'; ?>" />
            <div class="about-subscribe-save-row-item-content">
                <div class="about-subscribe-save-row-item-content-title">Risk-free</div>
                <div
                    class="about-subscribe-save-row-item-content-text">
                    Explore the science and innovation behind our bioequivalent
                    formulations. See how we match the nutrition of animal
                    products—without the downsides—delivering taste, texture, and
                    efficiency unmatched in the plant-based world.
                </div>
            </div>
        </div>
        <div class="about-subscribe-save-row-item">
            <img class="about-subscribe-save-row-item-icon" src="<?php echo get_template_directory_uri() . '/assets/image/icon-subcribe.svg'; ?>" />
            <div class="about-subscribe-save-row-item-content">
                <div class="about-subscribe-save-row-item-content-title">
                    Exclusive early access
                </div>
                <div
                    class="about-subscribe-save-row-item-content-text">
                    Learn how Live Complete is shaping a healthier, more sustainable
                    future. From reducing environmental impact to saving animal lives,
                    see how every choice you make with us contributes to meaningful
                    change.
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
