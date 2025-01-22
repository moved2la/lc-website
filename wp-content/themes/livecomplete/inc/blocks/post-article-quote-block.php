<?php
function register_post_article_quote_block() {
    register_block_type(get_theme_file_path('inc/blocks/post-article-quote'), array(
        'render_callback' => 'render_post_article_quote_block',
        'attributes'      => array(
            'className'   => array(
                'type'    => 'string',
                'default' => '',
            ),
            'quoteText'   => array(
                'type'    => 'string',
                'default' => '',
            ),
        ),
        'category'        => 'livecomplete',
    ));
}
add_action('init', 'register_post_article_quote_block');

function render_post_article_quote_block($attributes) {
    // Ensure we have content, even if empty
    $content = isset($attributes['quoteText']) ? $attributes['quoteText'] : '';
    $className = 'post-article-quote';
    if (!empty($attributes['className'])) {
        $className .= ' ' . $attributes['className'];
    }
    
    // Debug output to error log
    error_log('Quote content: ' . print_r($content, true));
    error_log('Attributes: ' . print_r($attributes, true));
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($className); ?>">
        <div class="quote-figure">
            <div class="divider"></div>
            <div class="quote-text">
                <?php echo esc_html($content); ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
} 