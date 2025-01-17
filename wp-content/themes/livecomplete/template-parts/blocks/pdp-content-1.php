<?php

/**
 * Template part for displaying the first content 
 * block under summary on product page.
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<div class="pdp-content-1">
    <div class="pdp-content-1__container">
        <div class="pdp-content-1__column">
            <?php
            $image_id = get_theme_mod('pdp_content_1_image');
            if ($image_id) {
                echo wp_get_attachment_image($image_id, 'full', false, array(
                    'class' => 'pdp-content-1__image',
                ));
            }
            ?>
        </div>
        <div class="pdp-content-1__column">
            <div class="content2">
                <div class="pdp-content-1__heading">
                    Discover the power of plant-based protein for every moment of your day
                </div>
                <div class="pdp-content-1__text">
                    Our All Day Anytime Protein is designed to fuel your body with
                    high-quality, plant-based nutrition. Enjoy the benefits of
                    muscle-equivalent protein without compromising your values.
                </div>
            </div>
            <div class="pdp-content-1__list">
                <div class="pdp-content-1__list-item">
                    <img
                        class="pdp-content-1__checkmark"
                        src="<?php echo get_template_directory_uri() . '/assets/image/checkmark.svg'; ?>" />
                    <div class="pdp-content-1__list-item-text">
                        Complete protein source for all lifestyles.
                    </div>
                </div>
                <div class="pdp-content-1__list-item">
                    <img
                        class="pdp-content-1__checkmark"
                        src="<?php echo get_template_directory_uri() . '/assets/image/checkmark.svg'; ?>" />
                    <div class="pdp-content-1__list-item-text">
                        Rich in essential amino acids for recovery.
                    </div>
                </div>
                <div class="pdp-content-1__list-item">
                    <img
                        class="pdp-content-1__checkmark"
                        src="<?php echo get_template_directory_uri() . '/assets/image/checkmark.svg'; ?>" />
                    <div class="pdp-content-1__list-item-text">
                        Perfect for smoothies, baking, or on-the-go snacks.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .pdp-content-1 {
        width: 100%;
    }

    .pdp-content-1 .pdp-content-1__container {
        display: flex;
        flex-direction: row;
        gap: 40px;
        margin: 0 auto;
        flex-wrap: wrap;
    }

    .pdp-content-1 .pdp-content-1__column {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .pdp-content-1 .pdp-content-1__image {
        width: 100%;
        height: auto;
        position: relative;
        object-fit: contain;
        aspect-ratio: 1/1;
    }

    .pdp-content-1 .content2 {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .pdp-content-1 .pdp-content-1__heading {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h3-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h3-font-size, 40px);
        line-height: var(--heading-desktop-h3-line-height, 120%);
        font-weight: var(--heading-desktop-h3-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .pdp-content-1 .pdp-content-1__text {
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

    .pdp-content-1 .pdp-content-1__list {
        padding: 8px 0px 8px 0px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        margin-top: 32px;
    }

    .pdp-content-1 .pdp-content-1__list-item {
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: center;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .pdp-content-1 .pdp-content-1__checkmark {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        position: relative;
        overflow: visible;
    }

    .pdp-content-1 .pdp-content-1__list-item-text {
        color: #000000;
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
        flex: 1;
    }

    @media screen and (max-width: 768px) {
        .pdp-content-1 .pdp-content-1__container {
            flex-direction: column-reverse;
            gap: 1rem;
            /* Reduced gap for mobile */
        }

        .pdp-content-1 .pdp-content-1__column {
            width: 100%;
        }
    }
</style>