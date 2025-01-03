<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package live-complete
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function live_complete_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'live_complete_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function live_complete_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'live_complete_pingback_header' );

if ( ! function_exists( 'live_complete_allowed_tags' ) ) :
	/**
	 * @see diet_shop_alowed_tags().
	 */
function live_complete_allowed_tags() {
	
	
	$wp_post_allow_tag = wp_kses_allowed_html( 'post' );
	
	$allowed_tags = array(
		'a' => array(
			'class' => array(),
			'href'  => array(),
			'rel'   => array(),
			'title' => array(),
			'id'	=> array(),
			'target'=> array(),
		),
		'abbr' => array(
			'title' => array(),
		),
		'b' => array(),
		'blockquote' => array(
			'cite'  => array(),
		),
		'cite' => array(
			'title' => array(),
		),
		'code' => array(),
		'del' => array(
			'datetime' => array(),
			'title' => array(),
		),
		'dd' => array(),
		'div' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
			'id' => array(),
		),
		'dl' => array( 
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'dt' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'em' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'h1' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
			'id' => array(),
		
		),
		'h2' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		
		),
		'h3' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'h4' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'h5' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'h6' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'i' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'img' => array(
			'alt'    => array(),
			'class'  => array(),
			'height' => array(),
			'src'    => array(),
			'width'  => array(),
		),
		'li' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'i' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'ol' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'p' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'q' => array(
			'cite' => array(),
			'title' => array(),
		),
		'span' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'strike' => array(),
		'strong' => array(),
		'ul' => array(
			'class' => array(),
			'style' => array(),
			'id' => array(),
		),
		'iframe' => array(
			'src'             => array(),
			'height'          => array(),
			'width'           => array(),
			'frameborder'     => array(),
			'allowfullscreen' => array(),
		),
		'time' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
			'datetime' => array(),
			'content' => array(),
		),
		'main' => array(
			'class' => array(),
			'id' => array(),
			'style' => array(),
			
		),
	);

	
	$tags = array_merge( $wp_post_allow_tag, $allowed_tags );

	return apply_filters( 'live_complete_allowed_tags', $tags );
	
}
endif;



if ( ! function_exists( 'live_complete_walker_comment' ) ) : 
	/**
	 * Implement Custom Comment template.
	 *
	 * @since 1.0.0
	 *
	 * @param $comment, $args, $depth
	 * @return $html
	 */
	  
	function live_complete_walker_comment($comment, $args, $depth) {
		if ( 'div' === $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}
		?>
<li <?php comment_class( empty( $args['has_children'] ) ? 'comment shift' : 'comment' ) ?> id="comment-<?php comment_ID() ?>">
  <div class="single-comment clearfix">
    <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, 80,'','', array('class' => 'float-left') ); ?>
    <div class="comment-details">
      <div class="comment-heading">
        <h5 class="float-left"><?php echo get_comment_author_link();?></h5>
        <span class="float-left comment-date">
			<?php
			/* translators: 1: date, 2: time */
			printf( esc_html__('%1$s at %2$s', 'live-complete' ), esc_html( get_comment_date() ),  esc_html( get_comment_time()) ); 
			?>
        </span>
        <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        <div class="clearfix"></div>
      </div>
      <div class="comment-text">
        <?php comment_text(); ?>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
</li>


       <?php
	}
	
	
endif;



class live_complete_navwalker extends Walker_Nav_Menu {
		
		/**
		 * Menu Fallback
		 * =============
		 * If this function is assigned to the wp_nav_menu's fallback_cb variable
		 * and a menu has not been assigned to the theme location in the WordPress
		 * menu manager the function with display nothing to a non-logged in user,
		 * and will add a link to the WordPress menu manager if logged in as an admin.
		 *
		 * @param array $args passed from the wp_nav_menu function.
		 */
		public static function fallback( $args ) {
			
			wp_nav_menu( array(
				'depth'             => 1,
				'menu_class'  		=> 'menu rd-navbar-nav',
				'container'			=>'ul',
				'theme_location'    => 'fallback_menu'
			) );
			
		}
	
}

if( !function_exists('live_complete_elementor_editor_simplify') ){
	
	function live_complete_elementor_editor_simplify(){
		
		add_action( 'wp_head', function () {
				echo '<style type="text/css">
				#elementor-panel-category-pro-elements,
				#elementor-panel-category-theme-elements,
				#elementor-panel-category-woocommerce-elements,
				#elementor-panel-get-pro-elements{
					display:none!important;	
				}
				</style>';
			}  );
		
	}
	add_action( 'elementor/editor/init', 'live_complete_elementor_editor_simplify');

}

