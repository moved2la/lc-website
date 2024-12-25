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
    .live-complete-breadcrumbs-wrap {
        display: none;
    }

    .home-learn-our-story {
        margin-top: 51px;
    }

    .header-36 {
        background: var(--background-color-primary, #ffffff);
        display: flex;
        flex-direction: row;
        gap: 80px;
        align-items: center;
        justify-content: flex-start;
        max-height: 662px;
        position: relative;
        overflow: hidden;
    }

    /* .container {
        display: flex;
        flex-direction: row;
        gap: 0px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        height: 647px;
        position: relative;
    } */

    .column {
        padding: 0px 80px 0px 64px;
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: center;
        align-self: stretch;
        flex: 1;
        position: relative;
        padding: 0;
        justify-content: flex-start;
    }

    .content {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .learn-title {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h1-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h1-font-size, 56px);
        line-height: var(--heading-desktop-h1-line-height, 120%);
        font-weight: var(--heading-desktop-h1-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .learn-subtitle {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h3-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h3-font-size, 40px);
        line-height: var(--heading-desktop-h3-line-height, 120%);
        font-weight: var(--heading-desktop-h3-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .learn-description {
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

    .livecomplete-our-story-hero {
        flex-shrink: 0;
        width: 734px;
        height: 675px;
        position: relative;
        object-fit: cover;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        background-color: transparent;
        padding: 0;
        margin-bottom: 0;
    }

    .breadcrumb-item {
        color: var(--text-primary, #000000);
        text-decoration: none;
        font-family: var(--text-medium-normal-font-family, "Roboto-Regular", sans-serif);
        font-size: 16px;
        font-weight: 400;
    }

    .breadcrumb-item:not(.active):hover {
        text-decoration: underline;
        color: var(--text-primary, #000000);
    }

    .breadcrumb-item.active {
        color: var(--text-secondary, #666666);
        font-weight: 700;
    }

    .breadcrumb-separator {
        color: var(--text-secondary, #666666);
    }
</style>

<div class="header-36 container">
    <!-- <div class="container"> -->
    <div class="column">
        <div class="home-learn-our-story">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo home_url(); ?>" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-separator">/</span>
                <a href="<?php echo home_url('/learn'); ?>" class="breadcrumb-item">Learn</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-item active"><?php echo get_the_title(); ?></span>
            </nav>
        </div>
        <div class="content">
            <div class="learn-title"><?php echo get_field('learn_header_title') ?></div>
            <div class="learn-subtitle">
                <?php echo get_field('learn_header_subtitle') ?>
            </div>
            <div class="learn-description">
                <?php echo get_field('learn_header_description') ?>
            </div>
        </div>
    </div>
    <img
        class="livecomplete-our-story-hero"
        src="<?php echo get_field('learn_header_image') ?>" />
    <!-- </div> -->
</div>