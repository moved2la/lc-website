<?php

/**
 * Functions which enable custom widgets
 *
 * @package live-complete
 */


/* -------------- Featured Product Widget -------------- */

class Featured_Product_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'featured_product_widget',
            'Featured Product Widget',
            array('description' => 'Displays a WooCommerce product with image, name, description, and shop link')
        );
    }

    public function widget($args, $instance)
    {
        $product_id = !empty($instance['product_id']) ? $instance['product_id'] : '';

        if ($product_id) {
            $product = wc_get_product($product_id);

            if ($product) {
                echo $args['before_widget'];
?>
                <div class="featured-product-widget">
                    <div class="product-image">
                        <?php echo $product->get_image(); ?>
                    </div>
                    <div class="product-content">
                        <h3 class="product-title"><?php echo $product->get_name(); ?></h3>
                        <div class="product-description">
                            <?php echo $product->get_short_description(); ?>
                        </div>
                        <a href="<?php echo $product->get_permalink(); ?>" class="shop-now-link">
                            Shop Now
                        </a>
                    </div>
                </div>
                <style>
                    .featured-product-widget {
                        color: #000;
                        display: flex;
                        align-items: center;
                        gap: 20px;
                        max-height: 171px;
                        max-width: 416px;
                        overflow: hidden;
                    }

                    .featured-product-widget .product-image {
                        flex-shrink: 0;
                        width: 171px;
                        height: 171px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .featured-product-widget .product-image img {
                        max-width: 100%;
                        max-height: 100%;
                        width: auto;
                        height: auto;
                        object-fit: contain;
                    }

                    .featured-product-widget .product-content {
                        flex: 1;
                        text-align: left;
                        overflow: hidden;
                    }

                    .featured-product-widget .product-title {
                        margin-bottom: 10px;
                        font-family: "Roboto-SemiBold", sans-serif;
                        font-size: 16px;
                        line-height: 150%;
                        font-weight: 600;
                    }

                    .featured-product-widget .product-description {
                        margin-bottom: 15px;
                        overflow: hidden;
                        display: -webkit-box;
                        -webkit-line-clamp: 3;
                        -webkit-box-orient: vertical;
                    }

                    .featured-product-widget .shop-now-link {
                        color: #000;
                        text-decoration: underline;
                    }
                </style>
        <?php
                echo $args['after_widget'];
            }
        }
    }

    public function form($instance)
    {
        $product_id = !empty($instance['product_id']) ? $instance['product_id'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('product_id'); ?>">Product ID:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('product_id'); ?>"
                name="<?php echo $this->get_field_name('product_id'); ?>"
                type="number"
                value="<?php echo esc_attr($product_id); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['product_id'] = (!empty($new_instance['product_id'])) ? strip_tags($new_instance['product_id']) : '';
        return $instance;
    }
}

function register_featured_product_widget()
{
    register_widget('Featured_Product_Widget');
}
add_action('widgets_init', 'register_featured_product_widget');

/* -------------- End Featured Product Widget -------------- */

/* -------------- Blog Post Widget -------------- */

class Featured_Blog_Post_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'featured_blog_post_widget',
            'Featured Blog Post Widget',
            array('description' => 'Displays a blog post with thumbnail, title, excerpt, and read more link')
        );
    }

    public function widget($args, $instance)
    {
        $post_id = !empty($instance['post_id']) ? $instance['post_id'] : '';
        $custom_title = !empty($instance['custom_title']) ? $instance['custom_title'] : '';
        $custom_excerpt = !empty($instance['custom_excerpt']) ? $instance['custom_excerpt'] : '';

        if ($post_id) {
            $post = get_post($post_id);

            if ($post) {
                echo $args['before_widget'];
        ?>
                <div class="blog-item">

                    <div class="content">
                        <img
                            class="article-image"
                            src="<?php echo get_the_post_thumbnail_url($post_id, 'medium'); ?>" />
                        <div class="article-title"><?php 
                            echo esc_html($custom_title ?: get_the_title($post));
                        ?></div>
                        <div class="article-description">
                            <?php 
                                echo esc_html($custom_excerpt ?: get_the_excerpt($post));
                            ?>
                        </div>

                        <a href="<?php echo get_permalink($post); ?>" class="read-more">Read more</a>
                    </div>
                </div>
                <style>
                    .blog-item {
                        color: #000;
                        padding: 8px 0px 8px 0px;
                        display: flex;
                        flex-direction: row;
                        gap: 24px;
                        align-items: flex-start;
                        justify-content: flex-start;
                        position: relative;
                        max-width: 427px;
                    }

                    .blog-item .article-image {
                        flex-shrink: 0;
                        max-width: 160px !important;
                        max-height: 136px !important;
                        position: relative;
                        object-fit: cover;
                    }

                    .blog-item .content {
                        display: flex;
                        flex-direction: column;
                        gap: 8px;
                        align-items: flex-start;
                        justify-content: flex-start;
                        flex-shrink: 0;
                        position: relative;
                        flex: 1;
                    }

                    .blog-item .article-title {
                        font-family: "Roboto-SemiBold", sans-serif;
                        font-size: 16px;
                        line-height: 150%;
                        font-weight: 600;
                        /* margin-bottom: 10px; */
                    }

                    .blog-item .article-description {
                        overflow: hidden;
                        font-size: 14px;
                        line-height: 150%;
                        font-weight: 400;
                    }

                    .blog-item .read-more {
                        font-size: 14px;
                        line-height: 150%;
                        font-weight: 400;
                        color: #000;
                        text-decoration: underline;
                        cursor: pointer;
                    }
                </style>
        <?php
                echo $args['after_widget'];
            }
        }
    }

    public function form($instance)
    {
        $post_id = !empty($instance['post_id']) ? $instance['post_id'] : '';
        $custom_title = !empty($instance['custom_title']) ? $instance['custom_title'] : '';
        $custom_excerpt = !empty($instance['custom_excerpt']) ? $instance['custom_excerpt'] : '';
        
        // Get all posts
        $posts = get_posts(array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        ));
