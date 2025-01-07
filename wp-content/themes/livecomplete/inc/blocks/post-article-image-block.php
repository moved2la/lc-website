<?php
function register_post_article_image_block() {
    register_block_type('theme-blocks/post-article-image', array(
        'render_callback' => 'render_post_article_image_block',
        'attributes'      => array(
            'className' => array(
                'type'    => 'string',
                'default' => '',
            ),
            'imageUrl'  => array(
                'type'    => 'string',
                'default' => '',
            ),
            'imageId'   => array(
                'type'    => 'number',
            ),
            'imageAlt'  => array(
                'type'    => 'string',
                'default' => '',
            ),
            'caption'   => array(
                'type'    => 'string',
                'default' => '',
            ),
        ),
    ));
}
add_action('init', 'register_post_article_image_block');

function render_post_article_image_block($attributes) {
    $className = 'post-article-image';
    if (!empty($attributes['className'])) {
        $className .= ' ' . $attributes['className'];
    }

    ob_start();
    ?>
    <div class="<?php echo esc_attr($className); ?>">
        <?php if (!empty($attributes['imageUrl'])) : ?>
            <div class="image-container">
                <img 
                    src="<?php echo esc_url($attributes['imageUrl']); ?>" 
                    alt="<?php echo esc_attr($attributes['imageAlt']); ?>"
                />
            </div>
        <?php endif; ?>
        
        <?php if (!empty($attributes['caption'])) : ?>
            <div class="caption-figure">
                <div class="image-caption-rectangle"></div>
                <div class="image-caption"><?php echo wp_kses_post($attributes['caption']); ?></div>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
} 