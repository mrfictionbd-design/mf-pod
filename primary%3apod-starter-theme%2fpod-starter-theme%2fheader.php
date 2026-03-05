<?php
/**
 * The header template
 *
 * @package POD_Starter_Pro
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="<?php echo esc_attr(get_theme_mod('pod_primary_color', '#6C5CE7')); ?>">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content">
    <?php esc_html_e('Skip to content', 'pod-starter'); ?>
</a>

<!-- Site Header -->
<header class="site-header" id="site-header" role="banner">
    <div class="header-inner">
        <!-- Logo -->
        <div class="site-logo">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo-text" rel="home">
                    <?php bloginfo('name'); ?>
                </a>
            <?php endif; ?>
        </div>

        <!-- Main Navigation -->
        <nav class="main-nav" id="main-nav" role="navigation" aria-label="<?php esc_attr_e('Main Navigation', 'pod-starter'); ?>">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_class'     => 'main-nav__list',
                    'container'      => false,
                    'depth'          => 2,
                    'link_before'    => '<span>',
                    'link_after'     => '</span>',
                    'fallback_cb'    => false,
                ]);
            } else {
                // Fallback navigation
                ?>
                <ul class="main-nav__list">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>" class="main-nav__link"><?php esc_html_e('Home', 'pod-starter'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="main-nav__link"><?php esc_html_e('Shop', 'pod-starter'); ?></a></li>
                    <li><a href="#customize" class="main-nav__link"><?php esc_html_e('Custom Design', 'pod-starter'); ?></a></li>
                    <li><a href="#about" class="main-nav__link"><?php esc_html_e('About', 'pod-starter'); ?></a></li>
                    <li><a href="#contact" class="main-nav__link"><?php esc_html_e('Contact', 'pod-starter'); ?></a></li>
                </ul>
                <?php
            }
            ?>
        </nav>

        <!-- Header Actions -->
        <div class="header-actions">
            <!-- Search -->
            <button class="header-action-btn" id="search-toggle" aria-label="<?php esc_attr_e('Search', 'pod-starter'); ?>">
                <?php echo pod_icon('search', 22); ?>
            </button>

            <!-- Account -->
            <?php if (pod_is_woocommerce_active()) : ?>
                <a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>" class="header-action-btn" aria-label="<?php esc_attr_e('My Account', 'pod-starter'); ?>">
                    <?php echo pod_icon('user', 22); ?>
                </a>

                <!-- Wishlist -->
                <button class="header-action-btn" aria-label="<?php esc_attr_e('Wishlist', 'pod-starter'); ?>">
                    <?php echo pod_icon('heart', 22); ?>
                </button>

                <!-- Cart -->
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="header-action-btn" id="cart-toggle" aria-label="<?php esc_attr_e('Cart', 'pod-starter'); ?>">
                    <?php echo pod_icon('cart', 22); ?>
                    <?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
                        <span class="cart-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>

            <!-- Mobile Menu Toggle -->
            <button class="menu-toggle" id="menu-toggle" aria-label="<?php esc_attr_e('Toggle Menu', 'pod-starter'); ?>" aria-expanded="false">
                <span class="menu-toggle__bar"></span>
                <span class="menu-toggle__bar"></span>
                <span class="menu-toggle__bar"></span>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Navigation Drawer -->
<div class="mobile-nav__overlay" id="mobile-nav-overlay"></div>
<nav class="mobile-nav" id="mobile-nav" role="navigation" aria-label="<?php esc_attr_e('Mobile Navigation', 'pod-starter'); ?>">
    <div class="mobile-nav__header flex flex--between mb-lg">
        <span class="site-logo-text"><?php bloginfo('name'); ?></span>
        <button class="header-action-btn" id="mobile-nav-close" aria-label="<?php esc_attr_e('Close Menu', 'pod-starter'); ?>">
            <?php echo pod_icon('close', 24); ?>
        </button>
    </div>

    <?php
    if (has_nav_menu('mobile')) {
        wp_nav_menu([
            'theme_location' => 'mobile',
            'menu_class'     => 'mobile-nav__list',
            'container'      => false,
        ]);
    } elseif (has_nav_menu('primary')) {
        wp_nav_menu([
            'theme_location' => 'primary',
            'menu_class'     => 'mobile-nav__list',
            'container'      => false,
        ]);
    }
    ?>
</nav>