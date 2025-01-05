<?php

/**
 * Template part for copyright section
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<style>
    .credits {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .credits2 {
        display: flex;
        flex-direction: row;
        gap: 24px;
        align-items: center;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
        flex-wrap: wrap;
    }

    ._2024-relume-all-rights-reserved {
        color: var(--border-alternate, #ffffff);
        text-align: left;
        font-family: var(--text-small-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-small-normal-font-size, 14px);
        line-height: var(--text-small-normal-line-height, 150%);
        font-weight: var(--text-small-normal-font-weight, 400);
        position: relative;
    }

    .privacy-policy {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-link-font-family, "Roboto-Regular", sans-serif);
        font-size: var(--text-small-link-font-size, 14px);
        line-height: var(--text-small-link-line-height, 150%);
        font-weight: var(--text-small-link-font-weight, 400);
        text-decoration: underline;
        position: relative;
    }

    .terms-of-service {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-link-font-family, "Roboto-Regular", sans-serif);
        font-size: var(--text-small-link-font-size, 14px);
        line-height: var(--text-small-link-line-height, 150%);
        font-weight: var(--text-small-link-font-weight, 400);
        text-decoration: underline;
        position: relative;
    }

    .cookies-settings {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-link-font-family, "Roboto-Regular", sans-serif);
        font-size: var(--text-small-link-font-size, 14px);
        line-height: var(--text-small-link-line-height, 150%);
        font-weight: var(--text-small-link-font-weight, 400);
        text-decoration: underline;
        position: relative;
    }

    .social-links {
        display: flex;
        flex-direction: row;
        gap: 12px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .icon-facebook {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }

    .icon-instagram {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }

    .icon-x {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }

    .icon-linked-in {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }

    .icon-youtube {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }


    @media (max-width: 1024px) {
        .footer-wrapper .row {
            flex-direction: column-reverse;
        }

        .footer-wrapper .row .credits2 {
            flex-direction: column;
            flex-basis: 100%;
            justify-content: center;
            width: 100%;
        }

        .footer-wrapper .row .social-links {
            flex-basis: 100%;
            justify-content: center;
            width: 100%;
            margin-bottom: 24px;
        }
    }
</style>

<div class="credits container"><span class="back-to-top" id="backToTop"><i class="icofont-rounded-up parallax"></i></span>
    <div class="divider"></div>
    <div class="row">
        <div class="credits2">
            <div class="_2024-relume-all-rights-reserved">
                © 2024 Live Complete. All rights reserved.
            </div>
            <div class="privacy-policy">Privacy Notice</div>
            <div class="terms-of-service">Terms and Conditions</div>
            <div class="cookies-settings">Cookie Policy</div>
        </div>
        <div class="social-links">
            <?php if (get_theme_mod('__fb_link')): ?>
                <a href="<?php echo esc_url(get_theme_mod('__fb_link')); ?>" target="_blank" rel="noopener noreferrer">
                    <img class="icon-facebook" src="<?php echo get_template_directory_uri(); ?>/assets/image/icon-facebook.svg" />
                </a>
            <?php endif; ?>
            <?php if (get_theme_mod('__ig_link')): ?>
                <a href="<?php echo esc_url(get_theme_mod('__tw_link')); ?>" target="_blank" rel="noopener noreferrer">
                    <img class="icon-instagram" src="<?php echo get_template_directory_uri(); ?>/assets/image/icon-instagram.svg" />
                </a>
            <?php endif; ?>
            <?php if (get_theme_mod('__x_link')): ?>
                <a href="<?php echo esc_url(get_theme_mod('__x_link')); ?>" target="_blank" rel="noopener noreferrer">
                    <img class="icon-x" src="<?php echo get_template_directory_uri(); ?>/assets/image/icon-x.svg" />
                </a>
            <?php endif; ?>
            <?php if (get_theme_mod('__li_link')): ?>
                <a href="<?php echo esc_url(get_theme_mod('__li_link')); ?>" target="_blank" rel="noopener noreferrer">
                    <img class="icon-linked-in" src="<?php echo get_template_directory_uri(); ?>/assets/image/icon-linkedin.svg" />
                </a>
            <?php endif; ?>
            <?php if (get_theme_mod('__yt_link')): ?>
                <a href="<?php echo esc_url(get_theme_mod('__yt_link')); ?>" target="_blank" rel="noopener noreferrer">
                    <img class="icon-youtube" src="<?php echo get_template_directory_uri(); ?>/assets/image/icon-youtube.svg" />
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>