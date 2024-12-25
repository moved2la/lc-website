<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package live-complete
 */

?>

</div><!-- #content -->



<?php
/**
 * Hook - live_complete_site_footer
 *
 * @hooked live_complete_container_wrap_start
 */
do_action('live_complete_site_footer');
?>
</div><!-- #page -->


<style>
    .footer-wrapper {
        background: linear-gradient(to left, #1a1a1a, #1a1a1a),
            linear-gradient(to left, #000000, #000000);
        padding-top: 64px;
        padding-bottom: 64px;
        display: flex;
        flex-direction: column;
        gap: 40px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }

    .footer-wrapper .content {
        display: flex;
        flex-direction: row;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        flex-wrap: wrap;
    }

    .footer-wrapper .links {
        display: flex;
        flex-direction: row;
        gap: 40px;
        align-items: flex-start;
        justify-content: space-between;
        flex: 1;
        position: relative;
        flex-wrap: wrap;
        min-width: 280px;
    }

    .footer-wrapper .column {
        display: flex;
        flex-direction: column;
        gap: 0px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 0 1 auto;
        position: relative;
        overflow: hidden;
        min-width: 200px;
        max-width: 300px;
        width: auto;
    }

    .footer-wrapper .color-dark {
        flex-shrink: 0;
        width: 84px;
        height: 36px;
        position: relative;
        overflow: hidden;
    }

    .footer-wrapper .logo-wide-1 {
        width: 70px;
        height: 36px;
        position: absolute;
        left: 50%;
        translate: -50% -50%;
        top: 50%;
        overflow: visible;
    }

    .footer-wrapper .column2 {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1 1 200px;
        position: relative;
        overflow: hidden;
        min-width: 200px;
        max-width: 300px;
    }

    .footer-wrapper .column-one {
        color: var(--border-alternate, #ffffff);
        text-align: left;
        font-family: var(--text-regular-semi-bold-font-family,
                "Roboto-SemiBold",
                sans-serif);
        font-size: var(--text-regular-semi-bold-font-size, 16px);
        line-height: var(--text-regular-semi-bold-line-height, 150%);
        font-weight: var(--text-regular-semi-bold-font-weight, 600);
        position: relative;
        align-self: stretch;
    }

    .footer-wrapper .footer-links {
        display: flex;
        flex-direction: column;
        gap: 0px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .footer-wrapper .link {
        padding: 8px 0px 8px 0px;
        display: flex;
        flex-direction: row;
        gap: 0px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .footer-wrapper .link a:hover {
        color: var(--background-color-primary, #ffffff);
    }

    .footer-wrapper .link-one {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-small-normal-font-size, 14px);
        line-height: var(--text-small-normal-line-height, 150%);
        font-weight: var(--text-small-normal-font-weight, 400);
        position: relative;
        flex: 1;
    }

    .footer-wrapper .link-two {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-small-normal-font-size, 14px);
        line-height: var(--text-small-normal-line-height, 150%);
        font-weight: var(--text-small-normal-font-weight, 400);
        position: relative;
        flex: 1;
    }

    .footer-wrapper .link-three {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-small-normal-font-size, 14px);
        line-height: var(--text-small-normal-line-height, 150%);
        font-weight: var(--text-small-normal-font-weight, 400);
        position: relative;
        flex: 1;
    }

    .footer-wrapper .column-two {
        color: var(--border-alternate, #ffffff);
        text-align: left;
        font-family: var(--text-regular-semi-bold-font-family,
                "Roboto-SemiBold",
                sans-serif);
        font-size: var(--text-regular-semi-bold-font-size, 16px);
        line-height: var(--text-regular-semi-bold-line-height, 150%);
        font-weight: var(--text-regular-semi-bold-font-weight, 600);
        position: relative;
        align-self: stretch;
    }

    .footer-wrapper .link-six {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-small-normal-font-size, 14px);
        line-height: var(--text-small-normal-line-height, 150%);
        font-weight: var(--text-small-normal-font-weight, 400);
        position: relative;
        flex: 1;
    }

    .footer-wrapper .link-seven {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-small-normal-font-size, 14px);
        line-height: var(--text-small-normal-line-height, 150%);
        font-weight: var(--text-small-normal-font-weight, 400);
        position: relative;
        flex: 1;
    }

    .footer-wrapper .link-eight {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-small-normal-font-size, 14px);
        line-height: var(--text-small-normal-line-height, 150%);
        font-weight: var(--text-small-normal-font-weight, 400);
        position: relative;
        flex: 1;
    }

    .footer-wrapper .link-nine {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-small-normal-font-size, 14px);
        line-height: var(--text-small-normal-line-height, 150%);
        font-weight: var(--text-small-normal-font-weight, 400);
        position: relative;
        flex: 1;
    }

    .footer-wrapper .link-ten {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-small-normal-font-size, 14px);
        line-height: var(--text-small-normal-line-height, 150%);
        font-weight: var(--text-small-normal-font-weight, 400);
        position: relative;
        flex: 1;
    }

    .footer-wrapper .column-three {
        color: var(--border-alternate, #ffffff);
        text-align: left;
        font-family: var(--text-regular-semi-bold-font-family,
                "Roboto-SemiBold",
                sans-serif);
        font-size: var(--text-regular-semi-bold-font-size, 16px);
        line-height: var(--text-regular-semi-bold-line-height, 150%);
        font-weight: var(--text-regular-semi-bold-font-weight, 600);
        position: relative;
        align-self: stretch;
    }

    .footer-wrapper .link-eleven {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-small-normal-font-size, 14px);
        line-height: var(--text-small-normal-line-height, 150%);
        font-weight: var(--text-small-normal-font-weight, 400);
        position: relative;
        flex: 1;
    }

    .footer-wrapper .link-twelve {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-small-normal-font-size, 14px);
        line-height: var(--text-small-normal-line-height, 150%);
        font-weight: var(--text-small-normal-font-weight, 400);
        position: relative;
        flex: 1;
    }

    .footer-wrapper .link-thirteen {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-small-normal-font-size, 14px);
        line-height: var(--text-small-normal-line-height, 150%);
        font-weight: var(--text-small-normal-font-weight, 400);
        position: relative;
        flex: 1;
    }

    .footer-wrapper .link-fourteen {
        color: var(--background-color-primary, #ffffff);
        text-align: left;
        font-family: var(--text-small-normal-font-family,
                "Roboto-Regular",
                sans-serif);
        font-size: var(--text-small-normal-font-size, 14px);
        line-height: var(--text-small-normal-line-height, 150%);
        font-weight: var(--text-small-normal-font-weight, 400);
        position: relative;
        flex: 1;
    }

    .footer-wrapper .divider {
        background: var(--border-secondary, #aaaaaa);
        border-style: solid;
        border-color: var(--border-secondary, #aaaaaa);
        border-width: 1px;
        align-self: stretch;
        flex-shrink: 0;
        height: 1px;
        position: relative;
    }

    .footer-wrapper .row {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        justify-content: space-between;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        margin: 0;
    }
</style>

<div class="footer-wrapper">
    <div class="content container">
        <div class="column">
            <div class="color-dark">
                <img class="logo-wide-1" src="<?php echo get_template_directory_uri() . '/assets/image/logo-white.svg'; ?>" />
            </div>
        </div>
        <div class="links">

            <div class="column2">
                <div class="column-one">Shop</div>
                <div class="footer-links">
                    <?php
                    $args = array(
                        'taxonomy'     => 'product_cat',
                        'orderby'      => 'name',
                        'hide_empty'   => true,
                        'parent'       => 0
                    );

                    $categories = get_terms($args);

                    if (!empty($categories) && !is_wp_error($categories)) {
                        foreach ($categories as $category) {
                            $category_link = get_term_link($category);
                            echo '<div class="link">';
                            echo '<a href="' . esc_url($category_link) . '" class="link-one">' . esc_html($category->name) . '</a>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="column2">
                <div class="column-one">Company</div>
                <div class="footer-links">
                    <div class="link">
                        <div class="link-one">Our Story</div>
                    </div>
                    <div class="link">
                        <div class="link-two">The Difference</div>
                    </div>
                    <div class="link">
                        <div class="link-three">Our Impact</div>
                    </div>
                </div>
            </div>
            <div class="column2">
                <div class="column-two">Community</div>
                <div class="footer-links">
                    <div class="link">
                        <div class="link-six">Ambassadors</div>
                    </div>
                    <div class="link">
                        <div class="link-seven">Affiliates</div>
                    </div>
                    <div class="link">
                        <div class="link-eight">Influencers</div>
                    </div>
                    <div class="link">
                        <div class="link-nine">Partnerships</div>
                    </div>
                    <div class="link">
                        <div class="link-ten">Wholesale</div>
                    </div>
                </div>
            </div>
            <div class="column2">
                <div class="column-three">Support</div>
                <div class="footer-links">
                    <div class="link">
                        <div class="link-eleven">Contact Us</div>
                    </div>
                    <div class="link">
                        <div class="link-twelve">Shipping Information</div>
                    </div>
                    <div class="link">
                        <div class="link-thirteen">Returns &amp; Exchanges</div>
                    </div>
                    <div class="link">
                        <div class="link-fourteen">FAQ</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php get_template_part('template-parts/footer/copyright'); ?>
</div>

<?php wp_footer(); ?>

</body>

</html>