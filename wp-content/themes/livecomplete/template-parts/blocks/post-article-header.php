<?php

/**
 * Template part for displaying receipe post header
 *
 * @package live-complete
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<style>
    .live-complete-breadcrumbs-wrap {
        background-color: #fff;
    }

    .receipe-post-header {
        background: var(--background-color-primary, #ffffff);
        display: flex;
        flex-direction: column;
        gap: 80px;
        align-items: center;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }

    .content {
        display: flex;
        flex-direction: row;
        gap: 80px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .content2 {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        width: 420px;
        position: relative;
    }

    .content3 {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .content4 {
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: center;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .text-only-false-alternate-false-icon-position-no-icon {
        background: #d9734d;
        padding: 4px 8px 4px 8px;
        display: flex;
        flex-direction: row;
        gap: 0px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .text {
        color: var(--border-alternate, #ffffff);
        text-align: left;
        font-family: "Roboto-SemiBold", sans-serif;
        font-size: 14px;
        line-height: 150%;
        font-weight: 600;
        position: relative;
    }

    .blog-title-heading-will-go-here {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h1-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h1-font-size, 56px);
        line-height: var(--heading-desktop-h1-line-height, 120%);
        font-weight: var(--heading-desktop-h1-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .content5 {
        padding: 4px 0px 0px 0px;
        display: flex;
        flex-direction: row;
        gap: 4px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        height: 25px;
        position: relative;
    }

    .placeholder-image {
        flex: 1;
        height: 450px;
        position: relative;
        object-fit: cover;
    }
</style>

<div class="receipe-post-header">
    <div class="content">
        <div class="content2">
            <div class="content3">
                <div class="content4">
                    <div class="text-only-false-alternate-false-icon-position-no-icon">
                        <div class="text"><?php
                                            $categories = get_the_category();
                                            $sub_category = null;
                                            $main_category = null;

                                            if (!empty($categories)) {
                                                foreach ($categories as $category) {
                                                    if ($category->parent != 0) {
                                                        $sub_category = $category;
                                                        break;
                                                    } elseif (!$main_category) {
                                                        $main_category = $category;
                                                    }
                                                }

                                                echo esc_html($sub_category ? $sub_category->name : $main_category->name);
                                            } else {
                                                echo 'Uncategorized';
                                            }
                                            ?></div>
                    </div>
                </div>
                <div class="blog-title-heading-will-go-here">
                    <?php echo get_the_title(); ?>
                </div>
            </div>
            <div class="content5"></div>
        </div>
        <img class="placeholder-image" src="<?php
                                            echo has_post_thumbnail()
                                                ? get_the_post_thumbnail_url(null, 'full')
                                                : get_template_directory_uri() . '/assets/image/placeholder.png';
                                            ?>" />
    </div>
</div>