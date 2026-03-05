<?php
/**
 * WooCommerce single product page override
 *
 * @package POD_Starter_Pro
 */

defined( 'ABSPATH' ) || exit;
get_header( 'shop' );
?>
<main id="main-content" class="site-main woocommerce-page" role="main">
    <div class="container">
        <?php while ( have_posts() ) : the_post();
            wc_get_template_part( 'content', 'single-product' );
        endwhile; ?>
    </div>
</main>
<?php get_footer( 'shop' ); ?>
