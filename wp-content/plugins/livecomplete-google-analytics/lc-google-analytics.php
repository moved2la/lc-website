<?php

/**
 * Plugin Name: LiveComplete Google Analytics
 * Description: Adds Google Analytics 4 tracking script to your website
 * Version: 1.0.0
 * Author: Warren Galyen
 * License: GPL v2 or later
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Add menu item to WordPress admin
function ga4_tracking_menu()
{
    // Check if parent menu exists, if not create it
    global $menu;
    $parent_menu_exists = false;

    foreach ($menu as $item) {
        if (
            isset($item[2]) && $item[2] === 'livecomplete'
        ) {
            $parent_menu_exists = true;
            break;
        }
    }

    if (!$parent_menu_exists) {
        add_menu_page(
            'LiveComplete',       // Page title
            'LiveComplete',       // Menu title
            'manage_options',     // Capability
            'livecomplete',       // Menu slug
            null,                 // Callback function (null since this is just a parent)
            'dashicons-admin-generic', // Icon
            30                    // Position
        );
    }

    // Add Google Analytics submenu
    add_submenu_page(
        'livecomplete',           // Parent menu slug
        'Google Analytics',       // Page title
        'Google Analytics',       // Menu title
        'manage_options',         // Capability
        'ga4-tracking',          // Menu slug
        'ga4_tracking_settings_page' // Callback function
    );
}
add_action('admin_menu', 'ga4_tracking_menu');

// Register settings
function ga4_tracking_settings_init()
{
    register_setting('ga4_tracking', 'ga4_measurement_id');
    register_setting('ga4_tracking', 'ga4_enable_pageview', array(
        'type' => 'boolean',
        'default' => true
    ));
    register_setting('ga4_tracking', 'ga4_enable_consent', array(
        'type' => 'boolean',
        'default' => false
    ));
    register_setting('ga4_tracking', 'ga4_enable_webvitals', array(
        'type' => 'boolean',
        'default' => false
    ));
    register_setting('ga4_tracking', 'ga4_enable_performance', array(
        'type' => 'boolean',
        'default' => false
    ));

    add_settings_section(
        'ga4_tracking_section',
        'GA4 Settings',
        'ga4_tracking_section_callback',
        'ga4-tracking'
    );

    add_settings_field(
        'ga4_measurement_id',
        'Measurement ID',
        'ga4_measurement_id_callback',
        'ga4-tracking',
        'ga4_tracking_section'
    );

    add_settings_field(
        'ga4_enable_pageview',
        'Enable Default Pageview',
        'ga4_enable_pageview_callback',
        'ga4-tracking',
        'ga4_tracking_section'
    );

    add_settings_field(
        'ga4_enable_consent',
        'Enable Consent Mode',
        'ga4_enable_consent_callback',
        'ga4-tracking',
        'ga4_tracking_section'
    );

    add_settings_field(
        'ga4_enable_webvitals',
        'Track Web Vitals',
        'ga4_enable_webvitals_callback',
        'ga4-tracking',
        'ga4_tracking_section'
    );

    add_settings_field(
        'ga4_enable_performance',
        'Track Performance Timing',
        'ga4_enable_performance_callback',
        'ga4-tracking',
        'ga4_tracking_section'
    );
}
add_action('admin_init', 'ga4_tracking_settings_init');

// Section callback
function ga4_tracking_section_callback()
{
    echo '<p>Enter your Google Analytics 4 Measurement ID (Format: G-XXXXXXXXXX)</p>';
}

// Field callback
function ga4_measurement_id_callback()
{
    $measurement_id = get_option('ga4_measurement_id');
    echo '<input type="text" name="ga4_measurement_id" value="' . esc_attr($measurement_id) . '" placeholder="G-XXXXXXXXXX">';
}

// Add pageview toggle callback
function ga4_enable_pageview_callback()
{
    $enable_pageview = get_option('ga4_enable_pageview', true);
    echo '<input type="checkbox" name="ga4_enable_pageview" value="1" ' . checked(1, $enable_pageview, false) . '>';
    echo '<span class="description">Enable automatic pageview tracking on all pages</span>';
}

// Add new setting callbacks
function ga4_enable_consent_callback()
{
    $enable_consent = get_option('ga4_enable_consent', false);
    echo '<input type="checkbox" name="ga4_enable_consent" value="1" ' . checked(1, $enable_consent, false) . '>';
    echo '<span class="description">Enable Google Consent Mode (defaults all consent types to "denied")</span>';
}

function ga4_enable_webvitals_callback()
{
    $enable_webvitals = get_option('ga4_enable_webvitals', false);
    echo '<input type="checkbox" name="ga4_enable_webvitals" value="1" ' . checked(1, $enable_webvitals, false) . '>';
    echo '<span class="description">Track Core Web Vitals metrics</span>';
}

function ga4_enable_performance_callback()
{
    $enable_performance = get_option('ga4_enable_performance', false);
    echo '<input type="checkbox" name="ga4_enable_performance" value="1" ' . checked(1, $enable_performance, false) . '>';
    echo '<span class="description">Track performance timing metrics</span>';
}

// Settings page
function ga4_tracking_settings_page()
{
?>
    <div class="wrap">
        <h2>GA4 Tracking Settings</h2>
        <form action="options.php" method="post">
            <?php
            settings_fields('ga4_tracking');
            do_settings_sections('ga4-tracking');
            submit_button();
            ?>
        </form>
    </div>
<?php
}

// Add GA4 tracking script to header
function ga4_add_tracking_script()
{
    $measurement_id = get_option('ga4_measurement_id');
    $enable_pageview = get_option('ga4_enable_pageview', true);
    $enable_consent = get_option('ga4_enable_consent', false);
    $enable_webvitals = get_option('ga4_enable_webvitals', false);
    $enable_performance = get_option('ga4_enable_performance', false);

    if (empty($measurement_id)) {
        return;
    }
?>


    <!-- Google tag (gtag.js) -->
    <?php if ($enable_consent) : ?>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            // Default consent settings
            gtag('consent', 'default', {
                'analytics_storage': 'denied',
                'ad_storage': 'denied',
                'functionality_storage': 'denied',
                'personalization_storage': 'denied',
                'security_storage': 'denied'
            });
        </script>
    <?php endif; ?>

    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($measurement_id); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        // Configure GA4
        gtag('config', '<?php echo esc_attr($measurement_id); ?>', {
            <?php if (!$enable_pageview) : ?> 'send_page_view': false,
            <?php endif; ?>
            <?php if ($enable_performance) : ?> 'send_page_view_timing': true,
            <?php endif; ?>
        });

        <?php if ($enable_webvitals) : ?>
            // Web Vitals tracking
            addEventListener('CLS', (e) => {
                gtag('event', 'web_vital', {
                    metric_id: 'CLS',
                    metric_value: e.value,
                    metric_delta: e.delta
                });
            });

            addEventListener('FID', (e) => {
                gtag('event', 'web_vital', {
                    metric_id: 'FID',
                    metric_value: e.value,
                    metric_delta: e.delta
                });
            });

            addEventListener('LCP', (e) => {
                gtag('event', 'web_vital', {
                    metric_id: 'LCP',
                    metric_value: e.value,
                    metric_delta: e.delta
                });
            });
        <?php endif; ?>
    </script>
    <?php if ($enable_webvitals) : ?>
        <script async src="https://unpkg.com/web-vitals"></script>
    <?php endif; ?>
<?php
}
add_action('wp_head', 'ga4_add_tracking_script');
