<?php
/**
 * Homepage template
 *
 * @package POD_Starter_Pro
 */

get_header();
?>

<main id="main-content" class="site-main" role="main">

    <!-- ===================== HERO SECTION ===================== -->
    <?php get_template_part('template-parts/hero-section'); ?>

    <!-- ===================== CATEGORY GRID ===================== -->
    <section class="categories section" data-animate="fade-up">
        <div class="container">
            <div class="categories__header">
                <span class="section-label"><?php esc_html_e('Browse Collection', 'pod-starter'); ?></span>
                <h2 class="section-title"><?php esc_html_e('Shop by Category', 'pod-starter'); ?></h2>
                <p class="section-subtitle mx-auto">
                    <?php esc_html_e('Find the perfect canvas for your creativity across our curated product categories.', 'pod-starter'); ?>
                </p>
            </div>
            <?php echo do_shortcode('[pod_category_grid count="6"]'); ?>
        </div>
    </section>

    <!-- ===================== FEATURED PRODUCTS ===================== -->
    <section class="products-section section" data-animate="fade-up">
        <div class="container">
            <div class="categories__header">
                <span class="section-label"><?php esc_html_e('Trending Now', 'pod-starter'); ?></span>
                <h2 class="section-title"><?php esc_html_e('Featured Products', 'pod-starter'); ?></h2>
                <p class="section-subtitle mx-auto">
                    <?php esc_html_e('Our most popular custom products, loved by thousands of customers worldwide.', 'pod-starter'); ?>
                </p>
            </div>

            <?php
            if (pod_is_woocommerce_active()) {
                echo do_shortcode('[products limit="8" columns="4" visibility="featured" orderby="popularity"]');
            }
            ?>

            <div class="text-center mt-lg">
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn--primary btn--lg">
                    <?php esc_html_e('View All Products', 'pod-starter'); ?> →
                </a>
            </div>
        </div>
    </section>

    <!-- ===================== LIVE PREVIEW / MOCKUP SECTION ===================== -->
    <section class="mockup-section section--spacious" data-animate="fade-up">
        <div class="container">
            <div class="mockup-grid">
                <!-- Mockup Canvas -->
                <div class="mockup-preview">
                    <div class="mockup-canvas-container">
                        <canvas id="mockup-canvas" width="400" height="500"></canvas>
                    </div>
                </div>

                <!-- Controls -->
                <div class="mockup-controls">
                    <span class="section-label" style="color: var(--color-secondary);">
                        <?php esc_html_e('Design Studio', 'pod-starter'); ?>
                    </span>
                    <h2 class="mockup-controls__heading">
                        <?php esc_html_e('See Your Design Come to Life', 'pod-starter'); ?>
                    </h2>
                    <p class="mockup-controls__description">
                        <?php esc_html_e('Upload your artwork, add custom text, choose colors — and instantly preview how it looks on real products.', 'pod-starter'); ?>
                    </p>

                    <!-- Product Selector -->
                    <div class="form-group">
                        <label class="form-label" style="color: rgba(255,255,255,0.7);">
                            <?php esc_html_e('Select Product', 'pod-starter'); ?>
                        </label>
                        <div class="mockup-product-selector">
                            <button class="mockup-product-btn is-active" data-product="tshirt">👕 <?php esc_html_e('T-Shirt', 'pod-starter'); ?></button>
                            <button class="mockup-product-btn" data-product="hoodie">🧥 <?php esc_html_e('Hoodie', 'pod-starter'); ?></button>
                            <button class="mockup-product-btn" data-product="mug">☕ <?php esc_html_e('Mug', 'pod-starter'); ?></button>
                        </div>
                    </div>

                    <!-- Color Picker -->
                    <div class="form-group">
                        <label class="form-label" style="color: rgba(255,255,255,0.7);">
                            <?php esc_html_e('Product Color', 'pod-starter'); ?>
                        </label>
                        <div class="mockup-color-picker">
                            <button class="mockup-color-swatch is-active" style="background: #FFFFFF" data-color="#FFFFFF" aria-label="White"></button>
                            <button class="mockup-color-swatch" style="background: #0A0A0A" data-color="#0A0A0A" aria-label="Black"></button>
                            <button class="mockup-color-swatch" style="background: #2D3436" data-color="#2D3436" aria-label="Dark Gray"></button>
                            <button class="mockup-color-swatch" style="background: #D63031" data-color="#D63031" aria-label="Red"></button>
                            <button class="mockup-color-swatch" style="background: #0984E3" data-color="#0984E3" aria-label="Blue"></button>
                            <button class="mockup-color-swatch" style="background: #00B894" data-color="#00B894" aria-label="Green"></button>
                            <button class="mockup-color-swatch" style="background: #6C5CE7" data-color="#6C5CE7" aria-label="Purple"></button>
                            <button class="mockup-color-swatch" style="background: #FDCB6E" data-color="#FDCB6E" aria-label="Yellow"></button>
                        </div>
                    </div>

                    <!-- Upload Zone -->
                    <div class="form-group">
                        <label class="form-label" style="color: rgba(255,255,255,0.7);">
                            <?php esc_html_e('Upload Your Design', 'pod-starter'); ?>
                        </label>
                        <div class="mockup-upload-zone" id="mockup-upload-zone">
                            <div class="mockup-upload-zone__icon"><?php echo pod_icon('upload', 48); ?></div>
                            <p class="mockup-upload-zone__text">
                                <strong><?php esc_html_e('Click to upload', 'pod-starter'); ?></strong>
                                <?php esc_html_e('or drag and drop', 'pod-starter'); ?><br>
                                <small>PNG, JPG, SVG (max 25MB)</small>
                            </p>
                            <input type="file" id="mockup-file-input" accept="image/*" class="visually-hidden">
                        </div>
                    </div>

                    <!-- Custom Text -->
                    <div class="form-group">
                        <label class="form-label" style="color: rgba(255,255,255,0.7);">
                            <?php esc_html_e('Add Custom Text', 'pod-starter'); ?>
                        </label>
                        <input type="text"
                               class="mockup-text-input"
                               id="mockup-text-input"
                               placeholder="<?php esc_attr_e('Type your text here...', 'pod-starter'); ?>"
                               maxlength="100">
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex--gap-sm">
                        <button class="btn btn--primary btn--lg" id="mockup-add-to-cart">
                            <?php echo pod_icon('cart', 20); ?>
                            <?php esc_html_e('Add to Cart', 'pod-starter'); ?>
                        </button>
                        <button class="btn btn--secondary btn--lg" id="mockup-download" style="border-color: rgba(255,255,255,0.3); color: white;">
                            <?php esc_html_e('Download Preview', 'pod-starter'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== TRUST / SOCIAL PROOF ===================== -->
    <section class="section bg-light" data-animate="fade-up">
        <div class="container">
            <div class="grid grid--4" style="text-align: center;">
                <div>
                    <h3 class="text-gradient" style="font-size: var(--font-size-3xl);">50K+</h3>
                    <p style="color: var(--color-gray-600);"><?php esc_html_e('Happy Customers', 'pod-starter'); ?></p>
                </div>
                <div>
                    <h3 class="text-gradient" style="font-size: var(--font-size-3xl);">200K+</h3>
                    <p style="color: var(--color-gray-600);"><?php esc_html_e('Products Sold', 'pod-starter'); ?></p>
                </div>
                <div>
                    <h3 class="text-gradient" style="font-size: var(--font-size-3xl);">4.9</h3>
                    <p style="color: var(--color-gray-600);"><?php esc_html_e('Average Rating', 'pod-starter'); ?></p>
                </div>
                <div>
                    <h3 class="text-gradient" style="font-size: var(--font-size-3xl);">150+</h3>
                    <p style="color: var(--color-gray-600);"><?php esc_html_e('Countries Shipped', 'pod-starter'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== NEWSLETTER ===================== -->
    <section class="section" data-animate="fade-up" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));">
        <div class="container container--narrow text-center">
            <h2 style="color: white; margin-bottom: var(--space-sm);">
                <?php esc_html_e('Get 10% Off Your First Order', 'pod-starter'); ?>
            </h2>
            <p style="color: rgba(255,255,255,0.8); margin-bottom: var(--space-lg); margin-inline: auto;">
                <?php esc_html_e('Join our community of creators. Get exclusive designs, early access to new products, and special offers.', 'pod-starter'); ?>
            </p>
            <form class="flex flex--center flex--gap-sm flex--wrap" style="max-width: 500px; margin: 0 auto;">
                <input type="email"
                       class="form-input"
                       placeholder="<?php esc_attr_e('Enter your email', 'pod-starter'); ?>"
                       style="flex: 1; min-width: 250px; border-color: rgba(255,255,255,0.3); background: rgba(255,255,255,0.1); color: white;"
                       required>
                <button type="submit" class="btn btn--white btn--lg">
                    <?php esc_html_e('Get 10% Off', 'pod-starter'); ?>
                </button>
            </form>
        </div>
    </section>

</main>

<?php
get_footer();