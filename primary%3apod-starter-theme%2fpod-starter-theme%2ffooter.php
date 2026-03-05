<?php
/**
 * The footer template
 *
 * @package POD_Starter_Pro
 */
?>

<!-- Site Footer -->
<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand Column -->
            <div class="footer-brand">
                <?php if (has_custom_logo()) : ?>
                    <div class="footer-logo mb-sm">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <h3 class="site-logo-text mb-sm" style="color: var(--color-white);">
                        <?php bloginfo('name'); ?>
                    </h3>
                <?php endif; ?>

                <p class="footer-brand__description">
                    <?php echo esc_html(get_theme_mod(
                        'pod_footer_description',
                        __('Premium custom products, designed by you. Quality printing, worldwide shipping.', 'pod-starter')
                    )); ?>
                </p>

                <div class="footer-social">
                    <?php
                    $socials = [
                        'instagram' => 'Instagram',
                        'facebook'  => 'Facebook',
                        'twitter'   => 'Twitter',
                        'tiktok'    => 'TikTok',
                        'youtube'   => 'YouTube',
                        'pinterest' => 'Pinterest',
                    ];
                    foreach ($socials as $key => $label) :
                        $url = get_option("pod_{$key}");
                        if ($url) :
                            ?>
                            <a href="<?php echo esc_url($url); ?>"
                               class="footer-social__link"
                               aria-label="<?php echo esc_attr($label); ?>"
                               target="_blank"
                               rel="noopener noreferrer">
                                <?php echo esc_html(substr($label, 0, 2)); ?>
                            </a>
                        <?php endif;
                    endforeach;
                    ?>
                </div>
            </div>

            <!-- Footer Links Column 1 -->
            <div class="footer-column">
                <h4 class="footer-heading"><?php esc_html_e('Shop', 'pod-starter'); ?></h4>
                <?php if (has_nav_menu('footer-1')) : ?>
                    <?php wp_nav_menu([
                        'theme_location' => 'footer-1',
                        'menu_class'     => 'footer-links',
                        'container'      => false,
                        'depth'          => 1,
                    ]); ?>
                <?php else : ?>
                    <ul class="footer-links">
                        <li><a href="/shop"><?php esc_html_e('All Products', 'pod-starter'); ?></a></li>
                        <li><a href="/product-category/tshirts"><?php esc_html_e('T-Shirts', 'pod-starter'); ?></a></li>
                        <li><a href="/product-category/hoodies"><?php esc_html_e('Hoodies', 'pod-starter'); ?></a></li>
                        <li><a href="/product-category/mugs"><?php esc_html_e('Mugs', 'pod-starter'); ?></a></li>
                        <li><a href="/product-category/posters"><?php esc_html_e('Posters', 'pod-starter'); ?></a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Footer Links Column 2 -->
            <div class="footer-column">
                <h4 class="footer-heading"><?php esc_html_e('Support', 'pod-starter'); ?></h4>
                <?php if (has_nav_menu('footer-2')) : ?>
                    <?php wp_nav_menu([
                        'theme_location' => 'footer-2',
                        'menu_class'     => 'footer-links',
                        'container'      => false,
                        'depth'          => 1,
                    ]); ?>
                <?php else : ?>
                    <ul class="footer-links">
                        <li><a href="/faq"><?php esc_html_e('FAQ', 'pod-starter'); ?></a></li>
                        <li><a href="/shipping"><?php esc_html_e('Shipping Info', 'pod-starter'); ?></a></li>
                        <li><a href="/returns"><?php esc_html_e('Returns & Exchanges', 'pod-starter'); ?></a></li>
                        <li><a href="/size-guide"><?php esc_html_e('Size Guide', 'pod-starter'); ?></a></li>
                        <li><a href="/contact"><?php esc_html_e('Contact Us', 'pod-starter'); ?></a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Newsletter Column -->
            <div class="footer-column">
                <h4 class="footer-heading"><?php esc_html_e('Stay Updated', 'pod-starter'); ?></h4>
                <p class="footer-brand__description" style="max-width: none;">
                    <?php esc_html_e('Get 10% off your first order + exclusive designs.', 'pod-starter'); ?>
                </p>
                <div class="footer-newsletter">
                    <form class="footer-newsletter__form" action="#" method="post">
                        <input type="email"
                               class="footer-newsletter__input"
                               placeholder="<?php esc_attr_e('Your email', 'pod-starter'); ?>"
                               required
                               aria-label="<?php esc_attr_e('Email address', 'pod-starter'); ?>">
                        <button type="submit" class="btn btn--primary btn--sm">
                            <?php echo pod_icon('send', 18); ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p class="footer-bottom__copy">
                <?php echo wp_kses_post(get_theme_mod(
                    'pod_footer_text',
                    sprintf('© %d %s. %s', date('Y'), get_bloginfo('name'), __('All rights reserved.', 'pod-starter'))
                )); ?>
            </p>

            <div class="footer-bottom__links">
                <a href="/privacy-policy"><?php esc_html_e('Privacy Policy', 'pod-starter'); ?></a>
                <a href="/terms"><?php esc_html_e('Terms of Service', 'pod-starter'); ?></a>
                <a href="/cookies"><?php esc_html_e('Cookie Policy', 'pod-starter'); ?></a>
            </div>
        </div>
    </div>
</footer>

<!-- AI Chatbot Widget -->
<?php get_template_part('template-parts/ai-chatbot'); ?>

<?php wp_footer(); ?>
</body>
</html>