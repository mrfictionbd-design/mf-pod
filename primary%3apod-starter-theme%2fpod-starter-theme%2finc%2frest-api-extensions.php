<?php
/**
 * Custom REST API endpoints
 *
 * @package POD_Starter_Pro
 */

defined( 'ABSPATH' ) || exit;

add_action( 'rest_api_init', function() {
    // POD Products endpoint
    register_rest_route( 'pod/v1', '/products', array(
        'methods'             => WP_REST_Server::READABLE,
        'callback'            => 'pod_rest_get_products',
        'permission_callback' => '__return_true',
    ));

    // POD Categories endpoint
    register_rest_route( 'pod/v1', '/categories', array(
        'methods'             => WP_REST_Server::READABLE,
        'callback'            => 'pod_rest_get_categories',
        'permission_callback' => '__return_true',
    ));
});

function pod_rest_get_products( WP_REST_Request $request ) {
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $request->get_param( 'per_page' ) ?: 12,
        'paged'          => $request->get_param( 'page' ) ?: 1,
    );
    $products = get_posts( $args );
    $data = array();
    foreach ( $products as $post ) {
        $product = wc_get_product( $post->ID );
        if ( ! $product ) continue;
        $data[] = array(
            'id'    => $product->get_id(),
            'name'  => $product->get_name(),
            'price' => $product->get_price(),
            'url'   => get_permalink( $post->ID ),
            'image' => get_the_post_thumbnail_url( $post->ID, 'medium' ),
        );
    }
    return rest_ensure_response( $data );
}

function pod_rest_get_categories( WP_REST_Request $request ) {
    $categories = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true ) );
    $data = array();
    foreach ( $categories as $cat ) {
        $data[] = array(
            'id'    => $cat->term_id,
            'name'  => $cat->name,
            'slug'  => $cat->slug,
            'count' => $cat->count,
            'url'   => get_term_link( $cat ),
        );
    }
    return rest_ensure_response( $data );
}
