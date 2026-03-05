<?php
/**
 * WooCommerce checkout form override
 *
 * @package POD_Starter_Pro
 */

defined( 'ABSPATH' ) || exit;
get_header(); ?>
<main id="main-content" class="site-main woocommerce-page" role="main">
    <div class="container">
        <h1><?php esc_html_e( 'Checkout', 'pod-starter' ); ?></h1>
        <?php woocommerce_output_all_notices(); ?>
        <?php do_action( 'woocommerce_before_checkout_form', WC()->checkout() ); ?>
        <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
            <div class="col2-set" id="customer_details">
                <div class="col-1"><?php do_action( 'woocommerce_checkout_billing' ); ?></div>
                <div class="col-2"><?php do_action( 'woocommerce_checkout_shipping' ); ?></div>
            </div>
            <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
        </form>
        <?php do_action( 'woocommerce_after_checkout_form', WC()->checkout() ); ?>
    </div>
</main>
<?php get_footer(); ?>
