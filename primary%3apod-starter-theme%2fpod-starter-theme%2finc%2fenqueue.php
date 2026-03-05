<?php
/**
 * Script and style enqueue
 *
 * @package POD_Starter_Pro
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function() {
    $ver = wp_get_theme()->get( 'Version' );
    $uri = get_template_directory_uri();

    // Styles
    wp_enqueue_style( 'pod-main',      $uri . '/assets/css/main.css',              array(), $ver );
    wp_enqueue_style( 'pod-responsive', $uri . '/assets/css/responsive.css',        array( 'pod-main' ), $ver );

    if ( is_woocommerce() || is_cart() || is_checkout() ) {
        wp_enqueue_style( 'pod-woo', $uri . '/assets/css/woocommerce-custom.css', array( 'pod-main' ), $ver );
    }

    // Scripts
    wp_enqueue_script( 'pod-main',      $uri . '/assets/js/main.js',      array(), $ver, true );
    wp_enqueue_script( 'pod-lazy-load', $uri . '/assets/js/lazy-load.js', array(), $ver, true );

    if ( is_woocommerce() || is_cart() || is_shop() ) {
        wp_enqueue_script( 'pod-ajax-cart', $uri . '/assets/js/ajax-cart.js', array(), $ver, true );
        wp_localize_script( 'pod-ajax-cart', 'pod_ajax', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'pod-ajax-cart' ),
        ));
    }

    if ( is_page() || is_singular( 'product' ) ) {
        wp_enqueue_script( 'fabricjs',          'https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js', array(), '5.3.1', true );
        wp_enqueue_script( 'pod-mockup',         $uri . '/assets/js/mockup-generator.js', array( 'fabricjs' ), $ver, true );
        wp_enqueue_style(  'pod-mockup-css',     $uri . '/assets/css/mockup-generator.css', array(), $ver );
    }
}, 10 );
