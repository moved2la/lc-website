<?php

/**
 * Template part for learn header
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

    .learn-header-wrapper {
        background: var(--background-color-primary, #ffffff);
        display: flex;
        flex-direction: column;
        gap: 80px;
        align-items: center;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
        flex-wrap: wrap;
        /* padding-left: calc((100% - 1320px) / 2); */
    }

    /* @media (min-width: 1200px) {
        .learn-header-wrapper {
            padding-left: calc((100% - 1360px) / 2);
        }
    }

    @media (min-width: 1025px) {
        .learn-header-wrapper {
            padding-left: calc((100% - 1000px) / 2);
        }
    } */

    .learn-header-wrapper .learn-header {
        display: flex;
        flex-direction: row;
        gap: 80px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .learn-header-wrapper .container {
        display: flex;
        flex-direction: row;
        gap: 80px;
        align-items: center;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
        flex-wrap: wrap;
    }

    /* @media (min-width:768px) {
        .learn-header-wrapper.container {
            width: calc(((100% - 750px) / 2) + 750px) !important;
            margin-right: 0;
            padding-right: 0;
        }
    }

    @media (min-width:992px) {
        .learn-header-wrapper.container {
            width: calc(((100% - 970px) / 2) + 970px) !important;
            margin-right: 0;
            padding-right: 0;
        }
    }

    @media (min-width:1200px) {
        .learn-header-wrapper.container {
            width: calc(((100% - 1360px) / 2) + 1360px) !important;
            margin-right: 0;
            padding-right: 0;
        }
    } */

    .learn-header-wrapper .column {
        /* padding: 0px 80px 0px 64px; */
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        position: relative;
        padding: 0;

    }

    .learn-header-wrapper .column2 {
        display: flex;
        flex: 1;
        flex-shrink: 1;
        flex-direction: column;
        gap: 24px;
        align-items: center;
        justify-content: center;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        min-width: 300px;
    }

    .learn-header-wrapper .content {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        max-width: 562px;
    }

    .learn-header-wrapper .learn-title {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h1-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h1-font-size, 56px);
        line-height: var(--heading-desktop-h1-line-height, 120%);
        font-weight: var(--heading-desktop-h1-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .learn-header-wrapper .learn-subtitle {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h3-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h3-font-size, 40px);
        line-height: var(--heading-desktop-h3-line-height, 120%);
        font-weight: var(--heading-desktop-h3-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .learn-header-wrapper .learn-description {
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

    .learn-header-wrapper .livecomplete-our-story-hero {
        flex-shrink: 0;
        position: relative;
        object-fit: cover;
    }

    .learn-header-wrapper .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        background-color: transparent;
        padding: 0;
        margin-bottom: 0;
    }

    .learn-header-wrapper .breadcrumb-item {
        color: var(--text-primary, #000000);
        text-decoration: none;
        font-family: var(--text-medium-normal-font-family, "Roboto-Regular", sans-serif);
        font-size: 16px;
        font-weight: 400;
    }

    .learn-header-wrapper .breadcrumb-item:not(.active):hover {
        text-decoration: underline;
        color: var(--text-primary, #000000);
    }

    .learn-header-wrapper .breadcrumb-item.active {
        color: var(--text-secondary, #666666);
        font-weight: 700;
    }

    .learn-header-wrapper .breadcrumb-separator {
        color: var(--text-secondary, #666666);
    }
</style>

<div class="learn-header-wrapper">
    <div class="learn-header container">
        <div class="container" style="padding-left: 0;">
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
            <div class="column2">
                <img
                    class="livecomplete-our-story-hero extend"
                    src="<?php echo get_field('learn_header_image') ?>" />
            </div>
        </div>
    </div>
</div>