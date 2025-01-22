<?php
function register_post_article_heading_block()
{
    // Register the block using register_block_type
    register_block_type(get_theme_file_path('inc/blocks/post-article-heading'), array(
        'render_callback' => 'render_post_article_heading_block',
        'attributes'      => array(
            // Add any custom attributes here if needed
            'className'   => array(
                'type'    => 'string',
                'default' => '',
            ),
        ),
        'category'        => 'livecomplete',
    ));
}
add_action('init', 'register_post_article_heading_block');


function render_post_article_heading_block($attributes)
{
    $intro_text = isset($attributes['introText']) ? $attributes['introText'] : 'Introduction';

    ob_start();
    ?>
    <div class="post-article-heading">
        <?php echo esc_html($intro_text); ?>
    </div>
    <?php
    return ob_get_clean();
}
