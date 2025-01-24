<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package live-complete
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array('live-complete-blogwrap') ); ?>>

 	 <?php
    /**
    * Hook - live_complete_posts_blog_media.
    *
    * @hooked live_complete_posts_formats_thumbnail - 10
    */
    do_action( 'live_complete_posts_blog_media' );
    ?>
    <div class="post">
               
		<?php
        /**
        * Hook - livecomplete_site_content_type.
        *
		* @hooked site_loop_heading - 10
        * @hooked render_meta_list	- 20
		* @hooked site_content_type - 30
        */
		
		$meta = array();
		
		if ( is_singular() && !is_page() ) :
			
			if( live_complete_get_option('signle_meta_hide') != true ){
				
				$meta = array( 'author', 'date', 'category', 'comments' );
			}
			$meta  	 = apply_filters( 'live_complete_single_post_meta', $meta );
			
		else :
			if( live_complete_get_option('blog_meta_hide') != true ){
				
				$meta = array( 'author', 'date', 'category', 'comments' );
			}
			$meta  	 = apply_filters( 'live_complete_blog_meta', $meta );
		 endif;
	
		
		 do_action( 'live_complete_site_content_type', $meta  );
        ?>
      
       
    </div>
    
</article><!-- #post-<?php the_ID(); ?> -->