?>
        <p>
            <label for="<?php echo $this->get_field_id('post_id'); ?>">Select Post:</label>
            <select class="widefat" id="<?php echo $this->get_field_id('post_id'); ?>" name="<?php echo $this->get_field_name('post_id'); ?>">
                <option value="">Select a post</option>
                <?php foreach ($posts as $post) : ?>
                    <option value="<?php echo $post->ID; ?>" <?php selected($post_id, $post->ID); ?>><?php echo $post->post_title; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('custom_title'); ?>">Custom Title (max 3 words):</label>
            <input class="widefat" id="<?php echo $this->get_field_id('custom_title'); ?>" name="<?php echo $this->get_field_name('custom_title'); ?>" type="text" value="<?php echo esc_attr($custom_title); ?>" />
            <small>Leave empty to use post title</small>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('custom_excerpt'); ?>">Custom Excerpt (max 5 words):</label>
            <input class="widefat" id="<?php echo $this->get_field_id('custom_excerpt'); ?>" name="<?php echo $this->get_field_name('custom_excerpt'); ?>" type="text" value="<?php echo esc_attr($custom_excerpt); ?>" />
            <small>Leave empty to use post excerpt</small>
        </p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['post_id'] = (!empty($new_instance['post_id'])) ? strip_tags($new_instance['post_id']) : '';
        $instance['custom_title'] = (!empty($new_instance['custom_title'])) ? strip_tags($new_instance['custom_title']) : '';
        $instance['custom_excerpt'] = (!empty($new_instance['custom_excerpt'])) ? strip_tags($new_instance['custom_excerpt']) : '';
        
        return $instance;
    }
}

function register_featured_blog_post_widget()
{
    register_widget('Featured_Blog_Post_Widget');
}
add_action('widgets_init', 'register_featured_blog_post_widget');

/* -------------- End Blog Post Widget -------------- */

/* -------------- Menu Link Widget -------------- */

