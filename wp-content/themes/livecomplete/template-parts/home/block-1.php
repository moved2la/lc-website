<?php

/**
 * Template part for displaying Shop Now section
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
?>

<style>
    .home-block-1-wrapper {
        background: #f1f1f1;
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
        flex-wrap: wrap;
    }

    .home-block-1 .column {
        display: flex;
        flex-direction: column;
        gap: 0px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        width: 504px;
        position: relative;
    }

    .home-block-1 .medium-length-hero-headline-goes-here {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h1-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h1-font-size, 56px);
        line-height: var(--heading-desktop-h1-line-height, 120%);
        font-weight: var(--heading-desktop-h1-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .home-block-1 .column2 {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
    }

    .home-block-1 .lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-suspendisse-varius-enim-in-eros-elementum-tristique-duis-cursus-mi-quis-viverra-ornare-eros-dolor-interdum-nulla-ut-commodo-diam-libero-vitae-erat {
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

    .home-block-1 .actions {
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .home-block-1 .button-primary {
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .home-block-1 .button-primary button {
        height: 48px;
    }

    .home-block-1 .site-content {
        background: #f1f1f1;
    }
</style>

<div class="home-block-1-wrapper">
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
</div>