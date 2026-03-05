<?php
/**
 * WooCommerce archive/shop page override
 *
 * @package POD_Starter_Pro
 */

defined( 'ABSPATH' ) || exit;
get_header( 'shop' );
?>
<main id="main-content" class="site-main woocommerce-page" role="main">
    <div class="container">
        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
            <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
        <?php endif; ?>
        <?php do_action( 'woocommerce_archive_description' ); ?>
        <?php if ( woocommerce_product_loop() ) :
            do_action( 'woocommerce_before_shop_loop' );
            woocommerce_product_loop_start();
            if ( wc_get_loop_prop( 'total' ) ) :
                while ( have_posts() ) : the_post();
                    do_action( 'woocommerce_shop_loop' );
                    wc_get_template_part( 'content', 'product' );
                endwhile;
            endif;
            woocommerce_product_loop_end();
            do_action( 'woocommerce_after_shop_loop' );
        else :
            do_action( 'woocommerce_no_products_found' );
        endif; ?>
    </div>
</main>
<?php get_footer( 'shop' ); ?>
