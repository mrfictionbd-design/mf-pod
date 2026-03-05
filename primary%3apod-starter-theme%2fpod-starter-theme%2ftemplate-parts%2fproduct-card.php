<?php
/**
 * Reusable product card template part
 *
 * @package POD_Starter_Pro
 */
global $product;
if ( ! $product ) return;
?>
<div class="product-card" data-animate>
    <a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="product-card__link">
        <div class="product-card__image-wrap">
            <?php echo $product->get_image( 'woocommerce_thumbnail', [ 'loading' => 'lazy' ] ); ?>
            <?php if ( $product->is_on_sale() ) : ?>
                <span class="product-card__badge badge--sale"><?php esc_html_e( 'Sale', 'pod-starter' ); ?></span>
            <?php endif; ?>
        </div>
        <div class="product-card__content">
            <h3 class="product-card__title"><?php echo esc_html( $product->get_name() ); ?></h3>
            <div class="product-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
        </div>
    </a>
    <button class="btn btn--primary add_to_cart_button product_type_simple" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
        <?php esc_html_e( 'Add to Cart', 'pod-starter' ); ?>
    </button>
</div>
