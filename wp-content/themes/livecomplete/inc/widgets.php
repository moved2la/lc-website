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

        if ($post_id) {
            $post = get_post($post_id);

            if ($post) {
                echo $args['before_widget'];
        ?>
                <div class="blog-item">
                    <img
                        class="article-image"
                        src="<?php echo get_the_post_thumbnail_url($post_id, 'medium'); ?>" />
                    <div class="content">
                        
                            <div class="article-title"><?php echo get_the_title($post); ?></div>
                            <div class="article-description">
                                <?php echo get_the_excerpt($post); ?>
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
                        margin-bottom: 10px;
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
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('post_id'); ?>">Post ID:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('post_id'); ?>"
                name="<?php echo $this->get_field_name('post_id'); ?>"
                type="number"
                value="<?php echo esc_attr($post_id); ?>">
        </p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['post_id'] = (!empty($new_instance['post_id'])) ? strip_tags($new_instance['post_id']) : '';
        return $instance;
    }
}

function register_featured_blog_post_widget()
{
    register_widget('Featured_Blog_Post_Widget');
}
add_action('widgets_init', 'register_featured_blog_post_widget');

/* -------------- End Blog Post Widget -------------- */
