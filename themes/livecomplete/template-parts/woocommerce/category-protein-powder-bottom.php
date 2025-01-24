<?php

/**
 * Template part for Protein Powder CLP page bottom section
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<style>
    .features-benefits-wrapper {
        padding: 40px 0 40px 0;
        background: #f2e5d5;
    }

    .features-benefits {
        display: flex;
        flex-direction: column;
        gap: 40px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }

    .features-benefits .section-title {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        width: 100%;
        position: relative;
    }

    .features-benefits .content {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .features-benefits .section-heading {
        text-align: left;
        font-family: "Roboto-Bold", sans-serif;
        font-size: 48px;
        line-height: 120%;
        font-weight: 700;
        position: relative;
        align-self: stretch;
    }

    .features-benefits .section-desc {
        text-align: left;
        font-family: "-", sans-serif;
        font-size: 18px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
        align-self: stretch;
    }

    .features-benefits .content2 {
        display: flex;
        flex-direction: column;
        gap: 64px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .features-benefits .content-row {
        display: flex;
        flex-direction: row;
        gap: 48px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        flex-wrap: wrap;
    }

    .features-benefits .column {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
    }

    @media only screen and (max-width: 1024px) {
        .features-benefits .column {
            flex: none;
        }
    }

    .features-benefits .feature-image {
        flex-shrink: 0;
        width: 100px;
        height: 100px;
        position: relative;
        overflow: hidden;
    }

    .features-benefits .feature-heading {
        text-align: left;
        font-family: "Roboto-Bold", sans-serif;
        font-size: 32px;
        line-height: 130%;
        font-weight: 700;
        position: relative;
        align-self: stretch;
    }

    .features-benefits .feature-desc {
        text-align: left;
        font-family: "-", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
        align-self: stretch;
    }
</style>

<div class="features-benefits-wrapper">
    <div class="features-benefits container">
        <div class="section-title">
            <div class="content">
                <div class="section-heading">Discover the future of protein nutrition</div>
                <div class="section-desc">
                    <span>
                        <span class="text-span">
                            Our protein powders are crafted from premium
                        </span>
                        <span class="text-span2">plant-based ingredients</span>
                        <span class="text-span3">
                            that mirror the benefits of traditional protein sources. Enjoy a
                            clean,
                        </span>
                        <span class="text-span4">nutritious boost</span>
                        <span class="text-span5">
                            without the downsides of animal products.
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <div class="content2">
            <div class="content-row">
                <div class="column">
                    <img class="feature-image" src="<?php echo get_template_directory_uri() . '/assets/image/about-us-science.svg'; ?>" />
                    <div class="feature-heading">Benefits of our unique protein formulation</div>
                    <div class="feature-desc">
                        Experience superior digestibility and
                        <u>bioavailability</u>.
                    </div>
                </div>
                <div class="column">
                    <img class="feature-image" src="<?php echo get_template_directory_uri() . '/assets/image/about-us-impact.svg'; ?>" />
                    <div class="feature-heading">Sustainably sourced for a better planet</div>
                    <div class="feature-desc">
                        Our ingredients are ethically sourced, promoting
                        <u>sustainability</u>.
                    </div>
                </div>
                <div class="column">
                    <img class="feature-image" src="<?php echo get_template_directory_uri() . '/assets/image/about-us-journey.svg'; ?>" />
                    <div class="feature-heading">Delicious flavors to fuel your day</div>
                    <div class="feature-desc">
                        Revolutionizing plant-based living with products that offer
                        <u>no compromise</u>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>