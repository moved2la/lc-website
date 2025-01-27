<?php
function register_post_article_image_block() {
    register_block_type('livecomplete/post-article-image', array(
        'render_callback' => 'render_post_article_image_block',
        'attributes'      => array(
            'classname' => array(
                'type'    => 'string',
                'default' => '',
            ),
            'imageurl'  => array(
                'type'    => 'string',
                'default' => '',
            ),
            'imageid'   => array(
                'type'    => 'number',
            ),
            'imagealt'  => array(
                'type'    => 'string',
                'default' => '',
            ),
            'caption'   => array(
                'type'    => 'string',
                'default' => '',
            ),
        ),
        'category'        => 'livecomplete',
    ));
}
add_action('init', 'register_post_article_image_block');

function render_post_article_image_block($attributes) {
    $className = 'post-article-image';
    if (!empty($attributes['classname'])) {
        $className .= ' ' . $attributes['classname'];
    }

    ob_start();
    ?>
    <div class="<?php echo esc_attr($className); ?>">
        <?php if (!empty($attributes['imageurl'])) : ?>
            <div class="image-container">
                <img 
                    src="<?php echo esc_url($attributes['imageurl']); ?>" 
                    alt="<?php echo esc_attr($attributes['imagealt']); ?>"
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