/**
 * Add custom HTML block at the bottom of pages
 */
function live_complete_page_bottom_html() {
    // Only show on pages, not posts or other content types
    // if (!is_page()) {
    //     return;
    // }

    // Don't show on WooCommerce pages
    // if (function_exists('is_woocommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page())) {
    //     return;
    // }

    get_template_part('template-parts/blocks/page', 'bottom');
}

// Add custom content to WooCommerce category header
function add_category_header_content()
{
    if (is_product_category() || is_shop()) {
        $category = get_queried_object();
        get_template_part('template-parts/woocommerce/category', 'header', array(
            'category' => $category
        ));
    }
}
// Change the hook to woocommerce_before_main_content
remove_action('woocommerce_archive_description', 'add_category_header_content', 10);
add_action('woocommerce_before_main_content', 'add_category_header_content', 5);

// Add custom fields to category add page
function add_category_bottom_content_field() {
    // Get list of template parts
    $template_files = get_woocommerce_template_files();
    ?>
    <div class="form-field">
        <label for="category_template_part"><?php _e('Template Part', 'live-complete'); ?></label>
        <select id="category_template_part" name="category_template_part">
            <option value=""><?php _e('None', 'live-complete'); ?></option>
            <?php foreach ($template_files as $file) : ?>
                <option value="<?php echo esc_attr($file); ?>"><?php echo esc_html($file); ?></option>
            <?php endforeach; ?>t
        </select>
        <p class="description"><?php _e('Select a template part from woocommerce folder to display', 'live-complete'); ?></p>
    </div>

    <div class="form-field">
        <label for="category_bottom_content"><?php _e('Custom Bottom Content', 'live-complete'); ?></label>
        <textarea id="category_bottom_content" name="category_bottom_content" rows="5"></textarea>
        <p class="description"><?php _e('Or enter custom content to appear at the bottom of the category page', 'live-complete'); ?></p>
    </div>
    <?php
}

// Add custom fields to category edit page
function edit_category_bottom_content_field($term) {
    $template_part = get_term_meta($term->term_id, 'category_template_part', true);
    $bottom_content = get_term_meta($term->term_id, 'category_bottom_content', true);
    $template_files = get_woocommerce_template_files();
    ?>
    <tr class="form-field">
        <th scope="row"><label for="category_template_part"><?php _e('Template Part', 'live-complete'); ?></label></th>
        <td>
            <select id="category_template_part" name="category_template_part">
                <option value=""><?php _e('None', 'live-complete'); ?></option>
                <?php foreach ($template_files as $file) : ?>
                    <option value="<?php echo esc_attr($file); ?>" <?php selected($template_part, $file); ?>><?php echo esc_html($file); ?></option>
                <?php endforeach; ?>
            </select>
            <p class="description"><?php _e('Select a template part from woocommerce folder to display', 'live-complete'); ?></p>
        </td>
    </tr>

    <tr class="form-field">
        <th scope="row"><label for="category_bottom_content"><?php _e('Custom Bottom Content', 'live-complete'); ?></label></th>
        <td>
            <textarea id="category_bottom_content" name="category_bottom_content" rows="5"><?php echo esc_textarea($bottom_content); ?></textarea>
            <p class="description"><?php _e('Or enter custom content to appear at the bottom of the category page', 'live-complete'); ?></p>
        </td>
    </tr>
    <?php
}

// Helper function to get template files
function get_woocommerce_template_files() {
    $template_path = get_template_directory() . '/template-parts/woocommerce';
    $files = [];
    
    if (is_dir($template_path)) {
        $dir_contents = scandir($template_path);
        foreach ($dir_contents as $file) {
            if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $files[] = pathinfo($file, PATHINFO_FILENAME);
            }
        }
    }
    
    return $files;
}

// Save the custom fields
function save_category_bottom_content($term_id) {
    if (isset($_POST['category_template_part'])) {
        update_term_meta(
            $term_id,
            'category_template_part',
            sanitize_text_field($_POST['category_template_part'])
        );
    }

    if (isset($_POST['category_bottom_content'])) {
        update_term_meta(
            $term_id,
            'category_bottom_content',
            wp_kses_post($_POST['category_bottom_content'])
        );
    }
}

