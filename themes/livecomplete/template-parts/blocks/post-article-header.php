<?php

/**
 * Template part for displaying article post header
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

    .article-post-header {
        background: #fff;
        display: flex;
        flex-direction: column;
        gap: 80px;
        align-items: center;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
    }

    .article-post-header .content-row {
        display: flex;
        flex-direction: row;
        gap: 80px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
        flex-wrap: wrap;
    }

    .article-post-header .content-col1 {
        display: flex;
        flex-direction: column;
        gap: 32px;
        align-items: flex-start;
        justify-content: flex-start;
        flex-shrink: 0;
        max-width: 420px;
        position: relative;
    }

    .article-post-header .content-col2 {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .article-post-header .blog-tag {
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

    .article-post-header .blog-tag-text {
        color: #fff;
        text-align: left;
        font-family: "Roboto-SemiBold", sans-serif;
        font-size: 14px;
        line-height: 150%;
        font-weight: 600;
        position: relative;
    }

    .article-post-header .blog-title {
        color: #000;
        text-align: left;
        font-family: "Roboto-Bold", sans-serif;
        font-size: 56px;
        line-height: 120%;
        font-weight: 700;
        position: relative;
        align-self: stretch;
    }

    .article-post-header .publish-date {
        color: #000;
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 14px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
    }

    .article-post-header .placeholder-image {
        flex: 1;
        max-height: 450px;
        position: relative;
        object-fit: cover;
        min-width: 300px;
    }

    .article-post-header .author {
        display: flex;
        align-items: center;
        font-size: 14px;
        line-height: 150%;
        font-weight: 400;
        gap: 8px;
    }

    .article-post-header .author img {
        width: 24px;
        height: 24px;
        border-radius: 50%;
    }
</style>

<div class="article-post-header">
    <div class="content-row">
        <div class="content-col1">
            <div class="content-col2">
                <div class="blog-tag">
                    <div class="blog-tag-text"><?php
                                                $categories = get_the_category();
                                                $is_blog = false;

                                                // Check if post is in Blog category
                                                foreach ($categories as $category) {
                                                    if (strtolower($category->name) === 'blog') {
                                                        $is_blog = true;
                                                        break;
                                                    }
                                                }

                                                if ($is_blog) {
                                                    // Show first tag in title case or default to "Blog"
                                                    $post_tags = get_the_tags();
                                                    if ($post_tags) {
                                                        echo esc_html(ucwords(strtolower($post_tags[0]->name)));
                                                    } else {
                                                        echo 'Blog';
                                                    }
                                                } else {
                                                    // Original category logic
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
                                                }
                                                ?></div>
                </div>
                <div class="blog-title">
                    <?php echo get_the_title(); ?>
                </div>
            </div>
            <div class="content-row">
                <div class="content-col1" style="gap: 0;">
                    <div class="publish-date">Published on <?php echo get_the_date('j M Y'); ?></div>
                    <div class="author">
                        <?php
                        $avatar = get_avatar(get_the_author_meta('ID'), 24);
                        if ($avatar && !empty(get_avatar_url(get_the_author_meta('ID')))) {
                            echo $avatar;
                        }
                        ?>
                        By <?php echo get_the_author_meta('display_name'); ?>
                    </div>
                </div>
            </div>
        </div>
        <img class="placeholder-image" src="<?php
                                            echo has_post_thumbnail()
                                                ? get_the_post_thumbnail_url(null, 'full')
                                                : get_template_directory_uri() . '/assets/image/placeholder.png';
                                            ?>" />
    </div>
</div>