<?php
/**
 * WooCommerce template wrapper
 * This replaces the default WooCommerce page rendering
 *
 * @package POD_Starter_Pro
 */

get_header();
?>

<main id="main-content" class="site-main woocommerce-page" role="main" style="margin-top: var(--header-height); padding-block: var(--space-xl);">
    <div class="container">

        <?php if (function_exists('pod_breadcrumbs')) pod_breadcrumbs(); ?>

        <?php woocommerce_content(); ?>

    </div>
</main>

<?php
get_footer();