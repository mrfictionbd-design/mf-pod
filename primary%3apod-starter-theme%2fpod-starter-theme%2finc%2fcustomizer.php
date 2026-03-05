<?php
/**
 * Theme Customizer
 *
 * @package POD_Starter_Pro
 */

defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', function( $wp_customize ) {

    // POD Store Settings Panel
    $wp_customize->add_panel( 'pod_settings', array(
        'title'    => __( 'POD Store Settings', 'pod-starter' ),
        'priority' => 30,
    ));

    // Hero Section
    $wp_customize->add_section( 'pod_hero', array(
        'title' => __( 'Hero Section', 'pod-starter' ),
        'panel' => 'pod_settings',
    ));

    $hero_settings = array(
        'pod_hero_badge'    => array( 'label' => 'Hero Badge Text',    'default' => '🔥 New Designs Just Dropped' ),
        'pod_hero_title'    => array( 'label' => 'Hero Title',         'default' => 'Wear Your Story' ),
        'pod_hero_subtitle' => array( 'label' => 'Hero Subtitle',      'default' => 'Create custom print-on-demand products your customers will love.' ),
        'pod_hero_cta'      => array( 'label' => 'Hero CTA Text',      'default' => 'Shop Now' ),
        'pod_hero_cta_url'  => array( 'label' => 'Hero CTA URL',       'default' => '/shop' ),
    );

    foreach ( $hero_settings as $id => $config ) {
        $wp_customize->add_setting( $id, array( 'default' => $config['default'], 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( $id, array( 'label' => $config['label'], 'section' => 'pod_hero', 'type' => 'text' ) );
    }

    // Hero Image
    $wp_customize->add_setting( 'pod_hero_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'pod_hero_image', array(
        'label'   => __( 'Hero Background Image', 'pod-starter' ),
        'section' => 'pod_hero',
    )));

    // Brand Colors
    $wp_customize->add_section( 'pod_colors', array(
        'title' => __( 'Brand Colors', 'pod-starter' ),
        'panel' => 'pod_settings',
    ));

    $color_settings = array(
        'pod_color_primary'   => array( 'label' => 'Primary Color',   'default' => '#6C5CE7' ),
        'pod_color_secondary' => array( 'label' => 'Secondary Color', 'default' => '#00CEC9' ),
        'pod_color_accent'    => array( 'label' => 'Accent Color',    'default' => '#FD79A8' ),
    );

    foreach ( $color_settings as $id => $config ) {
        $wp_customize->add_setting( $id, array( 'default' => $config['default'], 'sanitize_callback' => 'sanitize_hex_color' ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
            'label'   => $config['label'],
            'section' => 'pod_colors',
        )));
    }
});
