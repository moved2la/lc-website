<?php

/**
 * Template part for learn section 2
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<style>
    .content {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
    }

    .content2 {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .section-title {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .tagline-wrapper {
        display: flex;
        flex-direction: row;
        gap: 0px;
        align-items: center;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .tagline {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-tagline-font-family,
                "Roboto-SemiBold",
                sans-serif);
        font-size: var(--heading-desktop-tagline-font-size, 16px);
        line-height: var(--heading-desktop-tagline-line-height, 150%);
        font-weight: var(--heading-desktop-tagline-font-weight, 600);
        position: relative;
    }

    .content3 {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .heading {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h2-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h2-font-size, 48px);
        line-height: var(--heading-desktop-h2-line-height, 120%);
        font-weight: var(--heading-desktop-h2-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .text {
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

    .list {
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

    .list-item {
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: center;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .noun-checkmark-7280362-1 {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        position: relative;
        overflow: visible;
    }

    .lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--text-regular-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-regular-normal-font-size, 16px);
        line-height: var(--text-regular-normal-line-height, 150%);
        font-weight: var(--text-regular-normal-font-weight, 400);
        position: relative;
        flex: 1;
    }

    .noun-checkmark-7280362-12 {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        position: relative;
        overflow: visible;
    }
</style>

<div class="learn-header-wrapper">
    <div class="learn-header container">
        <div class="container" style="padding-left: 0;">
            <div class="column">
                <img
                    class="livecomplete-our-story-hero extend"
                    src="<?php echo get_field('learn_header_image') ?>" />
            </div>
            <div class="column2">
                <div class="content">
                    <div class="content2">
                        <div class="section-title">
                            <div class="tagline-wrapper">
                                <div class="tagline">Our vision</div>
                            </div>
                            <div class="content3">
                                <div class="heading">Shaping a future rooted in sustainability</div>
                                <div class="text">
                                    We envision a world where plant-based alternatives are not just
                                    options but the preferred choice for people looking to live healthier,
                                    more sustainable lives.
                                </div>
                                <div class="list">
                                    <div class="list-item">
                                        <img
                                            class="noun-checkmark-7280362-1"
                                            src="<?php echo get_template_directory_uri() . '/assets/image/checkmark.svg' ?>" />
                                        <div class="lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit">
                                            Empowering consumers to make conscious choices
                                        </div>
                                    </div>
                                    <div class="list-item">
                                        <img
                                            class="noun-checkmark-7280362-12"
                                            src="<?php echo get_template_directory_uri() . '/assets/image/checkmark.svg' ?>" />
                                        <div class="lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit">
                                            Striving for a healthier, greener planet
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>