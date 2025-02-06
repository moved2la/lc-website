<?php
/**
 * Default theme options.
 *
 * @package live-complete
 */

if ( ! function_exists( 'live_complete_get_default_theme_options' ) ) :

	/**
	 * Get default theme options
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
	function live_complete_get_default_theme_options() {

		$defaults = array();
		
		
		/*Posts Layout*/
		$defaults['blog_layout']     				= 'content-sidebar';
		$defaults['single_post_layout']     		= 'no-sidebar';
		
		$defaults['blog_loop_content_type']     	= 'excerpt';
		
		$defaults['blog_meta_hide']     			= false;
		$defaults['single_meta_hide']     			= false;
		
		/*Posts Layout*/
		$defaults['page_layout']     				= 'content-sidebar';
		
		/*layout*/
		$defaults['copyright_text']					= esc_html__( 'Copyright All right reserved', 'live-complete' );
		$defaults['read_more_text']					= esc_html__( 'Continue Reading', 'live-complete' );
		$defaults['index_hide_thumb']     			= false;
		
		
		/*Footer Social Icons*/
		$defaults['__fb_link']     				= '';
		$defaults['__ig_link']     				= '';
		$defaults['__x_link']     				= '';
		$defaults['__li_link']     				= '';
		$defaults['__yt_link']     				= '';
		


		$defaults['__primary_color']     			= '#6c757d';
		$defaults['__secondary_color']     			= '#000';
		
		$defaults['__menu_secondary_color']     	= '#6c757d';
		$defaults['__menu_primary_color']     		= '#000';
		
		/*layout*/
        $defaults['__topbar_message']				= '';
	

		// Pass through filter.
		$defaults = apply_filters( 'live_complete_filter_default_theme_options', $defaults );

		return $defaults;

	}

endif;
