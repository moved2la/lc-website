<?php

/**
 * Template part for shipping faq
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<style>
    .shipping-faq {
        background: var(--background-color-primary, #ffffff);
        padding-top: 60px;
        padding-bottom: 60px;
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }

    .shipping-faq .section-title {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        width: 768px;
        position: relative;
    }

    .shipping-faq .fa-qs {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h2-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h2-font-size, 48px);
        line-height: var(--heading-desktop-h2-line-height, 120%);
        font-weight: var(--heading-desktop-h2-font-weight, 700);
        position: relative;
        width: 768px;
    }

    .shipping-faq .text {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--text-medium-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-medium-normal-font-size, 18px);
        line-height: var(--text-medium-normal-line-height, 150%);
        font-weight: var(--text-medium-normal-font-weight, 400);
        position: relative;
        width: 768px;
    }

    .shipping-faq .accordion-list {
        border-style: solid;
        border-color: var(--border-primary, #000000);
        border-width: 0px 0px 1px 0px;
        display: flex;
        flex-direction: column;
        gap: 0px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .shipping-faq .accordion-item {
        display: flex;
        flex-direction: column;
        gap: 0px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .shipping-faq .question {
        border-style: solid;
        border-color: var(--border-primary, #000000);
        border-width: 1px 0px 0px 0px;
        padding: 20px 0px 20px 0px;
        display: flex;
        flex-direction: row;
        gap: 24px;
        align-items: center;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .shipping-faq .question2 {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--text-medium-bold-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--text-medium-bold-font-size, 18px);
        line-height: var(--text-medium-bold-line-height, 150%);
        font-weight: var(--text-medium-bold-font-weight, 700);
        position: relative;
        flex: 1;
    }

    .shipping-faq .accordion-icon {
        flex-shrink: 0;
        width: 32px;
        height: 32px;
        position: relative;
        overflow: visible;
        transition: transform 0.3s ease;
    }

    .shipping-faq .answer {
        padding: 0px 0px 24px 0px;
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .shipping-faq .text2 {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--text-regular-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-regular-normal-font-size, 16px);
        line-height: var(--text-regular-normal-line-height, 150%);
        font-weight: var(--text-regular-normal-font-weight, 400);
        position: relative;
        margin-bottom: 24px;
    }

    .shipping-faq .content {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        width: 560px;
        position: relative;
    }

    .shipping-faq .content2 {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: center;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .shipping-faq .still-have-questions {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h4-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h4-font-size, 32px);
        line-height: var(--heading-desktop-h4-line-height, 130%);
        font-weight: var(--heading-desktop-h4-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .shipping-faq .text3 {
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

    .shipping-faq .actions {
        display: flex;
        flex-direction: row;
        gap: 24px;
        align-items: center;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .shipping-faq .button-primary {
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .shipping-faq .button-primary {
        background: #0e4c73;

        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
    }

    .shipping-faq .button {
        color: var(--text-alternate, #ffffff);
        text-align: left;
        font-family: "Roboto-SemiBold", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 600;
        position: relative;
    }

    .shipping-faq .accordion-header {
        width: 100%;
        border: none;
        background: none;
        cursor: pointer;
        padding: 20px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid var(--border-primary, #000000);
    }

    .shipping-faq .accordion-header:hover,
    .shipping-faq .accordion-header.active,
    .shipping-faq .accordion-header:focus {
        background-color: #fff;
    }

    .shipping-faq .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }

    /* Remove these styles if they exist */
    .shipping-faq .question {
        border: none;
    }

    .shipping-faq .answer {
        padding: 0;
    }
</style>


<div class="shipping-faq">
    <div class="section-title">
        <div class="fa-qs">FAQs</div>
        <div class="text">
            Find answers to your shipping questions to ensure a smooth delivery
            experience.
        </div>
    </div>
    <div class="accordion-list">
        <div class="accordion-item">
            <button class="accordion-header">
                <div class="question2">What are shipping options?</div>
                <img class="accordion-icon" src="<?php echo get_template_directory_uri() . '/assets/image/icon-arrow-down.svg'; ?>" />
            </button>
            <div class="accordion-content">
                <div class="text2">
                    We offer various shipping options to meet your needs, including
                    standard and expedited services. You can choose the one that best fits
                    your timeline and budget. All shipping methods are tracked for your
                    convenience.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <button class="accordion-header">
                <div class="question2">How long is shipping?</div>
                <img class="accordion-icon" src="<?php echo get_template_directory_uri() . '/assets/image/icon-arrow-down.svg'; ?>" />
            </button>
            <div class="accordion-content">
                <div class="text2">
                    Shipping times vary based on your location and selected shipping
                    method. Typically, standard shipping takes 3-5 business days, while
                    expedited options can arrive in 1-2 business days. You will receive a
                    tracking number once your order has shipped.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <button class="accordion-header">
                <div class="question2">Do you ship internationally?</div>
                <img class="accordion-icon" src="<?php echo get_template_directory_uri() . '/assets/image/icon-arrow-down.svg'; ?>" />
            </button>
            <div class="accordion-content">
                <div class="text2">
                    Yes, we do offer international shipping to select countries. Please
                    check our shipping policy for a list of eligible locations. Additional
                    customs fees may apply depending on your country&#039;s regulations.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <button class="accordion-header">
                <div class="question2">What if my order is delayed?</div>
                <img class="accordion-icon" src="<?php echo get_template_directory_uri() . '/assets/image/icon-arrow-down.svg'; ?>" />
            </button>
            <div class="accordion-content">
                <div class="text2">
                    If your order is delayed, please check the tracking information
                    provided. If you have further concerns, feel free to reach out to our
                    customer support team. We are here to assist you with any issues.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <button class="accordion-header">
                <div class="question2">Can I change my address?</div>
                <img class="accordion-icon" src="<?php echo get_template_directory_uri() . '/assets/image/icon-arrow-down.svg'; ?>" />
            </button>
            <div class="accordion-content">
                <div class="text2">
                    You can change your shipping address before your order is processed.
                    If you need to make a change, please contact us as soon as possible.
                    Once an order has shipped, we cannot alter the address.
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="content2">
            <div class="still-have-questions">Still have questions?</div>
            <div class="text3">We&#039;re here to help!</div>
        </div>
        <div class="actions">
            <div class="button-primary">
                <a href="<?php echo get_permalink(get_page_by_path('contact-us')); ?>"><button class="button">Contact us</button></a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accordionHeaders = document.querySelectorAll('.accordion-header');

        accordionHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const content = this.nextElementSibling;
                const icon = this.querySelector('.accordion-icon');
                const isExpanded = this.classList.contains('active');

                // Close all accordions
                accordionHeaders.forEach(otherHeader => {
                    otherHeader.classList.remove('active');
                    otherHeader.nextElementSibling.style.maxHeight = null;
                    otherHeader.querySelector('.accordion-icon').style.transform = 'rotate(0deg)';
                });

                // Toggle clicked accordion
                if (!isExpanded) {
                    this.classList.add('active');
                    content.style.maxHeight = content.scrollHeight + 'px';
                    icon.style.transform = 'rotate(180deg)';
                }
            });
        });
    });
</script>