class Menu_Link_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'menu_link_widget',
            'Menu Link Widget',
            array('description' => 'Displays a menu item with image, title, description, and links to a page')
        );
    }

    public function widget($args, $instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $page_id = !empty($instance['page_id']) ? $instance['page_id'] : '';
        $image_id = !empty($instance['image_id']) ? $instance['image_id'] : '';

        if ($page_id) {
            $page_url = get_permalink($page_id);
            echo $args['before_widget'];
        ?>
            <div class="menu-item">

                <div class="menu-item-image">
                    <?php echo wp_get_attachment_image($image_id, 'medium'); ?>
                </div>
                <div class="menu-item-content">
                    <a href="<?php echo esc_url($page_url); ?>">
                        <div class="menu-item-title"><?php echo esc_html($title); ?></div>
                    </a>
                    <div class="menu-item-description">
                        <?php echo esc_html($description); ?>
                    </div>
                </div>
            </div>
        <?php
            echo $args['after_widget'];
        }
    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $page_id = !empty($instance['page_id']) ? $instance['page_id'] : '';
        $image_id = !empty($instance['image_id']) ? $instance['image_id'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>"
                type="text"
                value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('description'); ?>">Description:</label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>"
                name="<?php echo $this->get_field_name('description'); ?>"><?php echo esc_textarea($description); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('page_id'); ?>">Page:</label>
            <?php
            wp_dropdown_pages(array(
                'name' => $this->get_field_name('page_id'),
                'id' => $this->get_field_id('page_id'),
                'selected' => $page_id
            ));
            ?>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('image_id'); ?>">Image:</label>
        <div class="image-preview-wrapper">
            <img id="<?php echo $this->get_field_id('image_preview'); ?>"
                src="<?php echo $image_id ? wp_get_attachment_url($image_id) : ''; ?>"
                style="max-width: 100px; <?php echo !$image_id ? 'display:none;' : ''; ?>" />
        </div>
        <input class="widefat" id="<?php echo $this->get_field_id('image_id'); ?>"
            name="<?php echo $this->get_field_name('image_id'); ?>"
            type="hidden"
            value="<?php echo esc_attr($image_id); ?>">
        <button class="upload_image_button button button-primary">Upload Image</button>
        <button class="remove_image_button button" <?php echo !$image_id ? 'style="display:none;"' : ''; ?>>Remove Image</button>
        </p>
        <script>
            // Initialize the media uploader functionality
            function initMediaUploader(widget) {
                var frame,
                    uploadButton = widget.find('.upload_image_button'),
                    removeButton = widget.find('.remove_image_button'),
                    imageId = widget.find('input[name*="image_id"]'),
                    imagePreview = widget.find('img[id*="image_preview"]');

                uploadButton.off('click').on('click', function(e) {
                    e.preventDefault();

                    if (frame) {
                        frame.open();
                        return;
                    }

                    frame = wp.media({
                        title: 'Select or Upload Media',
                        button: {
                            text: 'Use this media'
                        },
                        multiple: false
                    });

                    frame.on('select', function() {
                        var attachment = frame.state().get('selection').first().toJSON();
                        imageId.val(attachment.id);
                        imagePreview.attr('src', attachment.url).show();
                        removeButton.show();
                    });

                    frame.open();
                });

                removeButton.off('click').on('click', function(e) {
                    e.preventDefault();
                    imageId.val('');
                    imagePreview.attr('src', '').hide();
                    removeButton.hide();
                });
            }

            // Initialize on document ready
            jQuery(document).ready(function($) {
                $('.widget[id*="menu_link_widget"]').each(function() {
                    initMediaUploader($(this));
                });
            });

            // Initialize when widget is added or updated
            jQuery(document).on('widget-added widget-updated', function(event, widget) {
                if (widget.is('[id*="menu_link_widget"]')) {
                    initMediaUploader(widget);
                }
            });
        </script>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['description'] = (!empty($new_instance['description'])) ? strip_tags($new_instance['description']) : '';
        $instance['page_id'] = (!empty($new_instance['page_id'])) ? strip_tags($new_instance['page_id']) : '';
        $instance['image_id'] = (!empty($new_instance['image_id'])) ? strip_tags($new_instance['image_id']) : '';
        return $instance;
    }
}

function register_menu_link_widget()
{
    register_widget('Menu_Link_Widget');
}
add_action('widgets_init', 'register_menu_link_widget');

/* -------------- End Menu Link Widget -------------- */
