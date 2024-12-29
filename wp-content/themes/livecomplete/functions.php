<?php

/**
 * LiveComplete functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package live-complete
 */
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/theme-core.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/class/class-header.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/class/class-body.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/class/class-footer.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/class/class-template-tags.php';
require get_template_directory() . '/inc/class/class-post-related.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * TGM Plugins
 */
require get_template_directory() . '/inc/tgm/recommended-plugins.php';

require get_template_directory() . '/inc/customizer/customizer.php';


/**
 * Implement pro features.
 */
// require get_template_directory() . '/inc/admin/admin-page.php';

if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}

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
                        flex: 1;1
                        text-align: left;
                        overflow: hidden;
                    }

                    .featured-product-widget .product-title {
                        margin-bottom: 10px;
                        font-family: var(--text-regular-semi-bold-font-family,
                                "Roboto-SemiBold",
                                sans-serif);
                        font-size: var(--text-regular-semi-bold-font-size, 16px);
                        line-height: var(--text-regular-semi-bold-line-height, 150%);
                        font-weight: var(--text-regular-semi-bold-font-weight, 600);
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

// Register the widget
function register_featured_product_widget()
{
    register_widget('Featured_Product_Widget');
}
add_action('widgets_init', 'register_featured_product_widget');

// Add custom content to WooCommerce category header
function add_category_header_content() {
    if (is_product_category()) {
        $category = get_queried_object();
        get_template_part('template-parts/woocommerce/category', 'header', array(
            'category' => $category
        ));
    }
}
// Change the hook to woocommerce_before_main_content
remove_action('woocommerce_archive_description', 'add_category_header_content', 10);
add_action('woocommerce_before_main_content', 'add_category_header_content', 5);

// Add custom field to category form
function add_category_link_text_field() {
    ?>
    <div class="form-field">
        <label for="category_link_text"><?php _e('Category Link Text', 'live-complete'); ?></label>
        <input type="text" name="category_link_text" id="category_link_text">
        <p class="description"><?php _e('Enter the text to display for the category link', 'live-complete'); ?></p>
    </div>
    <?php
}
add_action('product_cat_add_form_fields', 'add_category_link_text_field');

// Add custom field to category edit form
function edit_category_link_text_field($term) {
    $link_text = get_term_meta($term->term_id, 'category_link_text', true);
    ?>
    <tr class="form-field">
        <th scope="row"><label for="category_link_text"><?php _e('Header Category Link Text', 'live-complete'); ?></label></th>
        <td>
            <input type="text" name="category_link_text" id="category_link_text" value="<?php echo esc_attr($link_text); ?>">
            <p class="description"><?php _e('Enter the text to display for the category link. Used for header section on category pages. (Custom field for LiveComplete)', 'live-complete'); ?></p>
        </td>
    </tr>
    <?php
}
add_action('product_cat_edit_form_fields', 'edit_category_link_text_field');

// Add heading text field to category add form
function add_category_heading_text_field() {
    ?>
    <div class="form-field">
        <label for="category_heading_text"><?php _e('Category Heading Text', 'live-complete'); ?></label>
        <input type="text" name="category_heading_text" id="category_heading_text">
        <p class="description"><?php _e('Enter the heading text to display on the category page', 'live-complete'); ?></p>
    </div>
    <?php
}
add_action('product_cat_add_form_fields', 'add_category_heading_text_field');

// Add heading text field to category edit form
function edit_category_heading_text_field($term) {
    $heading_text = get_term_meta($term->term_id, 'category_heading_text', true);
    ?>
    <tr class="form-field">
        <th scope="row"><label for="category_heading_text"><?php _e('Header Category Heading Text', 'live-complete'); ?></label></th>
        <td>
            <input type="text" name="category_heading_text" id="category_heading_text" value="<?php echo esc_attr($heading_text); ?>">
            <p class="description"><?php _e('Enter the heading text to display on the category page. Used for header section. (Custom field for LiveComplete)', 'live-complete'); ?></p>
        </td>
    </tr>
    <?php
}
add_action('product_cat_edit_form_fields', 'edit_category_heading_text_field');

// Update save function to handle both fields
function save_category_custom_fields($term_id) {
    if (isset($_POST['category_link_text'])) {
        update_term_meta($term_id, 'category_link_text', sanitize_text_field($_POST['category_link_text']));
    }
    if (isset($_POST['category_heading_text'])) {
        update_term_meta($term_id, 'category_heading_text', sanitize_text_field($_POST['category_heading_text']));
    }
}
// Remove the old save function hook and add the new one
remove_action('created_product_cat', 'save_category_link_text');
remove_action('edited_product_cat', 'save_category_link_text');
add_action('created_product_cat', 'save_category_custom_fields');
add_action('edited_product_cat', 'save_category_custom_fields');
