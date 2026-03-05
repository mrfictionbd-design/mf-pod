<?php
/**
 * WooCommerce cart page override
 *
 * @package POD_Starter_Pro
 */

defined( 'ABSPATH' ) || exit;
get_header(); ?>
<main id="main-content" class="site-main woocommerce-page" role="main">
    <div class="container">
        <h1><?php esc_html_e( 'Your Cart', 'pod-starter' ); ?></h1>
        <?php do_action( 'woocommerce_before_cart' ); ?>
        <?php woocommerce_output_all_notices(); ?>
        <?php wc_get_template( 'cart/cart.php', array(), '', WC()->plugin_path() . '/templates/' ); ?>
        <?php do_action( 'woocommerce_after_cart' ); ?>
    </div>
</main>
<?php get_footer(); ?>
