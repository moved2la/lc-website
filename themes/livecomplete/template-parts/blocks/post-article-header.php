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
        flex-direction: column;
        align-items: flex-start;
        font-size: 14px;
        line-height: 150%;
        font-weight: 400;
        gap: 8px;
    }

    .article-post-header .author-line {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .article-post-header .authors-wrapper {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding-left: 23px;
        /* Align with first author's name */
    }

    .article-post-header .author-name {
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
                                                    
                                                    $sub_category = null;
                                                    
                                                    // Look for a subcategory of Blog
                                                    foreach ($categories as $category) {
                                                        if ($category->parent != 0) {
                                                            $parent_cat = get_category($category->parent);
                                                            if (strtolower($parent_cat->name) === 'blog') {
                                                                $sub_category = $category;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                    
                                                    if ($sub_category) {
                                                        echo esc_html(ucwords(strtolower($sub_category->name)));
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
                <div class="content-col1" style="gap: 10px;">
                    <div class="publish-date">Published on <?php echo get_the_date('j M Y'); ?></div>
                    <div class="author">
                        <div class="author-line">
                            By
                            <?php
                            $authors = get_post_authors();
                            if (!empty($authors)) {
                                echo '<div class="author-name">';
                                echo get_avatar($authors[0]->ID, 24);
                                echo $authors[0]->display_name;
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <?php if (count($authors) > 1): ?>
                            <div class="authors-wrapper">
                                <?php
                                for ($i = 1; $i < count($authors); $i++) {
                                    echo '<div class="author-name">';
                                    echo get_avatar($authors[$i]->ID, 24);
                                    echo $authors[$i]->display_name;
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        <?php endif; ?>
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