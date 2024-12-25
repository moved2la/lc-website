<?php

/**
 * Template part for learn categories
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<style>
    .learn-wrapper {
        background: var(--background-color-primary, #ffffff);
        padding-bottom: 64px;
        display: flex;
        flex-direction: column;
        gap: 80px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
        flex-wrap: wrap;
    }

    .learn-wrapper .heading {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h1-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h1-font-size, 56px);
        line-height: var(--heading-desktop-h1-line-height, 120%);
        font-weight: var(--heading-desktop-h1-font-weight, 700);
        position: relative;
        width: 768px;
    }

    .learn-wrapper .content {
        display: flex;
        flex-direction: row;
        gap: 64px;
        align-items: flex-start;
        justify-content: center;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        flex-wrap: wrap;
    }

    .learn-wrapper .column {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
        overflow: hidden;
        max-width: 405px;
        /* max-height: 426px; */
    }

    .learn-wrapper .placeholder-image {
        align-self: stretch;
        flex-shrink: 0;
        height: 240px;
        position: relative;
        object-fit: cover;
    }

    .learn-wrapper .content2 {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .learn-wrapper .content3 {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .learn-wrapper .heading2 {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h5-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h5-font-size, 24px);
        line-height: var(--heading-desktop-h5-line-height, 140%);
        font-weight: var(--heading-desktop-h5-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .learn-wrapper .text {
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

    .learn-wrapper .action {
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .learn-wrapper .style-link-small-false-alternate-false-icon-position-trailing {
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .learn-wrapper .button {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
    }

    .learn-wrapper .button a:hover {
        color: var(--text-primary, #000000);
        text-decoration: underline;
    }

    .learn-wrapper .icon-chevron-right {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }
</style>

<div class="learn-wrapper container">
    <div class="heading">Lorem ipsum dolor sit amet</div>
    <div class="content">
        <!-- <div class="row"> -->
        <div class="column">
            <img class="placeholder-image" src="<?php echo get_template_directory_uri() . '/assets/image/placeholder.png'; ?>" />
            <div class="content2">
                <div class="content3">
                    <div class="heading2">Our story</div>
                    <div class="text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce
                        interdum justo orci, sed suscipit elit pretium vitae.
                    </div>
                </div>
                <div class="action">
                    <div
                        class="style-link-small-false-alternate-false-icon-position-trailing">
                        <div class="button"><a href="<?php echo get_permalink(154); ?>">Read our story</a></div>
                        <img class="icon-chevron-right" src="<?php echo get_template_directory_uri() . '/assets/image/icon-chevron.svg'; ?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <img class="placeholder-image" src="<?php echo get_template_directory_uri() . '/assets/image/placeholder.png'; ?>" />
            <div class="content2">
                <div class="content3">
                    <div class="heading2">The difference</div>
                    <div class="text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce
                        interdum justo orci, sed suscipit elit pretium vitae.
                    </div>
                </div>
                <div class="action">
                    <div
                        class="style-link-small-false-alternate-false-icon-position-trailing">
                        <div class="button"><a href="<?php echo get_permalink(156); ?>">Discover the difference</a></div>
                        <img class="icon-chevron-right" src="<?php echo get_template_directory_uri() . '/assets/image/icon-chevron.svg'; ?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <img class="placeholder-image" src="<?php echo get_template_directory_uri() . '/assets/image/placeholder.png'; ?>" />
            <div class="content2">
                <div class="content3">
                    <div class="heading2">Our impact</div>
                    <div class="text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce
                        interdum justo orci, sed suscipit elit pretium vitae.
                    </div>
                </div>
                <div class="action">
                    <div
                        class="style-link-small-false-alternate-false-icon-position-trailing">
                        <div class="button"><a href="<?php echo get_permalink(158); ?>">Learn about our impact</a></div>
                        <img class="icon-chevron-right" src="<?php echo get_template_directory_uri() . '/assets/image/icon-chevron.svg'; ?>" />
                    </div>
                </div>
            </div>
        </div>
        <!-- </div> -->
    </div>
</div>