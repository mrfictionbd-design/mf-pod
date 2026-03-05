<?php
/**
 * Live Preview / Mockup Generator template part
 *
 * @package POD_Starter_Pro
 */
?>
<section class="live-preview-section section-padding" id="live-preview">
    <div class="container">
        <div class="section-header text-center">
            <h2><?php esc_html_e( 'Design Your Product', 'pod-starter' ); ?></h2>
            <p><?php esc_html_e( 'Upload your design and see it live on the product!', 'pod-starter' ); ?></p>
        </div>
        <div class="mockup-wrapper">
            <div class="mockup-container">
                <canvas id="mockup-canvas" width="600" height="600"></canvas>
            </div>
            <div class="mockup-controls">
                <div class="control-group">
                    <label for="mockup-product-select"><?php esc_html_e( 'Choose Product:', 'pod-starter' ); ?></label>
                    <select id="mockup-product-select">
                        <option value="tshirt"><?php esc_html_e( 'T-Shirt', 'pod-starter' ); ?></option>
                        <option value="hoodie"><?php esc_html_e( 'Hoodie', 'pod-starter' ); ?></option>
                        <option value="mug"><?php esc_html_e( 'Mug', 'pod-starter' ); ?></option>
                    </select>
                </div>
                <div class="control-group">
                    <label for="design-upload"><?php esc_html_e( 'Upload Your Design:', 'pod-starter' ); ?></label>
                    <input type="file" id="design-upload" accept="image/*">
                </div>
                <button class="mockup-btn btn btn--primary" id="add-design-btn">
                    <?php esc_html_e( 'Apply Design', 'pod-starter' ); ?>
                </button>
                <button class="mockup-btn btn btn--outline" id="download-mockup-btn">
                    <?php esc_html_e( 'Download Preview', 'pod-starter' ); ?>
                </button>
            </div>
        </div>
    </div>
</section>
