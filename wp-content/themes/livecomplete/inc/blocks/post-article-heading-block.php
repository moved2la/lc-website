<?php
function register_post_article_heading_block()
{
    // Register the block using register_block_type
    register_block_type('theme-blocks/post-article-heading', array(
        'render_callback' => 'render_post_article_heading_block',
        'attributes'      => array(
            // Add any custom attributes here if needed
            'className'   => array(
                'type'    => 'string',
                'default' => '',
            ),
        ),
    ));
}
add_action('init', 'register_post_article_heading_block');

// function render_post_article_heading_block($attributes)
// {
//     // Load and return the template part
//     ob_start();
//     include(get_template_directory() . '/template-parts/blocks/post-article-heading.php');
//     return ob_get_clean();
// }

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
