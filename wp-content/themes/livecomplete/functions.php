<?php

/**
 * LiveComplete functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package live-complete
 */

require get_template_directory() . '/vendors/sendgrid/sendgrid-php.php';

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

/**
 * Implement custom widgets
 */
require get_template_directory() . '/inc/widgets.php';


/**
 * Include AJAX handlers
 */
require get_template_directory() . '/inc/ajax-handlers.php';


/* -------------- Add custom field to category form -------------- */

// Add custom field to category form
function add_category_link_text_field()
{
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
function edit_category_link_text_field($term)
{
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
function add_category_heading_text_field()
{
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
function edit_category_heading_text_field($term)
{
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
function save_category_custom_fields($term_id)
{
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

function live_complete_support_template_part($atts)
{
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
add_action('add_meta_boxes', function ($post_type) {
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
function live_complete_support_page_header_callback($post)
{
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
                style="width: 100%;">
        </p>
        <p>
            <label for="support_header_desc" style="display: block; margin-bottom: 5px;"><strong>Header Description</strong></label>
            <textarea
                id="support_header_desc"
                name="support_header_desc"
                rows="4"
                style="width: 100%;"><?php echo esc_textarea($header_desc); ?></textarea>
        </p>
    </div>
<?php
}

// Save meta box data
function live_complete_save_support_page_meta($post_id)
{
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


// Add meta box for Learn page template
add_action('add_meta_boxes', function ($post_type) {
    if ($post_type != 'page') {
        return;
    }


    // Get the current post
    $post = get_post();

    $template_file = get_post_meta($post->ID, '_wp_page_template', true);
    if ($template_file === 'templates/page-learn.php') {
        add_meta_box(
            'learn_page_images', // Meta box ID
            'Learn Page Images', // Meta box title
            'render_learn_page_meta_box', // Callback function
            'page', // Post type
            'normal', // Context
            'high' // Priority
        );
    }
});
function add_learn_page_meta_box()
{
    add_meta_box(
        'learn_page_images', // Meta box ID
        'Learn Page Images', // Meta box title
        'render_learn_page_meta_box', // Callback function
        'page', // Post type
        'normal', // Context
        'high' // Priority
    );
}


// Render meta box content
function render_learn_page_meta_box($post)
{
    // Add nonce for security
    wp_nonce_field('learn_page_meta_box', 'learn_page_meta_box_nonce');

    // Get existing values
    $story_image = get_post_meta($post->ID, '_learn_story_image', true);
    $difference_image = get_post_meta($post->ID, '_learn_difference_image', true);
    $impact_image = get_post_meta($post->ID, '_learn_impact_image', true);

    ?>
    <style>
        .image-preview {
            max-width: 100px;
            max-height: 100px;
            margin: 10px 0;
            display: block;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }
        .image-preview.hidden {
            display: none;
        }
        .image-upload-wrap {
            display: flex;
            align-items: center;
            gap: 15px;
        }
    </style>

    <p>
        <label for="learn_story_image">Our Story Image:</label><br>
        <div class="image-upload-wrap">
            <div>
                <input type="text" id="learn_story_image" name="learn_story_image" 
                       value="<?php echo esc_attr(basename($story_image)); ?>" 
                       class="widefat" 
                       readonly="readonly" 
                       style="background-color: #f0f0f0;">
                <input type="hidden" name="learn_story_image_full" value="<?php echo esc_attr($story_image); ?>">
                <button type="button" class="upload-image-button button">Upload Image</button>
            </div>
            <img src="<?php echo esc_url($story_image); ?>" class="image-preview <?php echo empty($story_image) ? 'hidden' : ''; ?>">
        </div>
    </p>
    <p>
        <label for="learn_difference_image">The Difference Image:</label><br>
        <div class="image-upload-wrap">
            <div>
                <input type="text" id="learn_difference_image" name="learn_difference_image" 
                       value="<?php echo esc_attr(basename($difference_image)); ?>" 
                       class="widefat" 
                       readonly="readonly" 
                       style="background-color: #f0f0f0;">
                <input type="hidden" name="learn_difference_image_full" value="<?php echo esc_attr($difference_image); ?>">
                <button type="button" class="upload-image-button button">Upload Image</button>
            </div>
            <img src="<?php echo esc_url($difference_image); ?>" class="image-preview <?php echo empty($difference_image) ? 'hidden' : ''; ?>">
        </div>
    </p>
    <p>
        <label for="learn_impact_image">Our Impact Image:</label><br>
        <div class="image-upload-wrap">
            <div>
                <input type="text" id="learn_impact_image" name="learn_impact_image" 
                       value="<?php echo esc_attr(basename($impact_image)); ?>" 
                       class="widefat" 
                       readonly="readonly" 
                       style="background-color: #f0f0f0;">
                <input type="hidden" name="learn_impact_image_full" value="<?php echo esc_attr($impact_image); ?>">
                <button type="button" class="upload-image-button button">Upload Image</button>
            </div>
            <img src="<?php echo esc_url($impact_image); ?>" class="image-preview <?php echo empty($impact_image) ? 'hidden' : ''; ?>">
        </div>
    </p>

    <script>
    jQuery(document).ready(function($) {
        $('.upload-image-button').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var container = button.closest('.image-upload-wrap');
            var preview = container.find('.image-preview');
            
            var image = wp.media({
                title: 'Select or Upload Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            }).open()
            .on('select', function() {
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.get('url');
                var filename = image_url.split('/').pop();
                
                container.find('input[type="text"]').val(filename);
                container.find('input[type="hidden"]').val(image_url);
                preview.attr('src', image_url).removeClass('hidden');
            });
        });
    });
    </script>
    <?php
}

// Update save function to use the full URL from hidden fields
function save_learn_page_meta_box($post_id)
{
    // Check if nonce is set
    if (!isset($_POST['learn_page_meta_box_nonce'])) {
        return;
    }

    // Verify nonce
    if (!wp_verify_nonce($_POST['learn_page_meta_box_nonce'], 'learn_page_meta_box')) {
        return;
    }

    // Save the full image URLs from hidden fields
    if (isset($_POST['learn_story_image_full'])) {
        update_post_meta($post_id, '_learn_story_image', sanitize_text_field($_POST['learn_story_image_full']));
    }
    if (isset($_POST['learn_difference_image_full'])) {
        update_post_meta($post_id, '_learn_difference_image', sanitize_text_field($_POST['learn_difference_image_full']));
    }
    if (isset($_POST['learn_impact_image_full'])) {
        update_post_meta($post_id, '_learn_impact_image', sanitize_text_field($_POST['learn_impact_image_full']));
    }
}
add_action('save_post', 'save_learn_page_meta_box');


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

add_filter('pings_open', '__return_false', 20, 2);

// Replace the simple comments_open filter with a more specific one
remove_filter('comments_open', '__return_false', 20);

// Add new filter that checks if it's a product
add_filter('comments_open', 'custom_product_comments_open', 20, 2);
function custom_product_comments_open($open, $post_id) {
    // Allow comments if it's a product
    if (get_post_type($post_id) === 'product') {
        return true;
    }
    // Disable comments for all other post types
    return false;
}

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
function add_template_column($columns)
{
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
function populate_template_column($column_name, $post_id)
{
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
function make_template_column_sortable($columns)
{
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

/* -------------- Remove Downloads from My Account Menu -------------- */
function custom_my_account_menu_items($items)
{
    unset($items['downloads']);
    return $items;
}
add_filter('woocommerce_account_menu_items', 'custom_my_account_menu_items');

/* -------------- Register sidebar for WooCommerce Ajax Product Filter -------------- */

function register_woof_sidebar()
{
    register_sidebar(array(
        'name'          => 'WOOF Sidebar',
        'id'            => 'woof-sidebar',
        'description'   => 'Widget area for WooCommerce Ajax Product Filter',
        'before_widget' => '<div class="woof-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ));
}
// add_action('widgets_init', 'register_woof_sidebar');

function enqueue_contact_form_scripts() {

    wp_enqueue_script(
        'contact-form', 
        get_template_directory_uri() . '/assets/js/contact-form.js', 
        array(), 
        '1.0.0', 
        true
    );

    wp_localize_script(
        'contact-form',
        'contact_form_vars',
        array(
            'ajaxurl' => admin_url('admin-ajax.php')
        )
    );
 
}
add_action('wp_enqueue_scripts', 'enqueue_contact_form_scripts');

function enqueue_newsletter_signup_scripts() {

    wp_enqueue_script(
        'newsletter-signup', 
        get_template_directory_uri() . '/assets/js/newsletter-signup.js', 
        array(), 
        '1.0.0', 
        true
    );

    wp_localize_script(
        'newsletter-signup',
        'newsletter_signup_vars',
        array(
            'ajaxurl' => admin_url('admin-ajax.php')
        )
    );

}
add_action('wp_enqueue_scripts', 'enqueue_newsletter_signup_scripts');

// Add favicon links to head
function live_complete_add_favicon() {
    ?>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri() . '/assets/image/favicon/apple-touch-icon.png'; ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri() . '/assets/image/favicon/favicon-32x32.png'; ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri() . '/assets/image/favicon/favicon-16x16.png'; ?>">
    <link rel="manifest" href="<?php echo get_template_directory_uri() . '/assets/image/favicon/site.webmanifest'; ?>">
    <?php
}
add_action('wp_head', 'live_complete_add_favicon');
