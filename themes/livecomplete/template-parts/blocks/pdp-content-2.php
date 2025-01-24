<?php

/**
 * Template part for displaying the second content 
 * block under summary on product page.
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<div class="pdp-content-2">
    <div class="pdp-content-2__container">

        <div class="pdp-content-2__column">
            <div class="content2">
                <h3 class="pdp-content-2__heading">
                    Complete nutrition, no compromises
                </h3>
                <div class="pdp-content-1__text">
                    Revolutionize your protein game with our plant-based powder,
                    bioequivalent to animal proteins. Enjoy the same nutritional
                    benefits without the downsides.
                </div>
            </div>
            <div class="pdp-content-2__list">
                <div class="pdp-content-2__list-row">
                    <div class="pdp-content-2__list-item">
                        <div class="pdp-content-2__list-item-heading">100% Efficiency</div>
                        <div class="pdp-content-2__list-item-text">
                            Matches human muscle profile for optimal muscle repair and growth.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pdp-content-2__column">
            <?php
            $image_id = get_theme_mod('pdp_content_2_image');
            if ($image_id) {
                echo wp_get_attachment_image($image_id, 'full', false, array(
                    'class' => 'pdp-content-2__image',
                ));
            }
            ?>
        </div>
    </div>
</div>

<style>
    .pdp-content-2 {
        width: 100%;
    }

    .pdp-content-2 .pdp-content-2__container {
        display: flex;
        flex-direction: row;
        gap: 40px;
        margin: 0 auto;
        flex-wrap: wrap;
    }

    .pdp-content-2 .pdp-content-2__column {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .pdp-content-2 .pdp-content-2__image {
        width: 100%;
        height: auto;
        position: relative;
        object-fit: contain;
        aspect-ratio: 1/1;
    }

    .pdp-content-2 .content2 {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .pdp-content-2 .pdp-content-2__heading {
        color: #000000;
        text-align: left;
        font-family: "Roboto-Bold", sans-serif;
        font-size: clamp(32px, 4vw, 40px);
        line-height: 120%;
        font-weight: 700;
        position: relative;
        align-self: stretch;
    }

    .pdp-content-2 .pdp-content-2__text {
        color: #000000;
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 18px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
        align-self: stretch;
    }

    .pdp-content-2 .pdp-content-2__list {
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

    .pdp-content2 .pdp-content-2__list-row {
        padding: 8px 0px 8px 0px;
        display: flex;
        flex-direction: row;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .pdp-content-2 .pdp-content-2__checkmark {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        position: relative;
        overflow: visible;
    }

    .pdp-content-2 .pdp-content-2__list-item-heading {
        color: #d9734d;
        text-align: left;
        font-family: "Roboto-Bold", sans-serif;
        font-size: 48px;
        line-height: 120%;
        font-weight: 700;
        position: relative;
    }

    .pdp-content-2 .pdp-content-2__list-item-text {
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
        .pdp-content-2 .pdp-content-2__container {
            gap: 1rem; /* Reduced gap for mobile */
        }

        .pdp-content-2 .pdp-content-2__column {
            width: 100%;
            flex: none;
        }
    }
</style>