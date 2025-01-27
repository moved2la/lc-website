<?php
function register_post_article_subheading_block()
{
    // Register the block using register_block_type
    register_block_type('livecomplete/post-article-subheading', array(
        'render_callback' => 'render_post_article_subheading_block',
        'attributes'      => array(
            'subheadingtext' => array(
                'type'    => 'string',
                'default' => 'Conclusion',
            ),
            'classname'   => array(
                'type'    => 'string',
                'default' => '',
            ),
        ),
        'category'        => 'livecomplete',
    ));
}
add_action('init', 'register_post_article_subheading_block');


function render_post_article_subheading_block($attributes) {
    $subheading_text = isset($attributes['subheadingtext']) ? $attributes['subheadingtext'] : 'Subheading';

    ob_start();
?>
    <div class="post-article-subheading">
        <?php echo esc_html($subheading_text); ?>
    </div>
<?php
    return ob_get_clean();
}
