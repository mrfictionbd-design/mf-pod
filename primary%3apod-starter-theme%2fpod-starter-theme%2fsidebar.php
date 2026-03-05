<?php
/**
 * Sidebar template
 *
 * @package POD_Starter_Pro
 */

if (!is_active_sidebar('sidebar-shop')) {
    return;
}
?>

<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e('Sidebar', 'pod-starter'); ?>">
    <?php dynamic_sidebar('sidebar-shop'); ?>
</aside>