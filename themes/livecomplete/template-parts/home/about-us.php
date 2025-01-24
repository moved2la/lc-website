<?php

/**
 * Template part for displaying about us section
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
?>

<style>
    .about-us-wrapper {
        background: #ffffff;
        padding-top: 60px;
        padding-bottom: 60px;
    }

    .about-us {
        display: flex;
        flex-direction: column;
        gap: 40px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }

    .about-us .section-header {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
        max-width: 768px;
    }

    .about-us .content {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .about-us .section-title {
        color: #000000;
        text-align: left;
        font-family: "Roboto-Bold", sans-serif;
        font-size: clamp(36px, 4vw, 48px);
        line-height: 120%;
        font-weight: 700;
        position: relative;
        align-self: stretch;
    }

    .about-us .section-description {
        color: var(--border-primary, #000000);
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

    .about-us .content2 {
        display: flex;
        flex-direction: column;
        gap: 64px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .about-us .about-us-row {
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

    .about-us .content3 {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
        max-width: 416px;
        min-width: 300px;
    }

    .about-us .section-one {
        flex-shrink: 0;
        width: 100px;
        height: 100px;
        position: relative;
        overflow: hidden;
    }

    .about-us .group {
        width: 96.84%;
        height: 61.73%;
        position: absolute;
        right: 1.56%;
        left: 1.6%;
        bottom: 19.1%;
        top: 19.18%;
        overflow: visible;
    }

    .about-us .content4 {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .about-us .section-column-title {
        color: var(--border-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h5-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h5-font-size, 24px);
        line-height: var(--heading-desktop-h5-line-height, 140%);
        font-weight: var(--heading-desktop-h5-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .about-us .section-column-description {
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

    .about-us .category-link {
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: flex-start;
        flex-shrink: 0;
        width: 109px;
        position: relative;
        width: fit-content;
    }

    .about-us .button {
        color: var(--border-primary, #000000);
        text-align: left;
        font-family: "Roboto-SemiBold", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 600;
        position: relative;
    }

    .about-us .icon-chevron-right {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }

    .about-us .section-two {
        flex-shrink: 0;
        width: 100px;
        height: 100px;
        position: relative;
        overflow: hidden;
    }

    .about-us .section-three {
        flex-shrink: 0;
        width: 100px;
        height: 100px;
        position: relative;
        overflow: hidden;
    }

    @media screen and (max-width: 768px) {
        .about-us .section-one,
        .about-us .section-two,
        .about-us .section-three {
            margin: 0 auto;
            align-self: center;
        }

        .about-us .content3 {
            align-items: center;
        }
    }
</style>

<div class="about-us-wrapper">
    <div class="about-us container">
        <div class="section-header">
            <div class="content">
                <h2 class="section-title">
                    Redefining plant-based living
                </h2>
                <div class="section-description">
                    Discover how we’re transforming plant-based living through innovation,
                    sustainability, and a commitment to better health for people and the
                    planet. Join us in building a future where every choice is impactful,
                    every product is intentional, and no compromise is necessary.
                </div>
            </div>
        </div>
        <div class="content2">
            <div class="about-us-row">
                <div class="content3">
                    <div class="section-one">
                        <img class="group" src="<?php echo get_template_directory_uri() . '/assets/image/about-us-journey.svg'; ?>" />
                    </div>
                    <div class="content4">
                        <h5 class="section-column-title">
                            Our journey to complete nutrition
                        </h5>
                        <div class="section-column-description">
                            Discover how Live Complete began with a bold vision: to
                            revolutionize plant-based living with products that offer complete
                            nutrition, unparalleled taste, and zero compromise. Learn more about
                            the passion driving us forward.
                        </div>
                        <a href="<?php echo home_url('/learn/our-story/'); ?>"
                            class="category-link ">
                            <div class="button">Read our story</div>
                            <img class="icon-chevron-right" src="<?php echo get_template_directory_uri() . '/assets/image/icon-chevron.svg'; ?>" />
                        </a>
                    </div>
                </div>
                <div class="content3">
                    <div class="section-two">
                        <img class="group" src="<?php echo get_template_directory_uri() . '/assets/image/about-us-science.svg'; ?>" />
                    </div>
                    <div class="content4">
                        <h5 class="section-column-title">
                            What sets us apart
                        </h5>
                        <div class="section-column-description">
                            Explore the science and innovation behind our bioequivalent
                            formulations. See how we match the nutrition of animal
                            products—without the downsides—delivering taste, texture, and
                            efficiency unmatched in the plant-based world.
                        </div>
                        <a href="<?php echo home_url('/learn/the-difference/'); ?>"
                            class="category-link ">
                            <div class="button">Discover the difference</div>
                            <img class="icon-chevron-right" src="<?php echo get_template_directory_uri() . '/assets/image/icon-chevron.svg'; ?>" />
                        </a>
                    </div>
                </div>
                <div class="content3">
                    <div class="section-three">
                        <img class="group" src="<?php echo get_template_directory_uri() . '/assets/image/about-us-impact.svg'; ?>" />
                    </div>
                    <div class="content4">
                        <h5 class="section-column-title">
                            Impacting health, planet, and animals
                        </h5>
                        <div
                            class="section-column-description">
                            Learn how Live Complete is shaping a healthier, more sustainable
                            future. From reducing environmental impact to saving animal lives,
                            see how every choice you make with us contributes to meaningful
                            change.
                        </div>
                        <a href="<?php echo home_url('/learn/our-impact/'); ?>"
                            class="category-link ">
                            <div class="button">Learn about our impact</div>
                            <img class="icon-chevron-right" src="<?php echo get_template_directory_uri() . '/assets/image/icon-chevron.svg'; ?>" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>