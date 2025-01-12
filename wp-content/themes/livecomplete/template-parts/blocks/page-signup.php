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
    .signup {
        background: linear-gradient(to left, #0e4c73, #0e4c73),
            linear-gradient(to left, #ffffff, #ffffff);
        padding: 60px 0 60px 0;
        display: flex;
        flex-direction: column;
        gap: 80px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }

    .signup-container {
        display: flex;
        flex-direction: row;
        gap: 80px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        /* padding-left: 20px; */
        flex-wrap: wrap;
    }

    .signup .column {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        max-width: 458px;
        position: relative;
    }

    .signup .heading {
        color: #ffffff;
        text-align: left;
        font-family: "Roboto-Bold", sans-serif;
        font-size: clamp(36px, 4vw, 48px);
        line-height: 120%;
        font-weight: 700;
        position: relative;
        align-self: stretch;
    }

    .signup .column2 {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
        width: 100%;
    }

    @media (max-width: 1024px) {
        .signup .column2 {
            flex: none;

        }
    }

    .signup .text {
        color: var(--border-alternate, #ffffff);
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

    .signup .actions {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .signup .form {
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        background: transparent;
    }

    .signup .type-default-alternate-false {
        padding: 12px;
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: flex-start;
        flex: 1;
        position: relative;
    }

    .signup .placeholder {
        color: var(--color-neutral-neutral, #666666);
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
        flex: 1;
    }

    .signup .style-primary-small-false-alternate-false-icon-position-no-icon {
        background: var(--link-alternate, #ffffff);
        border-style: solid;
        border-color: var(--link-alternate, #ffffff);
        border-width: 1px;
        padding: 12px 24px 12px 24px;
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 103px;
        position: relative;
    }

    .signup .signup-button {
        color: var(--secondary-btn-color);
        background: var(--secondary-btn-bg-color);
        text-align: center;
        line-height: 150%;
        font-weight: 600;
        position: relative;
        width: 123px;
        height: 48px;
    }

    .signup .signup-button:hover {
        color: var(--secondary-btn-color-h);
    }

    .signup .terms-and-conditions {
        text-align: left;
        color: #ffffff;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 12px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
        align-self: stretch;
    }

    .signup .terms-and-conditions a {
        color: #ffffff;
        text-decoration: underline;
    }

    .signup .terms-and-conditions a:hover {
        text-decoration: none;
    }

    .signup .email-input {
        background: #ffffff;
        max-width: 394px;
        max-height: 48px;
        border: 1px solid #ffffff;
        padding: 12px;
        width: 100%;
        color: #666666;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 16px;
        line-height: 150%;
    }

    .signup .form-message {
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 4px;
    }

    .signup .form-message.success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .signup .form-message.error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .signup-container button {
        min-width: 123px;
    }
</style>

<div class="signup">
    <div class="signup-container container">
        <div class="column">
            <div class="heading">
                Fuel your journey:
                <br />
                Stay connected
                <br />
                with us!
            </div>
        </div>
        <div class="column2">
            <div class="text">
                Don't miss out on fresh ideas and exclusive rewards — delivered straight
                to your inbox! Join our email list and unlock early access to new
                products, special offers, and plant-powered inspiration.
            </div>
            <div class="actions">
                <div id="signupMessage"></div>
                <form id="newsletterSignupForm" class="form">
                    <?php wp_nonce_field('submit_newsletter_signup', 'newsletter_signup_nonce'); ?>
                    <input
                        type="email"
                        name="email"
                        class="email-input"
                        placeholder="Enter your email"
                        required
                    />
                    <button type="submit" class="signup-button">Sign Up</button>
                </form>

                <div class="terms-and-conditions">
                    <span>By clicking Sign Up you're confirming that you agree with our
                    <a href="<?php echo esc_url(home_url('/terms-and-conditions')); ?>">Terms and Conditions</a>.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.signup form');
        const emailInput = form.querySelector('input[type="email"]');

        form.addEventListener('submit', function(e) {
            if (!emailInput.value.trim()) {
                e.preventDefault();
                emailInput.focus();
            }
        });
    });
</script>