<?php
function register_post_article_paragraph_block() {
    register_block_type(get_theme_file_path('inc/blocks/post-article-paragraph'), array(
        'render_callback' => 'render_post_article_paragraph_block',
        'attributes'      => array(
            'className'   => array(
                'type'    => 'string',
                'default' => '',
            ),
            'content'     => array(
                'type'    => 'string',
                'default' => '',
            ),
        ),
        'category'        => 'livecomplete',
    ));
}
add_action('init', 'register_post_article_paragraph_block');

function render_post_article_paragraph_block($attributes) {
    $content = isset($attributes['content']) ? $attributes['content'] : '';
    $className = 'post-article-paragraph';
    if (!empty($attributes['className'])) {
        $className .= ' ' . $attributes['className'];
    }
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($className); ?>">
        <p><?php echo wp_kses_post($content); ?></p>
    </div>
    <?php
    return ob_get_clean();
} 