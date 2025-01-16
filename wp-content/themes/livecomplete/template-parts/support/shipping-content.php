<?php

/**
 * Template part for shipping content
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<style>


    .shipping-page-content-wrapper {
        background-color: #f1f1f1;
    }

    .shipping-page-content-wrapper-inner {
        background-color: #f1f1f1;
        padding-top: 60px;
        padding-bottom: 60px;
        display: flex;
        gap: 60px;
    }

    .shipping-quote {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-mobile-h4-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-mobile-h4-font-size, 24px);
        line-height: var(--heading-mobile-h4-line-height, 140%);
        font-weight: var(--heading-mobile-h4-font-weight, 700);
        position: relative;
        max-width: 369px;
        box-sizing: border-box;
    }

    .quote-mark {
        color: var(--primary-color, #FF6B35);
        font-family: "Roboto-Bold", sans-serif;
        font-size: 48px;
        line-height: 120%;
        font-weight: 700;
    }

    /* .shipping-quote::before {
        left: 0;
        top: 0;
    }

    .shipping-quote::after {
        content: "\201D";
        right: 0;
        bottom: 0;
    } */

    .shipping-info {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        flex-direction: column;
    }

    .shipping-section {
        /* flex: 1 1 300px; */
    }

    .shipping-section h3 {
        color: var(--text-primary, #000000);
        font-family: var(--heading-mobile-h4-font-family, "Roboto-Bold", sans-serif);
        font-size: 20px;
        font-weight: 700;
        /* margin-bottom: 15px; */
    }

    .shipping-section p {
        color: var(--text-secondary, #333333);
        font-family: var(--body-font-family, "Roboto", sans-serif);
        font-size: 16px;
        line-height: 1.5;
    }

    .shipping-contact {
        width: 100%;
        text-align: center;
        margin-top: 30px;
        color: var(--text-secondary, #333333);
        font-family: var(--body-font-family, "Roboto", sans-serif);
        font-size: 16px;
    }
</style>

<div class="shipping-page-content-wrapper full-width-section">
    <div class="shipping-page-content-wrapper-inner container">
        <div class="shipping-quote">
            <span class="quote-mark">"</span>Your satisfaction is our priority. We strive to deliver your products
            safely and promptly.<span class="quote-mark">"</span>
        </div>

        <div class="shipping-info">
            <div class="shipping-section">
                <h3>Shipping Methods</h3>
                <p>We offer a variety of shipping methods to suit your needs, including standard, expedited, and overnight options. Each method is designed to provide you with flexibility and convenience.</p>
            </div>

            <div class="shipping-section">
                <h3>Shipping Costs</h3>
                <p>Shipping costs vary based on the selected method and your location. You can view the estimated shipping fees during the checkout process.</p>
            </div>

            <div class="shipping-section">
                <h3>Delivery Times</h3>
                <p>Delivery times depend on the shipping method chosen and your location. Standard shipping typically takes 3–5 business days, while expedited options can arrive in as little as 1–2 days.</p>
            </div>

            <div class="shipping-section">
                <h3>Tracking Information</h3>
                <p>Once your order has shipped, you will receive a tracking number via email. This allows you to monitor your package's journey until it arrives at your doorstep.</p>
            </div>

            <div class="shipping-section">
                <h3>International Shipping</h3>
                <p>We proudly offer international shipping to select countries. Please note that additional customs fees may apply depending on your location.</p>
            </div>

            <div class="shipping-section">
                <p>If you have any questions regarding shipping, feel free to contact our customer service team for assistance.</p>
            </div>
        </div>
    </div>
</div>