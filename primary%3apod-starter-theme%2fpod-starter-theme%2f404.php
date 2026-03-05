<?php
/**
 * 404 Error Page
 *
 * @package POD_Starter_Pro
 */

get_header();
?>

<main id="main-content" class="site-main" role="main">
    <div class="container container--narrow text-center" style="padding-block: var(--space-3xl);">

        <div style="font-size: 120px; line-height: 1; margin-bottom: var(--space-md);">
            😕
        </div>

        <h1 class="text-gradient" style="font-size: var(--font-size-hero); margin-bottom: var(--space-sm);">
            404
        </h1>

        <h2 style="margin-bottom: var(--space-md); color: var(--color-gray-700);">
            <?php esc_html_e('Page Not Found', 'pod-starter'); ?>
        </h2>

        <p style="color: var(--color-gray-500); max-width: 45ch; margin-inline: auto; margin-bottom: var(--space-xl);">
            <?php esc_html_e("Sorry, the page you're looking for doesn't exist or has been moved. Let's get you back on track.", 'pod-starter'); ?>
        </p>

        <div class="flex flex--center flex--wrap flex--gap-sm mb-xl">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary btn--lg">
                <?php esc_html_e('Go Home', 'pod-starter'); ?>
            </a>

            <?php if (pod_is_woocommerce_active()) : ?>
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn--secondary btn--lg">
                    <?php esc_html_e('Browse Shop', 'pod-starter'); ?>
                </a>
            <?php endif; ?>
        </div>

        <!-- Search -->
        <div style="max-width: 500px; margin-inline: auto;">
            <p style="color: var(--color-gray-500); font-size: var(--font-size-sm); margin-bottom: var(--space-sm);">
                <?php esc_html_e('Or try searching for what you need:', 'pod-starter'); ?>
            </p>
            <?php get_search_form(); ?>
        </div>

        <!-- Popular Products -->
        <?php if (pod_is_woocommerce_active()) : ?>
            <div class="mt-xl">
                <h3 class="mb-lg"><?php esc_html_e('Popular Products', 'pod-starter'); ?></h3>
                <?php echo do_shortcode('[products limit="4" columns="4" orderby="popularity"]'); ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();