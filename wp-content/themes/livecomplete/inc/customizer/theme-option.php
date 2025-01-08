<?php

/**
 * Theme Options Panel.
 *
 * @package live-complete
 */

$default = live_complete_get_default_theme_options();
global $wp_customize;



// Add Theme Options Panel.
$wp_customize->add_panel(
    'theme_option_panel',
    array(
        'title'      => esc_html__('Theme Options', 'live-complete'),
        'priority'   => 2,
        'capability' => 'edit_theme_options',
    )
);


$wp_customize->add_section(
    'topbar_section_settings',
    array(
        'title'      => esc_html__('Top Bar', 'live-complete'),
        'priority'   => 10,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

/*Social Profile*/
$wp_customize->add_setting(
    '__topbar_phone',
    array(
        'default'           => $default['__topbar_phone'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    '__topbar_phone',
    array(
        'label'    => esc_html__('Phone:', 'live-complete'),
        'section'  => 'topbar_section_settings',
        'type'     => 'text',

    )
);

$wp_customize->add_setting(
    '__topbar_email',
    array(
        'default'           => $default['__topbar_email'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    '__topbar_email',
    array(
        'label'    => esc_html__('Email:', 'live-complete'),
        'section'  => 'topbar_section_settings',
        'type'     => 'text',

    )
);

$wp_customize->add_setting(
    '__topbar_address',
    array(
        'default'           => $default['__topbar_address'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    '__topbar_address',
    array(
        'label'    => esc_html__('Address:', 'live-complete'),
        'section'  => 'topbar_section_settings',
        'type'     => 'text',

    )
);
// Styling Options.*/

$wp_customize->add_section(
    'styling_section_settings',
    array(
        'title'      => esc_html__('Styling Options', 'live-complete'),
        'priority'   => 100,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);


// Primary Color.
$wp_customize->add_setting(
    '__primary_color',
    array(
        'default'           => $default['__primary_color'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    '__primary_color',
    array(
        'label'           => esc_html__('Primary Color Scheme:', 'live-complete'),
        'section'         => 'styling_section_settings',
        'description'  => esc_html__('The theme comes with unlimited color schemes for your theme\'s styling. upgrade pro for color options & features', 'live-complete'),
        'type'     => 'color',
        'priority' => 120,
    )
);

$wp_customize->add_setting(
    '__secondary_color',
    array(
        'default'           => $default['__secondary_color'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    '__secondary_color',
    array(
        'label'           => esc_html__('Secondary Color Scheme:', 'live-complete'),
        'section'         => 'styling_section_settings',
        'description'  => esc_html__('The theme comes with unlimited color schemes for your theme\'s styling. upgrade pro for color options & features', 'live-complete'),
        'type'     => 'color',
        'priority' => 120,
    )
);


// Primary Color for menu.
$wp_customize->add_setting(
    '__menu_primary_color',
    array(
        'default'           => $default['__menu_primary_color'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    '__menu_primary_color',
    array(
        'label'           => esc_html__('Menu Primary Color Scheme:', 'live-complete'),
        'section'         => 'styling_section_settings',
        'description'  => esc_html__('The theme comes with unlimited color schemes for your theme\'s styling. upgrade pro for color options & features', 'live-complete'),
        'type'     => 'color',
        'priority' => 120,
    )
);


$wp_customize->add_setting(
    '__menu_secondary_color',
    array(
        'default'           => $default['__menu_secondary_color'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    '__menu_secondary_color',
    array(
        'label'           => esc_html__('Menu Secondary Color Scheme:', 'live-complete'),
        'section'         => 'styling_section_settings',
        'description'  => esc_html__('The theme comes with unlimited color schemes for your theme\'s styling. upgrade pro for color options & features', 'live-complete'),
        'type'     => 'color',
        'priority' => 120,
    )
);

/*Posts management section start */
$wp_customize->add_section(
    'theme_option_section_settings',
    array(
        'title'      => esc_html__('Blog Management', 'live-complete'),
        'priority'   => 100,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

/*Posts Layout*/
$wp_customize->add_setting(
    'blog_layout',
    array(
        'default'           => $default['blog_layout'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'live_complete_sanitize_select',
    )
);
$wp_customize->add_control(
    'blog_layout',
    array(
        'label'    => esc_html__('Blog Layout Options', 'live-complete'),
        'description' => esc_html__('Choose between different layout options to be used as default', 'live-complete'),
        'section'  => 'theme_option_section_settings',
        'choices'   => array(
            'sidebar-content'  => esc_html__('Primary Sidebar - Content', 'live-complete'),
            'content-sidebar'  => esc_html__('Content - Primary Sidebar', 'live-complete'),
            'no-sidebar'          => esc_html__('No Sidebar', 'live-complete'),
            'full-container'   => esc_html__('Full Container', 'live-complete'),

        ),
        'type'     => 'select',

    )
);


$wp_customize->add_setting(
    'single_post_layout',
    array(
        'default'           => $default['single_post_layout'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'live_complete_sanitize_select',
    )
);
$wp_customize->add_control(
    'single_post_layout',
    array(
        'label'    => esc_html__('Blog Layout Options', 'live-complete'),
        'description' => esc_html__('Choose between different layout options to be used as default', 'live-complete'),
        'section'  => 'theme_option_section_settings',
        'choices'   => array(
            'sidebar-content'  => esc_html__('Primary Sidebar - Content', 'live-complete'),
            'content-sidebar' => esc_html__('Content - Primary Sidebar', 'live-complete'),
            'no-sidebar'    => esc_html__('No Sidebar', 'live-complete'),
            'full-container'   => esc_html__('Full Container', 'live-complete'),
        ),
        'type'     => 'select',

    )
);


/*Blog Loop Content*/
$wp_customize->add_setting(
    'blog_loop_content_type',
    array(
        'default'           => $default['blog_loop_content_type'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'live_complete_sanitize_select',
    )
);
$wp_customize->add_control(
    'blog_loop_content_type',
    array(
        'label'    => esc_html__('Archive Content Type', 'live-complete'),
        'description' => esc_html__('Choose Archive, Blog Page Content type as default', 'live-complete'),
        'section'  => 'theme_option_section_settings',
        'choices'               => array(
            'excerpt' => __('Excerpt', 'live-complete'),
            'content' => __('Content', 'live-complete'),
        ),
        'type'     => 'select',

    )
);

/*Social Profile*/
$wp_customize->add_setting(
    'read_more_text',
    array(
        'default'           => $default['read_more_text'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    'read_more_text',
    array(
        'label'    => esc_html__('Read more text', 'live-complete'),
        'description' => esc_html__('Leave empty to hide', 'live-complete'),
        'section'  => 'theme_option_section_settings',
        'type'     => 'text',

    )
);


$wp_customize->add_setting(
    'blog_meta_hide',
    array(
        'default'           => $default['blog_meta_hide'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'live_complete_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'blog_meta_hide',
    array(
        'label'    => esc_html__('Hide Blog Archive Meta Info ?', 'live-complete'),
        'section'  => 'theme_option_section_settings',
        'type'     => 'checkbox',

    )
);

$wp_customize->add_setting(
    'signle_meta_hide',
    array(
        'default'           => $default['signle_meta_hide'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'live_complete_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'signle_meta_hide',
    array(
        'label'    => esc_html__('Hide Single post Meta Info ?', 'live-complete'),
        'section'  => 'theme_option_section_settings',
        'type'     => 'checkbox',

    )
);

/*Posts management section start */
$wp_customize->add_section(
    'page_option_section_settings',
    array(
        'title'      => esc_html__('Page Management', 'live-complete'),
        'priority'   => 100,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);


/*Home Page Layout*/
$wp_customize->add_setting(
    'page_layout',
    array(
        'default'           => $default['blog_layout'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'live_complete_sanitize_select',
    )
);
$wp_customize->add_control(
    'page_layout',
    array(
        'label'    => esc_html__('Page Layout Options', 'live-complete'),
        'section'  => 'page_option_section_settings',
        'description' => esc_html__('Choose between different layout options to be used as default', 'live-complete'),
        'choices'   => array(
            'sidebar-content'  => esc_html__('Primary Sidebar - Content', 'live-complete'),
            'content-sidebar' => esc_html__('Content - Primary Sidebar', 'live-complete'),
            'no-sidebar'    => esc_html__('No Sidebar', 'live-complete'),
            'full-container'   => esc_html__('Full Container', 'live-complete'),
        ),
        'type'     => 'select',
        'priority' => 170,
    )
);


// Footer Section.
$wp_customize->add_section(
    'footer_section',
    array(
        'title'      => esc_html__('Copyright', 'live-complete'),
        'priority'   => 130,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

// Setting copyright_text.
$wp_customize->add_setting(
    'copyright_text',
    array(
        'default'           => $default['copyright_text'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    'copyright_text',
    array(
        'label'    => esc_html__('Footer Copyright Text', 'live-complete'),
        'section'  => 'footer_section',
        'type'     => 'textarea',
        'priority' => 120,
    )
);



/* Social Profile */
$wp_customize->add_section(
    'social_profile_sec',
    array(
        'title'      => esc_html__('Social Profile', 'live-complete'),
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

/* Social Profile */
$wp_customize->add_setting(
    '__fb_link',
    array(
        'default'           => $default['__fb_link'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control(
    '__fb_link',
    array(
        'label'    => esc_html__('Facebook', 'live-complete'),
        'description' => esc_html__('Leave empty to hide', 'live-complete'),
        'section'  => 'social_profile_sec',
        'type'     => 'text',

    )
);



$wp_customize->add_setting(
    '__ig_link',
    array(
        'default'           => $default['__ig_link'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control(
    '__ig_link',
    array(
        'label'    => esc_html__('Instagram', 'live-complete'),
        'description' => esc_html__('Leave empty to hide', 'live-complete'),
        'section'  => 'social_profile_sec',
        'type'     => 'text',

    )
);


$wp_customize->add_setting(
    '__x_link',
    array(
        'default'           => $default['__x_link'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control(
    '__x_link',
    array(
        'label'    => esc_html__('X (Twitter)', 'live-complete'),
        'description' => esc_html__('Leave empty to hide', 'live-complete'),
        'section'  => 'social_profile_sec',
        'type'     => 'text',

    )
);


$wp_customize->add_setting(
    '__li_link',
    array(
        'default'           => $default['__li_link'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control(
    '__li_link',
    array(
        'label'    => esc_html__('LinkedIn', 'live-complete'),
        'description' => esc_html__('Leave empty to hide', 'live-complete'),
        'section'  => 'social_profile_sec',
        'type'     => 'text',

    )
);

$wp_customize->add_setting(
    '__yt_link',
    array(
        'default'           => $default['__yt_link'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control(
    '__yt_link',
    array(
        'label'    => esc_html__('Youtube', 'live-complete'),
        'description' => esc_html__('Leave empty to hide', 'live-complete'),
        'section'  => 'social_profile_sec',
        'type'     => 'text',

    )
);
