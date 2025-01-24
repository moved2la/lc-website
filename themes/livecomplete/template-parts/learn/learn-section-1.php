<?php

/**
 * Template part for learn section 1
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<style>
    .learn-section-1-wrapper {
        background: #f2e5d5;
        padding: 64px 0 64px 0;
        display: flex;
        flex-direction: column;
        gap: 30px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }

    .learn-section-1-wrapper .content {
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

    .learn-section-1-wrapper .column {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }

    .learn-section-1-wrapper .tagline-wrapper {
        display: flex;
        flex-direction: row;
        gap: 0px;
        align-items: center;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .learn-section-1-wrapper .tagline {
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

    .learn-section-1-wrapper .heading {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h2-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h2-font-size, 48px);
        line-height: var(--heading-desktop-h2-line-height, 120%);
        font-weight: var(--heading-desktop-h2-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .learn-section-1-wrapper .column2 {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
    }

    .learn-section-1-wrapper .content2 {
        display: flex;
        flex-direction: column;
        gap: 0px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .learn-section-1-wrapper .text {
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

    .learn-section-1-wrapper .content3 {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .learn-section-1-wrapper .content-row {
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

    .learn-section-1-wrapper .list-item {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
    }

    .learn-section-1-wrapper .noun-journey-7320542-3 {
        flex-shrink: 0;
        width: 100px;
        height: 100px;
        position: relative;
        overflow: hidden;
    }

    .learn-section-1-wrapper .group {
        width: 96.84%;
        height: 61.73%;
        position: absolute;
        right: 1.56%;
        left: 1.6%;
        bottom: 19.1%;
        top: 19.18%;
        overflow: visible;
    }

    .learn-section-1-wrapper .heading2 {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h6-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h6-font-size, 20px);
        line-height: var(--heading-desktop-h6-line-height, 140%);
        font-weight: var(--heading-desktop-h6-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .learn-section-1-wrapper .group2 {
        width: 96.84%;
        height: 61.73%;
        position: absolute;
        right: 1.56%;
        left: 1.6%;
        bottom: 19.1%;
        top: 19.18%;
        overflow: visible;
    }
</style>

<div class="learn-section-1-wrapper">
    <div class="content container">
        <div class="column">
            <div class="tagline-wrapper">
                <div class="tagline">Our roots</div>
            </div>
            <div class="heading">
                Planting the seeds
                <br />
                of change
            </div>
        </div>
        <div class="column2">
            <div class="content2">
                <div class="text">
                    We started with a passion for plant-based living and a belief in
                    making a real difference. What began as an idea to create better food
                    options soon expanded into a full range of plant-based products aimed
                    at transforming everyday lives.
                </div>
                <div class="content3 content-row">
                    <!-- <div class="row"> -->
                        <div class="list-item">
                            <div class="noun-journey-7320542-3">
                                <img class="group" src="<?php echo get_template_directory_uri() . '/assets/image/about-us-journey.svg' ?>" />
                            </div>
                            <div class="heading2">
                                Founded with sustainability
                                <br />
                                in mind
                            </div>
                        </div>
                        <div class="list-item">
                            <div class="noun-journey-7320542-3">
                                <img class="group" src="<?php echo get_template_directory_uri() . '/assets/image/about-us-journey.svg' ?>" />
                            </div>
                            <div class="heading2">
                                From small-scale experiments to large-scale impact
                            </div>
                        </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>