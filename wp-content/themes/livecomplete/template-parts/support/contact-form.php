<?php

/**
 * Template part for contact form
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<style>
    .form-wrapper {
        position: relative;
        display: flex;
        flex-direction: column;
        margin: 0 auto;
        /* margin-top: 51px;
        margin-bottom: 64px; */
        max-width: 768px;
        /* gap: 20px; */
    }

    .support-contact-form {
        max-width: 768px;
    }

    .form-wrapper .section-title {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: center;
        justify-content: flex-start;
        left: 0px;
        top: 0px;
    }

    .form-wrapper .content {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: center;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .form-wrapper .heading {
        color: var(--text-primary, #000000);
        text-align: center;
        font-family: var(--heading-desktop-h2-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h2-font-size, 48px);
        line-height: var(--heading-desktop-h2-line-height, 120%);
        font-weight: var(--heading-desktop-h2-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .form-wrapper .inputs {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
    }

    .form-wrapper .input {
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .form-wrapper .first-name {
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

    .form-wrapper .text-field {
        background: #ffffff;
        border-style: solid;
        border-color: var(--color-neutral-black, #000000);
        border-width: 1px;
        padding: 12px;
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .form-wrapper .last-name {
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

    .form-wrapper .inputs2 {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
    }

    .form-wrapper .email {
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

    .form-wrapper .phone-number {
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

    .form-wrapper .input2 {
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
    }

    .form-wrapper .message {
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

    .form-wrapper .alternate-false {
        background: #ffffff;
        border-style: solid;
        border-color: var(--color-neutral-black, #000000);
        border-width: 1px;
        padding: 12px;
        display: flex;
        flex-direction: row;
        gap: 0px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        height: 180px;
        position: relative;
    }

    .form-wrapper .type-your-message {
        color: var(--color-neutral-neutral, #666666);
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
        flex: 1;
    }

    .form-wrapper .selected-false-alternate-false {
        padding: 0px 0px 16px 0px;
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: flex-start;
        height: 37px;
        position: relative;
    }

    .form-wrapper .checkbox {
        background: var(--color-neutral-white, #ffffff);
        border-style: solid;
        border-color: var(--border-primary, #000000);
        border-width: 1px;
        flex-shrink: 0;
        width: 18px;
        height: 18px;
        position: relative;
        overflow: hidden;
        margin: 0;
    }

    .form-wrapper .label {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 14px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin: 0;
    }

    .form-wrapper .button-primary {
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
    }

    .form-wrapper .style-primary-small-false-alternate-false-icon-position-no-icon {
        background: #0e4c73;
        padding: 12px 24px 12px 24px;
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
    }

    .button {
        color: var(--text-alternate, #ffffff);
        text-align: left;
        font-family: "Roboto-SemiBold", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 600;
        position: relative;
    }

    .support-section {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        background: #f1f1f1;
        padding-top: 52px;
        padding-bottom: 56px;
    }

    .support-section .container {
        margin: 0 auto;
        padding: 0 15px;
        width: 100%;
    }

    .success-message,
    .error-message {
        text-align: center;
        padding: 16px 24px;
        margin: 24px auto;
        max-width: 768px;
        font-family: var(--text-regular-normal-font-family, "Roboto-Regular", sans-serif);
        font-size: var(--text-regular-normal-font-size, 16px);
        line-height: var(--text-regular-normal-line-height, 150%);
        border-radius: 4px;
    }

    .success-message {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #a5d6a7;
    }

    .error-message {
        background-color: #ffebee;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }

    .form-wrapper .product-content {
        flex: 1;
        text-align: left;
        overflow: hidden;
    }
</style>

<div class="support-section">
    <div class="container">
        <div class="form-wrapper">
            <div class="section-title">
                <div class="content">
                    <div class="heading">Get in touch</div>
                </div>
            </div>
            <form class="support-contact-form" method="post" action="" id="supportContactForm">
                <?php wp_nonce_field('submit_contact_form', 'contact_form_nonce'); ?>
                <div class="inputs">
                    <div class="input">
                        <label for="first_name" class="first-name">First name</label>
                        <input type="text" id="first_name" name="first_name" class="text-field" required>
                    </div>
                    <div class="input">
                        <label for="last_name" class="last-name">Last name</label>
                        <input type="text" id="last_name" name="last_name" class="text-field" required>
                    </div>
                </div>
                <div class="inputs2">
                    <div class="input">
                        <label for="email" class="email">Email</label>
                        <input type="email" id="email" name="email" class="text-field" required>
                    </div>
                    <div class="input">
                        <label for="phone" class="phone-number">Phone number</label>
                        <input type="tel" id="phone" name="phone" class="text-field">
                    </div>
                </div>
                <div class="input2">
                    <label for="message" class="message">Message</label>
                    <textarea id="message" name="message" class="alternate-false" placeholder="Your message here..." required></textarea>
                </div>
                <div class="selected-false-alternate-false">
                    <input type="checkbox" id="terms" name="terms" class="checkbox" required>
                    <label for="terms" class="label">I agree to the Terms & Conditions</label>
                </div>
                <div class="button-primary">
                    <button type="submit">
                        <span class="button">Send</span>
                    </button>
                </div>
            </form>
        </div>
        <div id="formMessage"></div>
    </div>
</div>