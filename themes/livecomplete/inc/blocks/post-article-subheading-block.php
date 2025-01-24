<?php
function register_post_article_subheading_block()
{
    // Register the block using register_block_type
    register_block_type(get_theme_file_path('inc/blocks/post-article-subheading'), array(
        'render_callback' => 'render_post_article_subheading_block',
        'attributes'      => array(
            'subheadingText' => array(
                'type'    => 'string',
                'default' => 'Conclusion',
            ),
            'className'   => array(
                'type'    => 'string',
                'default' => '',
            ),
        ),
        'category'        => 'livecomplete',
    ));
}
add_action('init', 'register_post_article_subheading_block');


function render_post_article_subheading_block($attributes) {
    $subheading_text = isset($attributes['subheadingText']) ? $attributes['subheadingText'] : 'Subheading';

    ob_start();
?>
    <div class="post-article-subheading">
        <?php echo esc_html($subheading_text); ?>
    </div>
<?php
    return ob_get_clean();
}
