<?php
/**
 * Plugin Name: Theme Addons Page
 *
 * See ./license.txt for copyright and licensing information applicable to this file and other files and subdirectories in the same directory.
 * This file contains code copied from WordPress. This file was modified.
 *
 */

defined( 'ABSPATH' ) || die();

class WPZ_Generate_Random_Orders_For_WooCommerce_Addons {

    /**
     * Products list displayed in the addons tab
     *
     */
    const ADDONS_URL = 'https://wpzone.co/wp-content/uploads/product-addons/divi-ecommerce.json';

    static function setup() {
        add_action( 'admin_enqueue_scripts', [ 'WPZ_Generate_Random_Orders_For_WooCommerce_Addons', 'admin_scripts' ], 11 );
    }

    /**
     * Enqueue scripts for all admin pages.
     * Called in setup()
     *
     * @param int $hook Hook suffix for the current admin page.
     *
     * @since 1.0.0
     *
     */
    public static function admin_scripts($hook) {
        if ( 'woocommerce_page_wpz-random-orders' === $hook ) {
            wp_enqueue_style( 'wpz-woocommerce-random-orders-admin-addons', plugins_url( '/css/admin.min.css', __FILE__ ), [], WPZ_Generate_Random_Orders_For_WooCommerce::VERSION );
        }
    }

    static function outputList() {

        $addonsJson = wp_remote_retrieve_body(
            wp_remote_get(
                add_query_arg( 'locale', get_locale(), self::ADDONS_URL )
            )
        );

        if ( $addonsJson ) {
            $addons = json_decode( $addonsJson );
        }

        if ( empty( $addons ) ) {
            echo(
                '<p class="ags-settings-addons-error">'
                . esc_html__( 'We are unable to load the addons for this theme right now. Please try again later!', 'wpz-woocommerce-random-orders' )
                . '</p>'
            );

            return;
        }

        echo( '<div class="ags-settings-addons-list">' );

        foreach ( $addons as $addon ) {
            self::outputListItem( $addon );
        }

        echo( '</div>' );

    }

    static function outputListItem( $addon ) { ?>

        <div class="ags-settings-addon">
            <div class="ags-settings-addon-info">
                <div class="ags-settings-addon-badges-wrapper">
                    <?php
                    if ( ! empty( $addon->badges ) ) {
                        foreach ( $addon->badges as $badge ) {
                            printf(
                                '<span class="ags-settings-addon-badge" style="color: %s; background-color: %s;">%s</span>',
                                esc_attr(sanitize_hex_color( $badge->textColor )),
                                esc_attr(sanitize_hex_color( $badge->bgColor )),
                                esc_html( $badge->label )
                            );
                        }
                    }
                    ?>
                </div>
                <img src="<?php echo esc_url(
                    empty( $addon->thumbnail )
                        ? WpzAiImageLab::$pluginDir . 'includes/admin/addons-tab/images/placeholder.jpg'
                        : $addon->thumbnail
                ); ?>" alt="<?php echo( esc_attr( $addon->name ) ); ?>" class="ags-settings-addon-img">
                <h4>
                    <?php
                    echo( esc_html( $addon->name ) );

                    ?>
                </h4>
                <p><?php echo( esc_html( $addon->description ) ); ?></p>
            </div>
            <?php self::outputListItemLink( $addon ); ?>
        </div>

    <?php }

    static function outputListItemLink( $addon ) {

        $classes = 'ags-settings-addon-btn';

        switch ( $addon->type ) {

            case 'repo':
                // from (modified) wp-admin/includes/plugin-install.php
                $installed_plugin = get_plugins( '/' . $addon->target );
                if ( empty( $installed_plugin ) ) {
                    $label = __( 'Install', 'wpz-woocommerce-random-orders' );
                    if ( current_user_can( 'install_plugins' ) ) {
                        $url             = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $addon->target ), 'install-plugin_' . $addon->target );
                        $onclick_escaped = '';
                    } else {
                        $url             = '#';
                        $onclick_escaped = ' onclick="alert(\'' . esc_js( __( 'You do not have sufficient permissions to install plugins. If you think this message is in error, go to Plugins > Add New and search for the plugin name.', 'wpz-woocommerce-random-orders' ) ) . '\');return false;"';
                    }
                } else {
                    $label           = __( 'Already Installed', 'wpz-woocommerce-random-orders' );
                    $classes         .= ' ags-settings-addon-btn-disabled';
                    $url             = '#';
                    $onclick_escaped = ' onclick="return false;"';
                }
                break;

            case 'link':
                $label           = $addon->buttonLabel;
                $url             = $addon->target;
                $onclick_escaped = '';
                break;

            default:
                return;

        }


        printf(
            '<a href="%s" target="_blank" class="%s"%s>%s</a>',
            esc_url( $url ),
            esc_attr( $classes ),
            $onclick_escaped, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            esc_html( $label )
        );
    }
}

WPZ_Generate_Random_Orders_For_WooCommerce_Addons::setup();
