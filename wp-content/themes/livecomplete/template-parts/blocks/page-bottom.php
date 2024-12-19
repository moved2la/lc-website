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

// Handle form submission
function handle_newsletter_signup()
{
    if (isset($_POST['newsletter_signup']) && isset($_POST['email'])) {
        $email = sanitize_email($_POST['email']);

        if (!is_email($email)) {
            return array('error' => 'Please enter a valid email address.');
        }

        // Here you can add your newsletter signup logic
        // For example, adding to a mailing list or database

        return array('success' => 'Thank you for signing up!');
    }
    return false;
}

$form_result = handle_newsletter_signup();
?>

<style>
    .signup {
        background: linear-gradient(to left, #0e4c73, #0e4c73),
            linear-gradient(to left, #ffffff, #ffffff);
        padding: 60px 64px 60px 64px;
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
        padding-left: 20px;
    }

    .signup .column {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        width: 458px;
        position: relative;
    }

    .heading {
        color: var(--border-alternate, #ffffff);
        text-align: left;
        font-family: var(--heading-desktop-h2-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h2-font-size, 48px);
        line-height: var(--heading-desktop-h2-line-height, 120%);
        font-weight: var(--heading-desktop-h2-font-weight, 700);
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
        min-width: 0;
    }

    .text {
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

    .actions {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .form {
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

    .type-default-alternate-false {
        padding: 12px;
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: flex-start;
        flex: 1;
        position: relative;
    }

    .placeholder {
        color: var(--color-neutral-neutral, #666666);
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
        flex: 1;
    }

    .style-primary-small-false-alternate-false-icon-position-no-icon {
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

    .signup-button {
        color: #0e4c73;
        background: #ffffff;
        text-align: center;
        line-height: 150%;
        font-weight: 600;
        position: relative;
        width: 123px;
        height: 48px;
    }

    .by-clicking-sign-up-you-re-confirming-that-you-agree-with-our-terms-and-conditions {
        color: var(--border-alternate, #ffffff);
        text-align: left;
        font-family: var(--text-tiny-normal-font-family, "-", sans-serif);
        font-size: var(--text-tiny-normal-font-size, 12px);
        line-height: var(--text-tiny-normal-line-height, 150%);
        font-weight: var(--text-tiny-normal-font-weight, 400);
        position: relative;
        align-self: stretch;
    }

    .by-clicking-sign-up-you-re-confirming-that-you-agree-with-our-terms-and-conditions-span {
        color: var(--border-alternate, #ffffff);
        font-family: var(--text-tiny-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-tiny-normal-font-size, 12px);
        line-height: var(--text-tiny-normal-line-height, 150%);
        font-weight: var(--text-tiny-normal-font-weight, 400);
    }

    .by-clicking-sign-up-you-re-confirming-that-you-agree-with-our-terms-and-conditions-span2 {
        color: var(--border-alternate, #ffffff);
        font-family: var(--text-tiny-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-tiny-normal-font-size, 12px);
        line-height: var(--text-tiny-normal-line-height, 150%);
        font-weight: var(--text-tiny-normal-font-weight, 400);
        text-decoration: underline;
    }

    .by-clicking-sign-up-you-re-confirming-that-you-agree-with-our-terms-and-conditions-span3 {
        color: var(--border-alternate, #ffffff);
        font-family: var(--text-tiny-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-tiny-normal-font-size, 12px);
        line-height: var(--text-tiny-normal-line-height, 150%);
        font-weight: var(--text-tiny-normal-font-weight, 400);
    }

    /* Add styles for form input */
    .email-input {
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

    .form-message {
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 4px;
    }

    .form-message.success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .form-message.error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .signup-container button {
        min-width: 103px;
    }
</style>

<div class="signup">
    <div class="signup-container ">
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
                <?php if ($form_result): ?>
                    <div class="form-message <?php echo isset($form_result['error']) ? 'error' : 'success'; ?>">
                        <?php echo isset($form_result['error']) ? $form_result['error'] : $form_result['success']; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="form" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
                    <input
                        type="email"
                        name="email"
                        class="email-input"
                        placeholder="Enter your email"
                        required>
                    <button type="submit" name="newsletter_signup" class="signup-button">Sign Up</button>
                </form>

                <div class="by-clicking-sign-up-you-re-confirming-that-you-agree-with-our-terms-and-conditions">
                    <span>
                        <span class="by-clicking-sign-up-you-re-confirming-that-you-agree-with-our-terms-and-conditions-span">
                            By clicking Sign Up you're confirming that you agree with our
                        </span>
                        <a href="/terms-and-conditions" class="by-clicking-sign-up-you-re-confirming-that-you-agree-with-our-terms-and-conditions-span2">
                            Terms and Conditions
                        </a>
                        <span class="by-clicking-sign-up-you-re-confirming-that-you-agree-with-our-terms-and-conditions-span3">
                            .
                        </span>
                    </span>
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