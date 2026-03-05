<?php
/**
 * WooCommerce setup & hooks
 *
 * @package POD_Starter_Pro
 */

defined( 'ABSPATH' ) || exit;

// Remove default WooCommerce styles
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// WooCommerce theme support
add_action( 'after_setup_theme', function() {
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width'  => 600,
        'single_image_width'     => 900,
        'product_grid'           => array(
            'default_rows'    => 4,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ));
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
});

// Custom breadcrumbs
add_filter( 'woocommerce_breadcrumb_defaults', function( $args ) {
    $args['delimiter'] = ' &rsaquo; ';
    return $args;
});
