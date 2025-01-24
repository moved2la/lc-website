<?php

/**
 * Template part for footer copyright section
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<style>
    .footer-bottom {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .footer-bottom .credits-text {
        display: flex;
        flex-direction: row;
        gap: 24px;
        align-items: center;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
        flex-wrap: wrap;
        color: #fff;
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 14px;
        line-height: 150%;
        font-weight: 400;
    }

    .footer-bottom .policy-link {

        color: #fff;
    }

    .footer-bottom .policy-link:hover,
    .footer-bottom .policy-link:focus,
    .footer-bottom .policy-link:active {
        color: #fff;
    }

    .footer-bottom .social-links {
        display: flex;
        flex-direction: row;
        gap: 12px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .footer-bottom .icon-facebook {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }

    .footer-bottom .icon-instagram {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }

    .footer-bottom .icon-x {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }

    .footer-bottom .icon-linked-in {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }

    .footer-bottom .icon-youtube {
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

        .footer-wrapper .row .credits-text {
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

<div class="footer-bottom container"><span class="back-to-top" id="backToTop"><i class="icofont-rounded-up parallax"></i></span>
    <div class="divider"></div>
    <div class="row">
        <div class="credits-text">
            <span>
                © <?php echo date('Y'); ?> Live Complete. All rights reserved.
            </span>
            <a href="<?php echo get_privacy_policy_url(); ?>">
                <div class="policy-link">Privacy Policy</div>
            </a>
            <div class="policy-link">Terms and Conditions</div>
            <div class="policy-link">Cookie Policy</div>
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