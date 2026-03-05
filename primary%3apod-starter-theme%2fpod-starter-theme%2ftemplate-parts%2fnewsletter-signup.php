<?php
/**
 * Newsletter signup section
 *
 * @package POD_Starter_Pro
 */
?>
<section class="newsletter-section section-padding">
    <div class="container">
        <div class="newsletter-inner text-center" data-animate>
            <h2><?php esc_html_e( 'Get Exclusive Deals & New Designs', 'pod-starter' ); ?></h2>
            <p><?php esc_html_e( 'Subscribe to our newsletter and be the first to know about new products and special offers.', 'pod-starter' ); ?></p>
            <form class="newsletter-form" action="#" method="post">
                <?php wp_nonce_field( 'pod_newsletter', 'pod_newsletter_nonce' ); ?>
                <div class="newsletter-form__group">
                    <input type="email" name="email" placeholder="<?php esc_attr_e( 'Enter your email address', 'pod-starter' ); ?>" required>
                    <button type="submit" class="btn btn--primary"><?php esc_html_e( 'Subscribe', 'pod-starter' ); ?></button>
                </div>
            </form>
        </div>
    </div>
</section>
