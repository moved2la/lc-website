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


require get_template_directory() . '/inc/class/class-header.php';


require get_template_directory() . '/inc/class/class-body.php';


require get_template_directory() . '/inc/class/class-footer.php';


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
 * Implement admin features.
 */
// require get_template_directory() . '/inc/admin/admin-page.php';

if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}

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

/* -------------- Add custom field to category form -------------- */

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

function live_complete_support_template_part($atts) {
    $atts = shortcode_atts(array(
        'name' => 'contact-form' // default template part
    ), $atts);

    ob_start();
    get_template_part('template-parts/support/' . sanitize_text_field($atts['name']));
    $content = ob_get_clean();
    return $content;
}
add_shortcode('support_section', 'live_complete_support_template_part');

// Add custom meta boxes for support page header
// function live_complete_support_page_meta_boxes() {
//     add_meta_box(
//         'support_page_header',
//         'Support Page Header',
//         'live_complete_support_page_header_callback',
//         'page',
//         'normal',
//         'high'
//     );
// }
add_action('add_meta_boxes', function($post_type) {
    if ($post_type != 'page') {
        return;
    }

    // Get the current post
    $post = get_post();

    // Get the current template
    $template_file = get_post_meta($post->ID, '_wp_page_template', true);

    // Only add the metabox if this is the support page template
    if ($template_file === 'templates/page-support.php') {
        add_meta_box(
            'support_page_header',
            __('Support Page Header', 'live-complete'),
            'live_complete_support_page_header_callback',
            'page',
            'normal',
            'high'
        );
    }
});


// Meta box callback function
function live_complete_support_page_header_callback($post) {
    // Add nonce for security
    wp_nonce_field('support_page_header_nonce', 'support_page_header_nonce');

    // Get existing values
    $header_title = get_post_meta($post->ID, '_support_header_title', true);
    $header_desc = get_post_meta($post->ID, '_support_header_desc', true);
    ?>
    
    <div class="support-page-fields" style="margin: 20px 0;">
        <p>
            <label for="support_header_title" style="display: block; margin-bottom: 5px;"><strong>Header Title</strong></label>
            <input 
                type="text" 
                id="support_header_title" 
                name="support_header_title" 
                value="<?php echo esc_attr($header_title); ?>" 
                style="width: 100%;"
            >
        </p>
        <p>
            <label for="support_header_desc" style="display: block; margin-bottom: 5px;"><strong>Header Description</strong></label>
            <textarea 
                id="support_header_desc" 
                name="support_header_desc" 
                rows="4" 
                style="width: 100%;"
            ><?php echo esc_textarea($header_desc); ?></textarea>
        </p>
    </div>
    <?php
}

// Save meta box data
function live_complete_save_support_page_meta($post_id) {
    // Check if nonce is set
    if (!isset($_POST['support_page_header_nonce'])) {
        return;
    }

    // Verify nonce
    if (!wp_verify_nonce($_POST['support_page_header_nonce'], 'support_page_header_nonce')) {
        return;
    }

    // If this is autosave, don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save header title
    if (isset($_POST['support_header_title'])) {
        update_post_meta(
            $post_id,
            '_support_header_title',
            sanitize_text_field($_POST['support_header_title'])
        );
    }

    // Save header description
    if (isset($_POST['support_header_desc'])) {
        update_post_meta(
            $post_id,
            '_support_header_desc',
            sanitize_textarea_field($_POST['support_header_desc'])
        );
    }
}
add_action('save_post', 'live_complete_save_support_page_meta');


/* Completely Disable Comments */
add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;

    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

// Allow custom templates for posts
function register_custom_post_templates($templates)
{
    // Get all files in templates directory that start with 'post-'
    $template_path = get_template_directory() . '/templates';
    $files = glob($template_path . '/post-*.php');

    if ($files) {
        foreach ($files as $file) {
            $filename = basename($file);
            // Get template name from file header
            $template_data = get_file_data($file, array('Template Name' => 'Template Name'));
            $template_name = $template_data['Template Name'];

            if (empty($template_name)) {
                // If no template name specified, create one from filename
                $template_name = ucwords(str_replace(array('post-', '.php', '-'), array('', '', ' '), $filename));
            }

            // Use templates/filename as the key instead of just filename
            $templates['templates/' . $filename] = $template_name;
        }
    }

    return $templates;
}

function add_custom_post_templates()
{
    if (is_admin()) {
        add_filter('theme_post_templates', 'register_custom_post_templates');
    }
}

add_action('init', 'add_custom_post_templates');

/* -------------- Add custom column to posts list -------------- */

// Add template column to posts list
function add_template_column($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['post_template'] = 'Template';
        }
    }
    return $new_columns;
}
add_filter('manage_posts_columns', 'add_template_column');

// Populate template column content
function populate_template_column($column_name, $post_id) {
    if ($column_name === 'post_template') {
        $template = get_post_meta($post_id, '_wp_page_template', true);
        if ($template) {
            // Get template name from file header
            $template_path = get_template_directory() . '/' . $template;
            if (file_exists($template_path)) {
                $template_data = get_file_data($template_path, array('Template Name' => 'Template Name'));
                if (!empty($template_data['Template Name'])) {
                    echo esc_html($template_data['Template Name']);
                } else {
                    echo '—';
                }
            } else {
                echo '—';
            }
        } else {
            echo '—';
        }
    }
}
add_action('manage_posts_custom_column', 'populate_template_column', 10, 2);

// Make the template column sortable
function make_template_column_sortable($columns) {
    $columns['post_template'] = 'post_template';
    return $columns;
}
add_filter('manage_edit-post_sortable_columns', 'make_template_column_sortable');

// Helper function to get registered templates
function get_theme_templates($post_type)
{
    $templates = array();
    $files = wp_get_theme()->get_files('php', 1);

    foreach ($files as $file => $full_path) {
        $headers = get_file_data($full_path, array(
            'Template Name' => 'Template Name',
            'Template Post Type' => 'Template Post Type'
        ));

        if (
            !empty($headers['Template Name']) &&
            (!$headers['Template Post Type'] || $headers['Template Post Type'] === $post_type)
        ) {
            $templates[basename($file)] = $headers['Template Name'];
        }
    }

    return $templates;
}

/* -------------- Add custom column to posts list -------------- */

/*
* Redirect post category pages to their respective landing pages,
* so that default category page template is not shown.
* 
*/
add_action('template_redirect', 'redirect_category_pages');

function redirect_category_pages()
{
    if (is_category('blog')) {
        wp_redirect(home_url() . '/explore/blog');
        exit;
    }
    if (is_category('recipes')) {
        wp_redirect(home_url() . '/explore/recipes');
        exit;
    }
}