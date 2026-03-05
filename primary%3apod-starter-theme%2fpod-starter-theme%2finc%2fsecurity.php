<?php
/**
 * Security hardening
 *
 * @package POD_Starter_Pro
 */

defined( 'ABSPATH' ) || exit;

// Remove WordPress version from header
remove_action( 'wp_head', 'wp_generator' );

// Disable XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );

// Remove RSD link
remove_action( 'wp_head', 'rsd_link' );

// Remove wlwmanifest link
remove_action( 'wp_head', 'wlwmanifest_link' );

// Disable file edit in admin
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
    define( 'DISALLOW_FILE_EDIT', true );
}

// Security headers
add_action( 'send_headers', function() {
    header( 'X-Content-Type-Options: nosniff' );
    header( 'X-Frame-Options: SAMEORIGIN' );
    header( 'X-XSS-Protection: 1; mode=block' );
    header( 'Referrer-Policy: strict-origin-when-cross-origin' );
});
