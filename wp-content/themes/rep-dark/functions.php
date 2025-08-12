<?php
if (!defined('ABSPATH')) { exit; }

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('customize-selective-refresh-widgets');
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('rep-dark-style', get_stylesheet_uri(), [], '1.0.0');
});

/**
 * Customizer: Hero controls (title, subtitle, gradient colors)
 */
add_action('customize_register', function (WP_Customize_Manager $wp_customize) {

    // Section
    $wp_customize->add_section('rep_hero_section', [
        'title'       => __('Hero Settings', 'rep-dark'),
        'priority'    => 30,
        'description' => __('Customize the hero title, subtitle, and background gradient shown on the front page.', 'rep-dark'),
    ]);

    // Title
    $wp_customize->add_setting('rep_hero_title', [
        'default'           => '',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('rep_hero_title', [
        'type'    => 'text',
        'section' => 'rep_hero_section',
        'label'   => __('Hero Title', 'rep-dark'),
    ]);

    // Subtitle
    $wp_customize->add_setting('rep_hero_subtitle', [
        'default'           => '',
        'transport'         => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('rep_hero_subtitle', [
        'type'    => 'text',
        'section' => 'rep_hero_section',
        'label'   => __('Hero Subtitle', 'rep-dark'),
    ]);

    // Gradient From
    $wp_customize->add_setting('rep_hero_grad_from', [
        'default'           => '#0e1520',
        'transport'         => 'postMessage',
        'sanitize_callback' => function ($val) { return sanitize_hex_color($val) ?: '#0e1520'; },
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'rep_hero_grad_from',
        [
            'section' => 'rep_hero_section',
            'label'   => __('Gradient From', 'rep-dark'),
        ]
    ));

    // Gradient To
    $wp_customize->add_setting('rep_hero_grad_to', [
        'default'           => '#1a2a3f',
        'transport'         => 'postMessage',
        'sanitize_callback' => function ($val) { return sanitize_hex_color($val) ?: '#1a2a3f'; },
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'rep_hero_grad_to',
        [
            'section' => 'rep_hero_section',
            'label'   => __('Gradient To', 'rep-dark'),
        ]
    ));

    // Selective refresh for title/subtitle
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('rep_hero_title', [
            'selector'        => '.rep-hero .rep-hero-inner h1',
            'render_callback' => function () {
                $title = get_theme_mod('rep_hero_title', '');
                return esc_html($title !== '' ? $title : get_bloginfo('name'));
            },
        ]);
        $wp_customize->selective_refresh->add_partial('rep_hero_subtitle', [
            'selector'        => '.rep-hero .rep-subtitle',
            'render_callback' => function () {
                $subtitle = get_theme_mod('rep_hero_subtitle', '');
                return esc_html($subtitle !== '' ? $subtitle : get_bloginfo('description'));
            },
        ]);
    }
});

/**
 * Customizer live preview script
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script(
        'rep-dark-customize-preview',
        get_template_directory_uri() . '/js/customize-preview.js',
        ['customize-preview'],
        '1.0.0',
        true
    );
});

// Log the final template file used for the current request.
add_filter('template_include', function ($template) {
    error_log('TEMPLATE_USED: ' . $template);
    return $template;
});
