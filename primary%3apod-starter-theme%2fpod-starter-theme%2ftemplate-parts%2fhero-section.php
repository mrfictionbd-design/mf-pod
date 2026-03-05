<?php
/**
 * Hero section template part
 *
 * @package POD_Starter_Pro
 */

$hero_badge    = get_theme_mod('pod_hero_badge', '🔥 New Designs Just Dropped');
$hero_title    = get_theme_mod('pod_hero_title', 'Design Your <span class="text-gradient">Perfect</span> Custom Products');
$hero_subtitle = get_theme_mod('pod_hero_subtitle', 'Upload your design, preview it in real-time, and order premium quality custom products delivered to your door.');
$hero_cta      = get_theme_mod('pod_hero_cta_text', 'Start Designing');
$hero_cta_url  = get_theme_mod('pod_hero_cta_url', '/shop');
$hero_cta2     = get_theme_mod('pod_hero_cta2_text', 'Browse Products');
$hero_cta2_url = get_theme_mod('pod_hero_cta2_url', '/shop');
$hero_image    = get_theme_mod('pod_hero_image', POD_THEME_ASSETS . '/images/hero-placeholder.jpg');
?>

<section class="hero" role="banner">
    <div class="hero__background" aria-hidden="true"></div>

    <div class="container">
        <div class="hero__grid">
            <!-- Content -->
            <div class="hero__content">
                <?php if ($hero_badge) : ?>
                    <div class="hero__badge">
                        <span class="hero__badge-dot" aria-hidden="true"></span>
                        <?php echo esc_html($hero_badge); ?>
                    </div>
                <?php endif; ?>

                <h1 class="hero__title">
                    <?php echo wp_kses_post($hero_title); ?>
                </h1>

                <p class="hero__description">
                    <?php echo esc_html($hero_subtitle); ?>
                </p>

                <div class="hero__actions">
                    <a href="<?php echo esc_url($hero_cta_url); ?>" class="btn btn--primary btn--xl">
                        <?php echo esc_html($hero_cta); ?>
                    </a>
                    <a href="<?php echo esc_url($hero_cta2_url); ?>" class="btn btn--secondary btn--xl">
                        <?php echo esc_html($hero_cta2); ?>
                    </a>
                </div>

                <!-- Social Proof -->
                <div class="hero__social-proof">
                    <div class="hero__avatars">
                        <?php for ($i = 1; $i <= 4; $i++) : ?>
                            <img src="https://i.pravatar.cc/80?img=<?php echo $i + 10; ?>"
                                 alt=""
                                 class="hero__avatar"
                                 loading="eager"
                                 width="40"
                                 height="40">
                        <?php endfor; ?>
                    </div>
                    <div>
                        <div class="hero__social-stars" aria-label="5 stars">★★★★★</div>
                        <p class="hero__social-text">
                            <strong>50,000+</strong> <?php esc_html_e('happy customers', 'pod-starter'); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Hero Image -->
            <div class="hero__image-wrapper">
                <div class="hero__image">
                    <?php if ($hero_image) : ?>
                        <img src="<?php echo esc_url($hero_image); ?>"
                             alt="<?php esc_attr_e('Custom product showcase', 'pod-starter'); ?>"
                             loading="eager"
                             fetchpriority="high"
                             width="580"
                             height="580">
                    <?php endif; ?>
                </div>

                <!-- Floating Cards -->
                <div class="hero__float-card hero__float-card--sales">
                    <span style="font-size: 28px;">📦</span>
                    <div>
                        <strong style="display: block; font-size: 14px;"><?php esc_html_e('Just sold!', 'pod-starter'); ?></strong>
                        <small style="color: var(--color-gray-500);"><?php esc_html_e('Custom Hoodie — 2 min ago', 'pod-starter'); ?></small>
                    </div>
                </div>

                <div class="hero__float-card hero__float-card--rating">
                    <div style="font-size: 24px; margin-bottom: 4px;">⭐</div>
                    <strong style="font-size: 20px;">4.9</strong>
                    <small style="display: block; color: var(--color-gray-500);"><?php esc_html_e('2,847 reviews', 'pod-starter'); ?></small>
                </div>
            </div>
        </div>
    </div>
</section>