// Modified display function to handle both template parts and custom content
function add_category_bottom_content() {
    if (is_product_category()) {
        $category = get_queried_object();
        $template_part = get_term_meta($category->term_id, 'category_template_part', true);
        $bottom_content = get_term_meta($category->term_id, 'category_bottom_content', true);

        // First try to load template part if selected
        if (!empty($template_part)) {
            get_template_part('template-parts/woocommerce/' . $template_part);
        }
        // Then display custom content if any
        elseif (!empty($bottom_content)) {
            echo '<div class="category-bottom-content">';
            echo wp_kses_post($bottom_content);
            echo '</div>';
        }
    }
}

add_action('product_cat_add_form_fields', 'add_category_bottom_content_field');
add_action('product_cat_edit_form_fields', 'edit_category_bottom_content_field');
add_action('edited_product_cat', 'save_category_bottom_content');
add_action('created_product_cat', 'save_category_bottom_content');
// Add to WooCommerce category pages, after the main page content but before signup section
add_action('live_complete_container_wrap_end', 'add_category_bottom_content', 999);

// Remove existing action if it exists
remove_action('live_complete_container_wrap_end', 'live_complete_page_bottom_html', 5);

// Add the function to run after container wrap end
function live_complete_add_bottom_block()
{
    live_complete_page_bottom_html();
}
add_action('live_complete_container_wrap_end', 'live_complete_add_bottom_block', 999);


/* ---------------- Product Page ---------------- */

// Remove meta from its default position
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
// Add meta before add to cart
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 25);


// Add custom attribute display
function custom_product_attributes_display()
{
    global $product;

    // Get attributes based on product type
    if ($product->is_type('variable')) {
        $attributes = $product->get_variation_attributes();
        $all_attributes = $product->get_attributes();
    } else {
        $attributes = $product->get_attributes();
        $all_attributes = $attributes;
    }

    if (!empty($all_attributes)) {
        echo '<div class="custom-attributes-wrapper">';

        foreach ($all_attributes as $attribute_name => $attribute_obj) {
            // Get the attribute label
            $attribute_label = wc_attribute_label($attribute_name);

            // Get all possible terms for this attribute
            $taxonomy = str_replace('pa_', '', $attribute_name);
            $terms = get_terms([
                'taxonomy' => 'pa_' . $taxonomy,
                'hide_empty' => false
            ]);

            if (!empty($terms) && !is_wp_error($terms)) {
                echo '<div class="attribute-group">';
                echo '<h4>' . esc_html($attribute_label) . '</h4>';
                echo '<div class="attribute-buttons">';

                // Get the product's terms for this attribute
                $product_terms = wc_get_product_terms($product->get_id(), 'pa_' . $taxonomy, array('fields' => 'slugs'));

                foreach ($terms as $term) {
                    // Check if this term is assigned to the product
                    $is_active = in_array($term->slug, $product_terms);

                    // Set classes based on status
                    $button_classes = ['attribute-btn'];
                    if (!$is_active) {
                        $button_classes[] = 'disabled';
                    }

                    echo sprintf(
                        '<button type="button" class="%s" data-attribute="%s" data-value="%s" %s>%s</button>',
                        esc_attr(implode(' ', $button_classes)),
                        esc_attr('pa_' . $taxonomy),
                        esc_attr($term->slug),
                        $is_active ? '' : 'disabled',
                        esc_html($term->name)
                    );
                }

                echo '</div></div>';
            }
        }

        echo '</div>';
    }
}

// Add the custom display before add to cart form
add_action('woocommerce_before_add_to_cart_form', 'custom_product_attributes_display');

// Add the custom display after add to cart button
add_action('woocommerce_after_add_to_cart_form', 'live_complete_shipping_returns_info');
function live_complete_shipping_returns_info() {
    get_template_part('template-parts/blocks/pdp-ship-return');
}



function pdp_ship_return_customizer_settings($wp_customize)
{
    // Add new section
    $wp_customize->add_section('pdp_ship_return_section', array(
        'title' => 'Product Page',
        'panel' => 'woocommerce', 
    ));

    // Shipping Content
    $wp_customize->add_setting('pdp_shipping_content', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('pdp_shipping_content', array(
        'label' => 'Shipping Content',
        'section' => 'pdp_ship_return_section',
        'type' => 'textarea',
    ));

    // Returns Content
    $wp_customize->add_setting('pdp_returns_content', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('pdp_returns_content', array(
        'label' => 'Returns Content',
        'section' => 'pdp_ship_return_section',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'pdp_ship_return_customizer_settings');

/* ---------------- Product Page ---------------- */