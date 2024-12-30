<?php

/**
 * Template part for displaying category header content
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Access the category object passed from the template part
$category = $args['category'];
?>

<style>
    .category-custom-header {
        background-color: #F1F1F1;
    }


    .category-custom-header .content {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .category-custom-header .no-carousel {
        padding-bottom: 64px;
    }

    .category-custom-header .heading-text .short-heading-here {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h1-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h1-font-size, 56px);
        line-height: var(--heading-desktop-h1-line-height, 120%);
        font-weight: var(--heading-desktop-h1-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .category-custom-header .heading-text .lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-suspendisse-varius-enim-in-eros-elementum-tristique {
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


    .category-custom-header .nav-highlights {
        display: flex;
        flex-direction: column;
        gap: 80px;
        align-items: flex-start;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .category-custom-header .content {
        display: flex;
        flex-direction: column;
        /* gap: 64px; */
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .category-custom-header .content-row {
        display: flex;
        flex-direction: row;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .category-custom-header .column {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
        overflow: hidden;
    }

    .category-custom-header .livecomplete-protien-powder-everyone-608-x-320 {
        align-self: stretch;
        flex-shrink: 0;
        height: 160px;
        position: relative;
        object-fit: cover;
    }

    .category-custom-header .content2 {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .category-custom-header .section-title {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: center;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .category-custom-header .heading {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h5-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h5-font-size, 24px);
        line-height: var(--heading-desktop-h5-line-height, 140%);
        font-weight: var(--heading-desktop-h5-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .category-custom-header .text {
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

    .category-custom-header .action {
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .category-custom-header .style-link-small-false-alternate-false-icon-position-trailing {
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .category-custom-header .button {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
    }

    .category-custom-header .icon-chevron-right {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }

    .category-custom-header .amountainbikerdescendsanarrowtrailamidstsweepingmountainviewswiththesuncastingawarmglowoverthescene-generative-ai {
        align-self: stretch;
        flex-shrink: 0;
        height: 160px;
        position: relative;
        object-fit: cover;
    }

    .category-custom-header .icon-chevron-right2 {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }

    .category-custom-header .adobe-stock-900708708-preview {
        align-self: stretch;
        flex-shrink: 0;
        height: 160px;
        position: relative;
        object-fit: cover;
    }

    .category-custom-header .icon-chevron-right3 {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }

    .category-custom-header .screenshot-2024-12-10-at-7-27-55-pm {
        align-self: stretch;
        flex-shrink: 0;
        height: 160px;
        position: relative;
        object-fit: cover;
    }

    .category-custom-header .icon-chevron-right4 {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }

    .glide {
        position: relative;
    }

    .glide__arrows {
        position: relative;
        /* Adjust this value as needed */
        display: flex;
        gap: 8px;
        z-index: 2;
        margin-top: 0;
        width: 100%;
        justify-content: flex-end;
        margin-bottom: 20px;
    }

    .glide__arrow {
        /* Style your arrows as needed */
        background: var(--secondary-btn-bg-color);
        padding: 8px 16px;
        cursor: pointer;
        position: initial;
        border-radius: 0;
        text-shadow: none;
        box-shadow: none;
        border: 2px solid var(--secondary-btn-color);
        color: var(--secondary-btn-color);
        transform: none;
    }

    .glide__arrow:hover,
    .glide__arrow:focus,
    .glide__arrow:active {
        background: var(--secondary-btn-bg-color);
        color: var(--secondary-btn-color-h);
        border: 2px solid var(--secondary-btn-color-h);
    }

    .glide__bullets {
        display: flex;
        justify-content: center;
        margin-top: 60px;
        width: 100%;
        position: relative;
    }

    .glide__bullet {
        background-color: #fff;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: none;
        margin: 0 5px;
        padding: 0;
        cursor: pointer;
    }
    .glide__bullet:hover {
        border: none;
        background: var(--secondary-btn-color-h);
    }

    .glide__bullet--active {
        background-color: var(--secondary-btn-color) ;
    }
</style>

<?php
// Get subcategories of the current category
$subcategories = get_terms(array(
    'taxonomy' => 'product_cat',
    'parent' => $category->term_id,
    'hide_empty' => false
));
?>

<div class="category-custom-header">
    <div class="container">
        <div class="content <?php echo is_shop() || empty($subcategories) ? 'no-carousel' : ''; ?>">
            <div class="heading-text">
                <h1 class="short-heading-here">
                    <?php
                    $heading_text = get_term_meta($category->term_id, 'category_heading_text', true);
                    if (!$heading_text) {
                        // Fallback to category name if no custom heading is set
                        echo esc_html($category->name);
                    } else {
                        echo esc_html($heading_text);
                    }
                    ?>
                </h1>
                <?php if ($category->description) : ?>
                    <div
                        class="lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-suspendisse-varius-enim-in-eros-elementum-tristique">
                        <?php echo wp_kses_post($category->description); ?>
                    </div>
                <?php endif; ?>
            </div>


            <?php
            if (!empty($subcategories) && !is_wp_error($subcategories) && !is_shop()) : ?>

                <div class="nav-highlights">

                    <div class="glide">
                        <div class="glide__arrows" data-glide-el="controls">
                            <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                            <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <div class="glide__track" data-glide-el="track">
                            <div class="glide__slides">
                                <?php foreach ($subcategories as $subcategory) :
                                    $thumbnail_id = get_term_meta($subcategory->term_id, 'thumbnail_id', true);
                                    $image = wp_get_attachment_url($thumbnail_id);
                                ?>
                                    <div class="glide__slide">
                                        <div class="content">
                                            <?php if ($image) : ?>
                                                <img class="adobe-stock-678409791-preview" src="<?php echo esc_url($image); ?>" />
                                            <?php endif; ?>
                                            <div class="content2">
                                                <div class="section-title">
                                                    <div class="heading"><?php echo esc_html($subcategory->name); ?></div>
                                                    <?php if ($subcategory->description) : ?>
                                                        <div class="text">
                                                            <?php echo wp_kses_post($subcategory->description); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="action">
                                                    <div
                                                        class="style-link-small-false-alternate-false-icon-position-trailing">
                                                        <a href="<?php echo esc_url(get_term_link($subcategory)); ?>">
                                                            <div class="button">
                                                                <?php
                                                                $link_text = get_term_meta($subcategory->term_id, 'category_link_text', true);
                                                                if (!$link_text) {
                                                                    // Get parent category name
                                                                    $parent_cat = get_term($category->term_id, 'product_cat');
                                                                    $fallback_text = sprintf(
                                                                        'Shop %s %s',
                                                                        esc_html($parent_cat->name),
                                                                        esc_html($subcategory->name)
                                                                    );
                                                                    echo esc_html($fallback_text);
                                                                } else {
                                                                    echo esc_html($link_text);
                                                                }
                                                                ?>
                                                            </div>
                                                        </a>
                                                        <img class="icon-chevron-right" src="<?php echo get_template_directory_uri() . '/assets/image/icon-chevron.svg'; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="glide__bullets" data-glide-el="controls[nav]">
                            <?php foreach ($subcategories as $index => $subcategory) : ?>
                                <button class="glide__bullet" data-glide-dir="=<?php echo $index; ?>"></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (!is_shop()) : ?>
    <script>
        new Glide('.glide', {
            type: 'carousel',
            perView: 4,
            gap: 32,
            breakpoints: {
                1024: {
                    perView: 3
                },
                768: {
                    perView: 2
                },
                576: {
                    perView: 1
                }
            }
        }).mount();
    </script>
<?php endif; ?>