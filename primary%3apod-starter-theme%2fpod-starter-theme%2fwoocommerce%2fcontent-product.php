<?php
/**
 * WooCommerce product card override
 * Replaces the default product loop item
 *
 * @package POD_Starter_Pro
 */

defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
    return;
}
?>

<li <?php wc_product_class('product-card', $product); ?>>

    <!-- Image -->
    <div class="product-card__image-wrapper">
        <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>" aria-label="<?php echo esc_attr($product->get_name()); ?>">
            <?php
            $image_id = $product->get_image_id();
            if ($image_id) {
                echo wp_get_attachment_image($image_id, 'pod-product-card', false, [
                    'class'   => 'product-card__image',
                    'loading' => 'lazy',
                ]);
            } else {
                echo wc_placeholder_img('pod-product-card');
            }
            ?>
        </a>

        <!-- Badges -->
        <div class="product-card__badges">
            <?php if ($product->is_on_sale()) : ?>
                <span class="product-card__badge product-card__badge--sale">
                    <?php
                    if ($product->is_type('simple')) {
                        $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
                        printf(esc_html__('-%d%%', 'pod-starter'), $percentage);
                    } else {
                        esc_html_e('Sale', 'pod-starter');
                    }
                    ?>
                </span>
            <?php endif; ?>

            <?php if ($product->is_featured()) : ?>
                <span class="product-card__badge product-card__badge--hot">
                    <?php esc_html_e('Hot', 'pod-starter'); ?>
                </span>
            <?php endif; ?>

            <?php
            $post_date = get_the_date('U', $product->get_id());
            $thirty_days_ago = strtotime('-30 days');
            if ($post_date > $thirty_days_ago) : ?>
                <span class="product-card__badge product-card__badge--new">
                    <?php esc_html_e('New', 'pod-starter'); ?>
                </span>
            <?php endif; ?>
        </div>

        <!-- Quick Actions -->
        <div class="product-card__quick-actions">
            <button class="product-card__quick-btn pod-wishlist-btn"
                    data-product-id="<?php echo esc_attr($product->get_id()); ?>"
                    aria-label="<?php esc_attr_e('Add to wishlist', 'pod-starter'); ?>">
                <?php echo pod_icon('heart', 18); ?>
            </button>
            <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>"
               class="product-card__quick-btn"
               aria-label="<?php esc_attr_e('Quick view', 'pod-starter'); ?>">
                <?php echo pod_icon('eye', 18); ?>
            </a>
        </div>

        <!-- Customize Button (for POD products) -->
        <?php
        $is_customizable = $product->get_meta('_pod_customizable');
        if ($is_customizable) : ?>
            <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>#customize"
               class="product-card__customize-btn">
                🎨 <?php esc_html_e('Customize', 'pod-starter'); ?>
            </a>
        <?php endif; ?>
    </div>

    <!-- Body -->
    <div class="product-card__body">

        <!-- Category -->
        <?php
        $categories = wc_get_product_category_list($product->get_id());
        if ($categories) : ?>
            <div class="product-card__category">
                <?php
                $first_cat = get_the_terms($product->get_id(), 'product_cat');
                if ($first_cat && !is_wp_error($first_cat)) {
                    echo esc_html($first_cat[0]->name);
                }
                ?>
            </div>
        <?php endif; ?>

        <!-- Title -->
        <h2 class="product-card__title">
            <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>">
                <?php echo esc_html($product->get_name()); ?>
            


