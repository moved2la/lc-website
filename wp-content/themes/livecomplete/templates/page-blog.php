<?php

/**
 * Template Name: Blog Landing Page
 * The template for displaying the blog landing page
 *
 * @package live-complete
 */

get_header();

$layout = live_complete_get_option('page_layout');

/**
 * Hook - live_complete_container_wrap_start 	
 *
 * @hooked live_complete_container_wrap_start	- 5
 */
do_action('live_complete_container_wrap_start', esc_attr($layout));
?>


<style>
    .live-complete-breadcrumbs-wrap {
        background-color: #fff;
    }

    .section-title {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        margin-bottom: 60px;
    }

    .section-title .content {
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: center;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .section-title .heading {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h1-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h1-font-size, 56px);
        line-height: var(--heading-desktop-h1-line-height, 120%);
        font-weight: var(--heading-desktop-h1-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .section-title .sub-heading {
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

    .categories {
        display: flex;
        flex-direction: row;
        gap: 0px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        margin-bottom: 32px;
    }

    .categories button {
        cursor: pointer;
        color: #000;
        transition: all 0.3s ease;
        background-color: #fff;
        padding: 8px 16px 8px 16px;
        margin: 0 8px;
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        border: 1px solid #fff;
    }

    .categories button.active,
    .categories button:hover {
        background-color: #fff;
        border: 1px solid #000;
        color: #000;
        border-color: #000;
    }

    /* Blog card grid */
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 32px;
        margin-bottom: 60px;
    }

    @media (max-width: 1024px) {
        .blog-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .blog-grid {
            grid-template-columns: 1fr;
        }
    }

    .blog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 32px;
        margin-bottom: 60px;
    }

    @media (max-width: 1024px) {
        .blog-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .blog-grid {
            grid-template-columns: 1fr;
        }
    }

    .read-more {
        text-decoration: none;
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        max-width: 109px;
        position: relative;

    }

    /* Blog card */
    .blog-grid .card {
        border-style: solid;
        border-color: var(--border-primary, #000000);
        border-width: 1px;
        display: flex;
        flex-direction: column;
        gap: 0px;
        align-items: flex-start;
        justify-content: flex-start;
        flex: 1;
        position: relative;
    }

    .blog-grid .card .placeholder-image {
        align-self: stretch;
        flex-shrink: 0;
        height: 300px;
        position: relative;
        object-fit: cover;
    }

    .blog-grid .card .content {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .blog-grid .card .content2 {
        display: flex;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .blog-grid .card .content2 .info {
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: center;
        justify-content: flex-start;
        flex-shrink: 0;
        position: relative;
    }

    .blog-grid .card .content2 .article-category {
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

    .blog-grid .card .content2 .article-category .text {
        color: var(--border-alternate, #ffffff);
        text-align: left;
        font-family: "Roboto-SemiBold", sans-serif;
        font-size: 14px;
        line-height: 150%;
        font-weight: 600;
        position: relative;
    }

    .blog-grid .card .content2 .text2 {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--text-small-semi-bold-font-family,
                "Roboto-SemiBold",
                sans-serif);
        font-size: var(--text-small-semi-bold-font-size, 14px);
        line-height: var(--text-small-semi-bold-line-height, 150%);
        font-weight: var(--text-small-semi-bold-font-weight, 600);
        position: relative;
        align-self: stretch;
    }

    .blog-grid .card .content2 .title {
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
        justify-content: flex-start;
        align-self: stretch;
        flex-shrink: 0;
        position: relative;
    }

    .blog-grid .card .content2 .title .heading {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: var(--heading-desktop-h5-font-family, "Roboto-Bold", sans-serif);
        font-size: var(--heading-desktop-h5-font-size, 24px);
        line-height: var(--heading-desktop-h5-line-height, 140%);
        font-weight: var(--heading-desktop-h5-font-weight, 700);
        position: relative;
        align-self: stretch;
    }

    .blog-grid .card .content2 .title .text3 {
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

    .blog-grid .card .content2 .read-more {
        display: flex;
        flex-direction: row;
        gap: 8px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 109px;
        position: relative;
    }

    .blog-grid .card .content2 .read-more .button {
        color: var(--text-primary, #000000);
        text-align: left;
        font-family: "Roboto-Regular", sans-serif;
        font-size: 16px;
        line-height: 150%;
        font-weight: 400;
        position: relative;
    }

    .blog-grid .card .content2 .read-more .icon-chevron-right {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        position: relative;
        overflow: visible;
    }
</style>


<div class="section-title">
    <div class="content">
        <div class="heading">News</div>
        <div class="sub-heading">
            Explore the world of plant-based innovations and trends.
        </div>
    </div>
</div>

<div class="categories">
    <button class="button" data-category="all">
        <div class="view-all">View all</div>
    </button>
    <?php
    // Get posts from 'receipies' category first
    $receipies_posts = get_posts(array(
        'category_name' => 'blog',
        'numberposts' => -1,
        'post_status' => 'publish'
    ));

    // Collect all tags used in these posts
    $tag_ids = array();
    foreach ($receipies_posts as $post) {
        $post_tags = wp_get_post_tags($post->ID);
        if ($post_tags) {
            foreach ($post_tags as $tag) {
                $tag_ids[$tag->term_id] = $tag;
            }
        }
    }

    wp_reset_postdata();

    // Sort tags by name
    if (!empty($tag_ids)) {
        usort($tag_ids, function ($a, $b) {
            return strcasecmp($a->name, $b->name);
        });
    }

    // Display sorted tags
    foreach ($tag_ids as $tag) : ?>
        <button data-category="<?php echo esc_attr($tag->slug); ?>">
            <div class="category-item"><?php echo esc_html(ucwords($tag->name)); ?></div>
        </button>
    <?php endforeach; ?>
</div>


<div class="blog-grid">
    <?php
    // Modify the query to only get posts from 'blog' category
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'category_name' => 'blog',
        'post_status' => 'publish'
    );

    $blog_posts = new WP_Query($args);

    if ($blog_posts->have_posts()) :
        while ($blog_posts->have_posts()) : $blog_posts->the_post();
            $tag_slugs = array();
            $display_tag = 'Blog'; // Default fallback text

            $tags = get_the_tags();
            if ($tags) {
                foreach ($tags as $tag) {
                    $tag_slugs[] = $tag->slug;
                }
                $display_tag = ucwords($tags[0]->name);
            }

            // Add 'card' class and all tag slugs as classes
            $card_classes = array('card');
            if (!empty($tag_slugs)) {
                $card_classes = array_merge($card_classes, $tag_slugs);
            }
            $class_string = esc_attr(implode(' ', $card_classes));

            $thumbnail = get_the_post_thumbnail_url() ?: get_template_directory_uri() . '/assets/image/placeholder.png';

            // Reading time calculation
            $content = get_the_content();
            $word_count = str_word_count(strip_tags($content));
            $reading_time = ceil($word_count / 200);
            $reading_time_text = $reading_time . ' min read';

            // Excerpt handling
            $excerpt = get_the_excerpt();
            if (empty($excerpt)) {
                $content = strip_shortcodes($content);
                $content = strip_tags($content);
                $excerpt = wp_trim_words($content, 20, '...');
            } else {
                $excerpt = wp_trim_words($excerpt, 20, '...');
            }
    ?>
            <div class="<?php echo $class_string; ?>">
                <img class="placeholder-image" src="<?php echo esc_url($thumbnail); ?>" />
                <div class="content">
                    <div class="content2">
                        <div class="info">
                            <div class="article-category">
                                <div class="text"><?php echo esc_html(ucwords($display_tag)); ?></div>
                            </div>
                            <div class="text2"><?php echo esc_html($reading_time_text); ?></div>
                        </div>
                        <div class="title">
                            <div class="heading"><?php the_title(); ?></div>
                            <div class="text3"><?php echo esc_html($excerpt); ?></div>
                        </div>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="read-more">
                        <div class="button">Read more</div>
                        <img class="icon-chevron-right" src="<?php echo get_template_directory_uri() . '/assets/image/icon-chevron.svg'; ?>" />
                    </a>
                </div>
            </div>
    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.categories button');
        const cards = document.querySelectorAll('.blog-grid .card');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                button.classList.add('active');

                const category = button.getAttribute('data-category');

                cards.forEach(card => {
                    if (category === 'all') {
                        card.style.display = 'flex';
                    } else {
                        if (card.classList.contains(category)) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    }
                });
            });
        });

        // Trigger 'View all' by default
        document.querySelector('[data-category="all"]').click();
    });
</script>

<?php
/**
 * Hook - live_complete_container_wrap_end	
 *
 * @hooked container_wrap_end - 999
 */
do_action('live_complete_container_wrap_end', esc_attr($layout));
get_footer();
