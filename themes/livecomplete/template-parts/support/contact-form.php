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
        max-width: 768px;
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
        color:  #000000;
        text-align: center;
        font-family: "Roboto-Bold", sans-serif;
        font-size: 48px;
        line-height: 120%;
        font-weight: 700;
        position: relative;
        align-self: stretch;
    }

    .form-wrapper .inputs {
        display: flex;
        flex-direction: column;
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
        color: #000000;
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
        align-self: stretch;
    }

    .form-wrapper .text-field {
        background: #ffffff;
        border-style: solid;
        border-color: #000000;
        border-width: 1px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .form-wrapper .text-label {
        color: #000000;
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
        align-self: stretch;
    }

    .form-wrapper textarea {
        background: #ffffff;
        border-style: solid;
        border-color:  #000000;
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

    .form-wrapper .terms-checkbox {
        padding: 0px 0px 24px 0px;
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: flex-start;
        position: relative;
    }

    .form-wrapper .checkbox {
        background: #ffffff;
        border-style: solid;
        border-color: #000000;
        border-width: 1px;
        flex-shrink: 0;
        width: 18px;
        height: 18px;
        position: relative;
        overflow: hidden;
        margin: 0;
    }

    .form-wrapper .checkbox-label {
        color: #000000;
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

    .button {
        color: #ffffff;
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
        font-family: "Roboto-Regular", sans-serif;
        font-size: 16px;
        line-height: 150%;
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
            <form id="supportContactForm" class="support-contact-form" method="post">
                <?php wp_nonce_field('submit_contact_form', 'contact_form_nonce'); ?>
                <div class="inputs">
                    <div class="input">
                        <label for="first_name" class="text-label">First name</label>
                        <input type="text" id="first_name" name="first_name" class="text-field" required>
                    </div>
                    <div class="input">
                        <label for="last_name" class="text-label">Last name</label>
                        <input type="text" id="last_name" name="last_name" class="text-field" required>
                    </div>
                    <div class="input">
                        <label for="email" class="text-label">Email</label>
                        <input type="email" id="email" name="email" class="text-field" required>
                    </div>
                    <div class="input">
                        <label for="phone" class="text-label">Phone number</label>
                        <input type="tel" id="phone" name="phone" class="text-field">
                    </div>
                    <label for="message" class="text-label">Message</label>
                    <textarea id="message" name="message" placeholder="Your message here..." required></textarea>
                </div>

                <div class="terms-checkbox">
                    <input type="checkbox" id="terms" name="terms" class="checkbox" required>
                    <label for="terms" class="checkbox-label">I agree to the Terms & Conditions</label>
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