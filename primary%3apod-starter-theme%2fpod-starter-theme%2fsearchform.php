<?php
/**
 * Custom search form
 *
 * @package POD_Starter_Pro
 */
?>

<form role="search"
      method="get"
      class="search-form flex flex--gap-sm"
      action="<?php echo esc_url(home_url('/')); ?>">
    <label class="visually-hidden" for="search-field-<?php echo esc_attr(wp_unique_id()); ?>">
        <?php esc_html_e('Search for:', 'pod-starter'); ?>
    </label>
    <input type="search"
           id="search-field-<?php echo esc_attr(wp_unique_id()); ?>"
           class="form-input"
           placeholder="<?php esc_attr_e('Search products, designs...', 'pod-starter'); ?>"
           value="<?php echo get_search_query(); ?>"
           name="s"
           style="flex: 1;">

    <?php if (pod_is_woocommerce_active()) : ?>
        <input type="hidden" name="post_type" value="product">
    <?php endif; ?>

    <button type="submit" class="btn btn--primary">
        <?php echo pod_icon('search', 20); ?>
        <span class="visually-hidden"><?php esc_html_e('Search', 'pod-starter'); ?></span>
    </button>
</form>