<?php

/**
 * Template part for displaying nutrition section
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
?>

<style>
    .shop-by-category-wrapper {
        background: linear-gradient(to left, #f2e5d5, #f2e5d5),
            linear-gradient(to left, #ffffff, #ffffff);
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
        flex-wrap: wrap;
    }

    .shop-by-category .content {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        max-width: 644px;
        position: relative;
        width: 100%;
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
        color: #000000;
        text-align: left;
        font-family: "Roboto-Bold", sans-serif;
        font-size: clamp(36px, 4vw, 40px);
        line-height: 120%;
        font-weight: 700;
        position: relative;
        align-self: stretch;
    }

    .shop-by-category .text {
        color: #000000;
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 18px;
        line-height: 150%;
        font-weight: 400;
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
        min-width: 345px;
        position: relative;
        object-fit: cover;
        height: auto;
    }
</style>

<div class="shop-by-category-wrapper">
    <div class="shop-by-category container">
        <div class="container">
            <div class="content">
                <div class="content2">
                    <h3 class="heading">
                        Personalized nutrition for
                        every lifestyle
                    </h3>
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