<?php

/**
 * Template part for displaying the signup block
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<style>
    .accordion {
        border-style: solid;
        border-color: var(--border-primary, #000000);
        border-width: 0px 0px 1px 0px;
        display: flex;
        flex-direction: column;
        gap: 0px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        margin-top: 32px;
    }

    .accordion-item {
        border-style: solid;
        border-color: var(--border-primary, #000000);
        border-width: 1px 0px 0px 0px;
        display: flex;
        flex-direction: column;
        gap: 0px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .content-top {
        padding: 16px 0px 16px 0px;
        display: flex;
        flex-direction: row;
        gap: 12px;
        align-items: center;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .heading {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--text-medium-semi-bold-font-family,
                "Roboto-SemiBold",
                sans-serif);
        font-size: var(--text-medium-semi-bold-font-size, 18px);
        line-height: var(--text-medium-semi-bold-line-height, 150%);
        font-weight: var(--text-medium-semi-bold-font-weight, 600);
        position: relative;
        flex: 1;
    }

    .icon {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
        transition: transform 0.3s ease;
    }

    .content-bottom {
        padding: 0px 0px 24px 0px;
        display: none;
        flex-direction: row;
        gap: 8px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .accordion-item.active .content-bottom {
        display: flex;
    }

    .accordion-item.active .icon {
        transform: rotate(180deg);
    }

    .text {
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

    .content-top2 {
        padding: 16px 0px 16px 0px;
        display: flex;
        flex-direction: row;
        gap: 12px;
        align-items: center;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .heading2 {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--text-medium-semi-bold-font-family,
                "Roboto-SemiBold",
                sans-serif);
        font-size: var(--text-medium-semi-bold-font-size, 18px);
        line-height: var(--text-medium-semi-bold-line-height, 150%);
        font-weight: var(--text-medium-semi-bold-font-weight, 600);
        position: relative;
        width: 580px;
    }

    .icon2 {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }
</style>


<div class="accordion">
    <div class="accordion-item">
        <div class="content-top" onclick="toggleAccordion(this)">
            <div class="heading">Shipping</div>
            <img class="icon" src="<?php echo get_template_directory_uri() . '/assets/image/icon-arrow-down.svg'; ?>" />
        </div>
        <div class="content-bottom">
            <div class="text">
                <?php echo wp_kses_post(get_theme_mod('pdp_shipping_content', 'We offer fast and reliable shipping options to ensure you receive your protein quickly. All orders over $50 qualify for free shipping. Expect your package to arrive within 3-5 business days.')); ?>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <div class="content-top" onclick="toggleAccordion(this)">
            <div class="heading">Returns</div>
            <img class="icon" src="<?php echo get_template_directory_uri() . '/assets/image/icon-arrow-down.svg'; ?>" />
        </div>
        <div class="content-bottom">
            <div class="text">
                <?php echo wp_kses_post(get_theme_mod('pdp_returns_content', 'Your satisfaction is our priority. If you\'re not completely happy with your purchase, you can return it within 30 days for a full refund. Please ensure the product is unopened and in its original packaging.')); ?>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAccordion(element) {
        const accordionItem = element.parentElement;
        const isActive = accordionItem.classList.contains('active');

        // Close all accordion items
        document.querySelectorAll('.accordion-item').forEach(item => {
            item.classList.remove('active');
        });

        // If the clicked item wasn't active, open it
        if (!isActive) {
            accordionItem.classList.add('active');
        }
    }
</script>