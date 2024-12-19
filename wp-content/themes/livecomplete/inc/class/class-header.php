<?php

/**
 * The Site Theme Header Class 
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package live-complete
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class live_complete_Header_Layout
{
    /**
     * Function that is run after instantiation.
     *
     * @return void
     */
    public function __construct()
    {

        add_action('live_complete_header_layout_1_branding', array($this, 'get_site_branding'), 10);

        add_action('live_complete_header_layout_1_navigation', array($this, 'get_site_navigation'), 10);



        add_action('live_complete_site_header', array($this, 'site_skip_to_content'), 5);
        add_action('live_complete_site_header', array($this, 'site_top_bar'), 10);
        // add_action('live_complete_site_header', array( $this, 'get_site_search_form' ), 20 );

        add_action('live_complete_site_header', array($this, 'site_header_layout'), 30);

        add_action('live_complete_site_header', array($this, 'site_hero_sections'), 999);

        add_action('live_complete_site_header', array($this, 'get_site_breadcrumb'), 9999);
    }

    /**
     * Container before
     *
     * @return $html
     */
    function site_skip_to_content()
    {

        echo '<a class="skip-link screen-reader-text" href="#content">' . esc_html__('Skip to content', 'live-complete') . '</a>';
    }
    /**
     * Container before
     *
     * @return $html
     */
    function site_top_bar()
    {
        if (empty(live_complete_get_option('__topbar_phone')) && empty(live_complete_get_option('__topbar_address')) && empty(live_complete_get_option('__topbar_email'))) return false;
        echo '<div id="topbar">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-right">';
?>
        <ul class="flat-support">
            <?php if (!empty(live_complete_get_option('__topbar_address'))): ?>
                <li><i class="icofont-location-pin"></i> <?php echo esc_html(live_complete_get_option('__topbar_address')); ?> </li>
            <?php endif; ?>
            <?php if (!empty(live_complete_get_option('__topbar_email'))): ?>
                <li><i class="icofont-email"></i> <?php echo esc_html(live_complete_get_option('__topbar_email')); ?> </li>
            <?php endif; ?>
            <?php if (!empty(live_complete_get_option('__topbar_phone'))): ?>
                <li><i class="icofont-ui-cell-phone"></i> <?php echo esc_html(live_complete_get_option('__topbar_phone')); ?> </li>
            <?php endif; ?>
        </ul>

    <?php
        echo '</div>
				</div>
			</div>
		</div>';
    }
    /**
     * Container before
     *
     * @return $html
     */
    function site_header_layout()
    {

    ?>
        <header id="masthead" class="site-header">
            <div class="container">
                <div class="header-table">
                    <div class="table-cell branding-wrap">
                        <div class="block">
                            <?php do_action('live_complete_header_layout_1_branding'); ?>
                        </div>
                    </div>
                    <div class="table-cell">
                        <?php do_action('live_complete_header_layout_1_navigation'); ?>
                    </div>

                    <div class="header-search">
                        <form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url(home_url('/')); ?>">
                            <div class="search-input-wrap">
                                <input type="search" class="search-field"
                                    placeholder="<?php echo esc_attr_x('Search products...', 'placeholder', 'live-complete'); ?>"
                                    value="<?php echo get_search_query(); ?>"
                                    name="s" />
                                <button type="submit" class="search-submit">
                                    <img src="<?php echo get_template_directory_uri() . '/assets/image/search.svg'; ?>"></img>
                                </button>
                            </div>
                            <input type="hidden" name="post_type" value="product" />
                        </form>
                    </div>

                    <?php echo wp_kses($this->get_site_header_icon(), $this->allowed_tags()); ?>


                </div>
            </div>
        </header>
    <?php
    }


    /**
     * Get the Site logo
     *
     * @return HTML
     */
    public function get_site_branding()
    {

        $html = '<div class="logo-wrap">';

        if (function_exists('the_custom_logo') && has_custom_logo()) {
            $html .= get_custom_logo();
        }
        if (display_header_text() == true && !has_custom_logo()) {

            $html .= '<h3><a href="' . esc_url(home_url('/')) . '" rel="home" class="site-title">';
            $html .= get_bloginfo('name');
            $html .= '</a></h3>';
            $description = get_bloginfo('description', 'display');

            if ($description) :
                $html .=  '<div class="site-description">' . esc_html($description) . '</div>';
            endif;
        }


        $html .= '</div>';

        $html = apply_filters('get_site_branding_filter', $html);

        echo wp_kses($html, $this->allowed_tags());
    }

    /**
     * Get the Site Main Menu / Navigation
     *
     * @return HTML
     */
    public function get_site_navigation()
    {

    ?>
        <nav id="navbar">
            <button class="live-complete-navbar-close"><i class="icofont-ui-close"></i></button>

            <?php
            wp_nav_menu(array(
                'theme_location'    => 'menu-1',
                'depth'             => 3,
                'menu_class'          => 'live-complete-main-menu navigation-menu',
                'container'            => 'ul',
                //'fallback_cb'       => 'live_complete_navwalker::fallback',
            ));
            ?>

        </nav>
    <?php

    }
    /**
     * Get the Site Main Menu / Navigation
     *
     * @return HTML
     */
    public function get_site_header_icon()
    {
    ?>

        <?php if (class_exists('WooCommerce')) : ?>
            <div class="table-cell text-right last-item">

                <ul class="header-icon">
                    <li class="account-icon">
                        <a href="javascript:void(0)">
                            <img src="<?php echo get_template_directory_uri() . '/assets/image/account.svg'; ?>" alt="Account">
                        </a>
                    </li>
                    <li class="cart-icon">
                        <a href="<?php echo esc_url(wc_get_cart_url()); ?>">
                            <img src="<?php echo get_template_directory_uri() . '/assets/image/cart.svg'; ?>" alt="Cart">
                            <span class="quantity"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        </a>
                    </li>

                    <li>
                        <button onclick="window.location.href='<?php echo esc_url(home_url('/subscribe-and-save')); ?>'">
                            Subscribe & Save
                        </button>
                    </li>


                </ul>
            <?php else: ?>
                <div class="table-cell text-right last-item without-woocommmerce">
                <?php endif; ?>
                <button class="live-complete-rd-navbar-toggle" tabindex="0" autofocus="true"><i class="icofont-navigation-menu"></i></button>

                <div class="clearfix"></div>
                </div>
            <?php
        }
        /**
         * Get the Site search bar
         *
         * @return HTML
         */
        public function get_site_search_form()
        {
            ?>
                <!-- <div class="fly-search-bar" id="fly-search-bar"> -->
                <div class="container-wrap">
                    <?php
                    $css =    '';
                    if (class_exists('APSW_Product_Search_Finale_Class') && class_exists('WooCommerce')) {
                        do_action('apsw_search_bar_preview');
                        $css = 'active_product_search';
                    } else {
                        get_search_form();
                    }
                    ?>
                    <a href="javascript:void(0)" class="search-close-trigger <?php echo esc_attr($css); ?>"><i class="icofont-close"></i></a>
                </div>
                <!-- </div>		 -->
                <?php
            }

            public function get_site_breadcrumb()
            {
                if (is_404() || 'templates/without-hero.php' == get_page_template_slug()) return;
                if (function_exists('bcn_display') && (!is_home() || !is_front_page())): ?>
                    <div class="live-complete-breadcrumbs-wrap">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="live-complete-breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
                                        <?php bcn_display_list(); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                endif;
            }
            /**
             * Get the hero sections
             *
             * @return HTML
             */
            public function site_hero_sections()
            {
                if (is_404() || 'templates/without-hero.php' == get_page_template_slug()) return;

                if (is_front_page() && is_active_sidebar('slider')) :
                    dynamic_sidebar('slider');
                else:
                    $header_image = get_header_image();
                ?>

                    <div id="static_header_banner" class="header-style-1">

                        <?php if (!is_front_page()) : ?>
                            <div class="site-header-text-wrap">
                                <?php echo wp_kses($this->hero_block_heading(), $this->allowed_tags()); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($header_image)) : ?>
                            <div class="site-header-bg-wrap">

                                <div class="site-header-bg background-effect" style=" background-image: url(<?php echo esc_url($header_image); ?>); background-attachment: scroll; "></div>
                            </div>
                        <?php endif; ?>

                    </div>
        <?php
                endif;
            }
            /**
             * Add Banner Title.
             *
             * @since 1.0.0
             */
            function hero_block_heading()
            {
                echo '<div class="site-header-text-wrap">';

                if (is_home()) {
                    echo '<h1 class="page-title-text">';
                    echo bloginfo('name');
                    echo '</h1>';
                    echo '<p class="subtitle">';
                    echo esc_html(get_bloginfo('description', 'display'));
                    echo '</p>';
                } else if (function_exists('is_shop') && is_shop()) {
                    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                        echo '<h1 class="page-title-text">';
                        echo esc_html(woocommerce_page_title());
                        echo '</h1>';
                    }
                } else if (function_exists('is_product_category') && is_product_category()) {
                    echo '<h1 class="page-title-text">';
                    echo esc_html(woocommerce_page_title());
                    echo '</h1>';
                    echo '<p class="subtitle">';
                    do_action('woocommerce_archive_description');
                    echo '</p>';
                } elseif (is_singular()) {
                    echo '<h1 class="page-title-text">';
                    echo single_post_title('', false);
                    echo '</h1>';
                } elseif (is_archive()) {

                    the_archive_title('<h1 class="page-title-text">', '</h1>');
                    the_archive_description('<p class="archive-description subtitle">', '</p>');
                } elseif (is_search()) {
                    echo '<h1 class="title">';
                    printf( /* translators:straing */esc_html__('Search Results for: %s', 'live-complete'),  get_search_query());
                    echo '</h1>';
                } elseif (is_404()) {
                    echo '<h1 class="display-1">';
                    esc_html_e('Oops! That page can&rsquo;t be found.', 'live-complete');
                    echo '</h1>';
                }

                echo '</div>';
            }
            private function allowed_tags()
            {

                if (function_exists('live_complete_alowed_tags')) {
                    return live_complete_alowed_tags();
                } else {
                    return array();
                }
            }
        }

        $live_complete_Header_Layout = new live_complete_Header_Layout();
