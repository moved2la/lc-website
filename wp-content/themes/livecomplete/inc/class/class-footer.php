<?php
/**
 * The Site Theme Header Class 
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package live-complete
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class live_complete_Footer_Layout{
	/**
	 * Function that is run after instantiation.
	 *
	 * @return void
	 */
	public function __construct() {
		
		add_action('live_complete_site_footer', array( $this, 'site_footer_container_before' ), 5);
		add_action('live_complete_site_footer', array( $this, 'site_footer_widgets' ), 10);
		add_action('live_complete_site_footer', array( $this, 'site_footer_info' ), 80);
		add_action('live_complete_site_footer', array( $this, 'site_footer_container_after' ), 998);
		
	}
	
	/**
	* diet_shop foter conteinr before
	*
	* @return $html
	*/
	public function site_footer_container_before (){
		
		$html = ' <footer id="colophon" class="site-footer">';
						
		$html = apply_filters( 'live_complete_footer_container_before_filter',$html);		
				
		echo wp_kses( $html, $this->alowed_tags() );
		
						
	}
	
	/**
	* Footer Container before
	*
	* @return $html
	*/
	function site_footer_widgets(){
		if ( is_active_sidebar( 'footer-1' ) ) { ?>
         <div class="footer_widget_wrap">
         <div class="container">
            <div class="row live-complete-flex">
                <?php dynamic_sidebar( 'footer-1' ); ?>
            </div>
         </div>  
         </div>
        <?php }
	}
	
	
	/**
	* diet_shop foter conteinr after
	*
	* @return $html
	*/
	public function site_footer_info (){
		$text ='';
		$html = '<div class="container site_info"><span class="back-to-top" id="backToTop"><i class="icofont-rounded-up parallax"></i></span>
					<div class="row">';
		

			$html .= '<div class="col-12 col-md-12">';
			
			if( get_theme_mod('copyright_text') != '' ) 
			{
				$text .= esc_html(  get_theme_mod('copyright_text') );
			}else
			{
				/* translators: 1: Current Year, 2: Blog Name  */
				$text .= sprintf( esc_html__( 'Copyright &copy; %1$s %2$s. All Right Reserved.', 'live-complete' ), date_i18n( _x( 'Y', 'copyright date format', 'live-complete' ) ), esc_html( get_bloginfo( 'name' ) ) );

			
				
			}

			
			$html  .= apply_filters( 'live_complete_footer_copywrite_filter', $text );
				
			$html .= '</div>';
			
			


		$html .= '<div class="col-12 col-md-12">';
			
			$html .='<ul class="social-list ">';
			
			if( live_complete_get_option('__fb_pro_link') != "" ): 
			$html .='<li class="social-item-facebook"><a href="'.esc_url( live_complete_get_option('__fb_pro_link') ).'" target="_blank" rel="nofollow"><i class="icofont-facebook"></i></a></li>';				
			endif;
			
			 if( live_complete_get_option('__tw_pro_link') != "" ): 
			$html .='<li class="social-item-twitter"><a href="'.esc_url( live_complete_get_option('__tw_pro_link') ).'" target="_blank" rel="nofollow"><i class="icofont-twitter"></i></a></li>';
			endif;
			if( live_complete_get_option('__you_pro_link') != "" ): 
			$html .='<li class="social-item-youtube"><a href="'.esc_url( live_complete_get_option('__you_pro_link') ).'" target="_blank" rel="nofollow"><i class="icofont-youtube"></i></a></li>';
			 endif;
					
				$html .='	</ul>';
			
			$html .= '</div>';	
			
		$html .= '	</div>
		  		</div>';
		
		
				
		echo wp_kses( $html, $this->alowed_tags() );
	
	}
	
	/**
	* diet_shop foter conteinr after
	*
	* @return $html
	*/
	public function site_footer_container_after (){
		
		$html = '</footer>';
						
		$html = apply_filters( 'live_complete_footer_container_after_filter',$html);		
				
		echo wp_kses( $html, $this->alowed_tags() );
	
	}
	
	
	private function alowed_tags(){
		
		if( function_exists('live_complete_alowed_tags') ){ 
			return live_complete_alowed_tags(); 
		}else{
			return array();	
		}
		
	}
}

$live_complete_footer_layout = new live_complete_Footer_Layout();