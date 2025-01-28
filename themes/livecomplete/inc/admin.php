<?php

/**
* Functions which modify the WP dashboard
*
* @package live-complete
*/


// Remove Yoast SEO menu for non-admin users
function hide_yoast_for_non_admins()
{
if (!current_user_can('administrator')) {
remove_menu_page('wpseo_workouts');
}
}
add_action('admin_menu', 'hide_yoast_for_non_admins', 999);

/**
 * Add multiple authors functionality
 */
function add_multiple_authors_meta_box() {
    add_meta_box(
        'multiple_authors_meta_box',
        'Additional Authors',
        'render_multiple_authors_meta_box',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_multiple_authors_meta_box');

function render_multiple_authors_meta_box($post) {
    wp_nonce_field('multiple_authors_meta_box', 'multiple_authors_meta_box_nonce');
    
    $additional_authors = get_post_meta($post->ID, '_additional_authors', true);
    $users = get_users(['role__in' => ['author', 'editor',]]);
    
    echo '<select name="additional_authors[]" multiple="multiple" style="width: 100%; max-width: 100%;">';
    foreach ($users as $user) {
        // Skip if this user is the primary author
        if ($user->ID == $post->post_author) {
            continue;
        }
        
        $selected = is_array($additional_authors) && in_array($user->ID, $additional_authors) ? 'selected="selected"' : '';
        echo sprintf(
            '<option value="%d" %s>%s</option>',
            $user->ID,
            $selected,
            esc_html($user->display_name)
        );
    }
    echo '</select>';
    echo '<p class="description">Hold Ctrl/Cmd to select multiple authors</p>';
}

function save_multiple_authors_meta_box($post_id) {
    if (!isset($_POST['multiple_authors_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['multiple_authors_meta_box_nonce'], 'multiple_authors_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $additional_authors = isset($_POST['additional_authors']) ? array_map('intval', $_POST['additional_authors']) : [];
    update_post_meta($post_id, '_additional_authors', $additional_authors);
}
add_action('save_post', 'save_multiple_authors_meta_box');

/**
 * Get all authors for a post (including additional authors)
 * 
 * @param int|WP_Post|null $post Post ID or post object. Defaults to global $post.
 * @return array Array of WP_User objects
 */
function get_post_authors($post = null) {
    $post = get_post($post);
    if (!$post) {
        return [];
    }

    $authors = [];
    
    // Add primary author
    $primary_author = get_user_by('id', $post->post_author);
    if ($primary_author) {
        $authors[] = $primary_author;
    }
    
    // Add additional authors
    $additional_authors = get_post_meta($post->ID, '_additional_authors', true);
    if (is_array($additional_authors)) {
        foreach ($additional_authors as $author_id) {
            $author = get_user_by('id', $author_id);
            if ($author) {
                $authors[] = $author;
            }
        }
    }
    
    return array_unique($authors, SORT_REGULAR);
}


