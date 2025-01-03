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
class Live_Complete_Body_Layout
{
    /**
     * Function that is run after instantiation.
     *
     * @return void
     */
    public function __construct()
    {

        add_action('live_complete_container_wrap_start', array($this, 'container_wrap_start'), 5);
        add_action('live_complete_container_wrap_start', array($this, 'container_wrap_column_start'), 10);

        add_action('live_complete_container_wrap_end', array($this, 'container_wrap_column_end'), 5);
        add_action('live_complete_container_wrap_end', array($this, 'get_sidebar'), 10);
        add_action('live_complete_container_wrap_end', array($this, 'container_wrap_end'), 999);
    }
    /**
     * Container before
     *
     * @return $html 
     */
    function container_wrap_start()
    {

        if (is_front_page() || is_page_template('templates/page-learn-subpage.php')) {
            $container_class = '';
        } else {
            $container_class = 'container';
        }
        $html  = '<div id="primary" class="content-area ' . $container_class . '">
        				<div class="row">';

        $html  = apply_filters('live_complete_container_wrap_start_filter', $html);

        echo wp_kses($html, $this->allowed_tags());
    }

    /**
     * Main Content Column before
     *
     * return $html
     */
    function container_wrap_column_start($layout = '')
    {

        if (is_product()) {
            $layout = 'full-container';
        }
        switch ($layout) {
            case 'sidebar-content':
                $layout = 'col-xl-8 col-md-8 col-12 order-2';
                break;
            case 'no-sidebar':
                $layout = 'col-md-10 offset-md-1 bcf-main-content';
                break;
            case 'full-container':
                $layout = 'col-md-12 bcf-main-content';
                break;
            default:
                $layout = 'col-xl-12 col-md-12 col-12 order-1';
        }

        $html = '<div class="' . esc_attr($layout) . '">
	   					<main id="main" class="site-main">';

        $html = apply_filters('live_complete_container_wrap_column_start_filter', $html);

        echo wp_kses($html, $this->allowed_tags());
    }

    /**
     * Main Content Column before
     *
     * return $html
     */
    function container_wrap_column_end($layout = '')
    {

        $html      = '</main>
	   			</div>';

        $html       = apply_filters('live_complete_container_wrap_column_end_filter', $html);

        echo wp_kses($html, $this->allowed_tags());
    }

    /**
     * Main Content Column after
     *
     * return $html
     */
    function get_sidebar($layout = '')
    {

        switch ($layout) {
            case 'sidebar-content':
                $layout = 'col-xl-4 col-md-4 col-12 order-1 live-complete-sidebar';
                break;
            case 'no-sidebar':
                return false;
                break;
            case 'full-container':
                return false;
                break;
            default:
                return false;
                $layout = 'col-xl-12 col-md-12 col-12 order-2';
                break;
        }
?>
        <div class="<?php echo esc_attr($layout); ?>">
            <?php get_sidebar(); ?>
        </div>
<?php

    }

    /**
     * Container before
     *
     * @return $html
     */
    function container_wrap_end()
    {

        $html  = '</div></div>';

        $html  = apply_filters('live_complete_container_wrap_end_filter', $html);

        echo wp_kses($html, $this->allowed_tags());
    }


    private function allowed_tags()
    {

        if (function_exists('live_complete_allowed_tags')) {
            return live_complete_allowed_tags();
        } else {
            return array();
        }
    }
}

$live_complete_body_layout = new Live_Complete_Body_Layout();
