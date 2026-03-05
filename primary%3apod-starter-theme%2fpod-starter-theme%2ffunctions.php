<?php
/**
 * POD Starter Pro - Theme Functions
 *
 * @package     POD_Starter_Pro
 * @version     2.0.0
 * @author      Your Name
 * @license     GPL-2.0+
 * @link        https://yoursite.com
 *
 * @requires    PHP 8.1+
 * @requires    WordPress 6.4+
 * @requires    WooCommerce 8.0+
 */

defined('ABSPATH') || exit;

// ============================================================================
// THEME CONSTANTS
// ============================================================================

define('POD_THEME_VERSION', '2.0.0');
define('POD_THEME_DIR', get_template_directory());
define('POD_THEME_URI', get_template_directory_uri());
define('POD_THEME_INC', POD_THEME_DIR . '/inc');
define('POD_THEME_ASSETS', POD_THEME_URI . '/assets');
define('POD_MIN_PHP_VERSION', '8.1');
define('POD_MIN_WP_VERSION', '6.4');

// ============================================================================
// PHP VERSION CHECK
// ============================================================================

if (version_compare(PHP_VERSION, POD_MIN_PHP_VERSION, '<')) {
    add_action('admin_notices', function () {
        printf(
            '<div class="notice notice-error"><p><strong>POD Starter Pro</strong> requires PHP %s or later. You are running PHP %s.</p></div>',
            esc_html(POD_MIN_PHP_VERSION),
            esc_html(PHP_VERSION)
        );
    });
    return;
}

// ============================================================================
// 1. THEME SETUP
// ============================================================================

add_action('after_setup_theme', 'pod_theme_setup');
function pod_theme_setup(): void
{
    // Text domain for translations
    load_theme_textdomain('pod-starter', POD_THEME_DIR . '/languages');

    // Theme supports
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
        'navigation-widgets',
    ]);
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 350,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('custom-background', [
        'default-color' => 'ffffff',
    ]);
    add_theme_support('customize-selective-refresh-widgets');

    // Gutenberg / Block Editor support
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');
    add_theme_support('editor-color-palette', [
        ['name' => __('Primary', 'pod-starter'), 'slug' => 'primary', 'color' => '#6C5CE7'],
        ['name' => __('Secondary', 'pod-starter'), 'slug' => 'secondary', 'color' => '#00CEC9'],
        ['name' => __('Accent', 'pod-starter'), 'slug' => 'accent', 'color' => '#FD79A8'],
        ['name' => __('Dark', 'pod-starter'), 'slug' => 'dark', 'color' => '#212529'],
        ['name' => __('Light', 'pod-starter'), 'slug' => 'light', 'color' => '#F8F9FA'],
        ['name' => __('White', 'pod-starter'), 'slug' => 'white', 'color' => '#FFFFFF'],
    ]);
    add_theme_support('editor-font-sizes', [
        ['name' => __('Small', 'pod-starter'), 'shortName' => 'S', 'size' => 14, 'slug' => 'small'],
        ['name' => __('Normal', 'pod-starter'), 'shortName' => 'M', 'size' => 18, 'slug' => 'normal'],
        ['name' => __('Large', 'pod-starter'), 'shortName' => 'L', 'size' => 24, 'slug' => 'large'],
        ['name' => __('Huge', 'pod-starter'), 'shortName' => 'XL', 'size' => 36, 'slug' => 'huge'],
    ]);

    // Image sizes for products
    add_image_size('pod-product-card', 600, 600, true);
    add_image_size('pod-product-large', 1200, 1200, true);
    add_image_size('pod-category-thumb', 480, 600, true);
    add_image_size('pod-hero', 1920, 1080, false);
    add_image_size('pod-mockup', 800, 1000, false);

    // Navigation menus
    register_nav_menus([
        'primary'       => __('Primary Navigation', 'pod-starter'),
        'mobile'        => __('Mobile Navigation', 'pod-starter'),
        'footer-1'      => __('Footer Column 1', 'pod-starter'),
        'footer-2'      => __('Footer Column 2', 'pod-starter'),
        'footer-3'      => __('Footer Column 3', 'pod-starter'),
        'footer-legal'  => __('Footer Legal Links', 'pod-starter'),
    ]);

    // Content width
    $GLOBALS['content_width'] = apply_filters('pod_content_width', 1320);
}

// ============================================================================
// 2. ENQUEUE SCRIPTS & STYLES
// ============================================================================

add_action('wp_enqueue_scripts', 'pod_enqueue_assets');
function pod_enqueue_assets(): void
{
    // ---------- CSS ----------
    // Google Fonts: Inter + Playfair Display
    wp_enqueue_style(
        'pod-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;600;700;800&display=swap',
        [],
        null
    );

    // Main theme stylesheet
    wp_enqueue_style(
        'pod-style',
        get_stylesheet_uri(),
        ['pod-google-fonts'],
        POD_THEME_VERSION
    );

    // Additional CSS
    wp_enqueue_style(
        'pod-main-css',
        POD_THEME_ASSETS . '/css/main.css',
        ['pod-style'],
        POD_THEME_VERSION
    );

    // WooCommerce custom styles (only on WC pages)
    if (class_exists('WooCommerce')) {
        wp_enqueue_style(
            'pod-woocommerce-css',
            POD_THEME_ASSETS . '/css/woocommerce-custom.css',
            ['pod-style'],
            POD_THEME_VERSION
        );
    }

    // Responsive CSS
    wp_enqueue_style(
        'pod-responsive-css',
        POD_THEME_ASSETS . '/css/responsive.css',
        ['pod-style'],
        POD_THEME_VERSION
    );

    // ---------- JS ----------
    // Main theme JS
    wp_enqueue_script(
        'pod-main-js',
        POD_THEME_ASSETS . '/js/main.js',
        [],
        POD_THEME_VERSION,
        true
    );

    // AJAX Cart
    if (class_exists('WooCommerce')) {
        wp_enqueue_script(
            'pod-ajax-cart',
            POD_THEME_ASSETS . '/js/ajax-cart.js',
            ['jquery', 'wc-cart-fragments'],
            POD_THEME_VERSION,
            true
        );

        wp_localize_script('pod-ajax-cart', 'podCart', [
            'ajaxUrl'   => admin_url('admin-ajax.php'),
            'nonce'     => wp_create_nonce('pod-cart-nonce'),
            'cartUrl'   => wc_get_cart_url(),
            'i18n'      => [
                'added'   => __('Added to cart!', 'pod-starter'),
                'error'   => __('Could not add to cart.', 'pod-starter'),
                'viewCart' => __('View Cart', 'pod-starter'),
            ],
        ]);
    }

    // Fabric.js for Mockup Generator (only on relevant pages)
    if (is_page_template('template-parts/live-preview.php') || is_product()) {
        wp_enqueue_style(
            'pod-mockup-css',
            POD_THEME_ASSETS . '/css/mockup-generator.css',
            [],
            POD_THEME_VERSION
        );

        wp_enqueue_script(
            'fabric-js',
            'https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js',
            [],
            '5.3.1',
            true
        );

        wp_enqueue_script(
            'pod-mockup-js',
            POD_THEME_ASSETS . '/js/mockup-generator.js',
            ['fabric-js'],
            POD_THEME_VERSION,
            true
        );

        wp_localize_script('pod-mockup-js', 'podMockup', [
            'ajaxUrl'    => admin_url('admin-ajax.php'),
            'nonce'      => wp_create_nonce('pod-mockup-nonce'),
            'assetsUrl'  => POD_THEME_ASSETS . '/images/',
            'mockups'    => [
                'tshirt' => POD_THEME_ASSETS . '/images/mockup-tshirt.png',
                'hoodie' => POD_THEME_ASSETS . '/images/mockup-hoodie.png',
                'mug'    => POD_THEME_ASSETS . '/images/mockup-mug.png',
            ],
            'printAreas' => [
                'tshirt' => ['x' => 150, 'y' => 120, 'width' => 200, 'height' => 260],
                'hoodie' => ['x' => 140, 'y' => 130, 'width' => 220, 'height' => 240],
                'mug'    => ['x' => 100, 'y' => 80, 'width' => 200, 'height' => 200],
            ],
        ]);
    }

    // AI Chatbot
    wp_enqueue_script(
        'pod-chatbot-js',
        POD_THEME_ASSETS . '/js/ai-chatbot.js',
        [],
        POD_THEME_VERSION,
        true
    );

    wp_localize_script('pod-chatbot-js', 'podChatbot', [
        'ajaxUrl'  => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('pod-chatbot-nonce'),
        'restUrl'  => rest_url('pod/v1/'),
        'restNonce' => wp_create_nonce('wp_rest'),
        'i18n'     => [
            'greeting'     => __('Hi there! 👋 How can I help you today?', 'pod-starter'),
            'placeholder'  => __('Type your message...', 'pod-starter'),
            'typingText'   => __('is typing...', 'pod-starter'),
            'errorMessage' => __('Sorry, something went wrong. Please try again.', 'pod-starter'),
        ],
        'quickReplies' => [
            __('Track my order', 'pod-starter'),
            __('Product customization', 'pod-starter'),
            __('Shipping info', 'pod-starter'),
            __('Return policy', 'pod-starter'),
        ],
    ]);

    // Lazy load images
    wp_enqueue_script(
        'pod-lazy-load',
        POD_THEME_ASSETS . '/js/lazy-load.js',
        [],
        POD_THEME_VERSION,
        true
    );

    // Remove default WP block CSS if using Elementor
    if (defined('ELEMENTOR_VERSION')) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style');
    }
}

// Admin editor styles
add_action('enqueue_block_editor_assets', 'pod_editor_assets');
function pod_editor_assets(): void
{
    wp_enqueue_style(
        'pod-editor-style',
        POD_THEME_ASSETS . '/css/editor-style.css',
        [],
        POD_THEME_VERSION
    );
}

// ============================================================================
// 3. WOOCOMMERCE SETUP & INTEGRATION
// ============================================================================

add_action('after_setup_theme', 'pod_woocommerce_support');
function pod_woocommerce_support(): void
{
    add_theme_support('woocommerce', [
        'thumbnail_image_width' => 600,
        'single_image_width'    => 1200,
        'product_grid'          => [
            'default_rows'    => 3,
            'min_rows'        => 1,
            'max_rows'        => 6,
            'default_columns' => 4,
            'min_columns'     => 1,
            'max_columns'     => 6,
        ],
    ]);
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

// Check if WooCommerce is active
function pod_is_woocommerce_active(): bool
{
    return class_exists('WooCommerce');
}

// WooCommerce hooks
add_action('init', 'pod_woocommerce_hooks');
function pod_woocommerce_hooks(): void
{
    if (!pod_is_woocommerce_active()) return;

    // Remove default WooCommerce wrappers
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

    // Add custom wrappers
    add_action('woocommerce_before_main_content', 'pod_wc_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'pod_wc_wrapper_end', 10);

    // Remove default sidebar from shop
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

    // Customize product loop
    remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

    // Add "Customize" button to products
    add_action('woocommerce_after_shop_loop_item', 'pod_add_customize_button', 15);

    // Add AJAX add to cart for variable products
    add_filter('woocommerce_loop_add_to_cart_args', 'pod_loop_add_to_cart_args', 10, 2);
}

function pod_wc_wrapper_start(): void
{
    echo '<main id="main-content" class="site-main"><div class="container">';
}

function pod_wc_wrapper_end(): void
{
    echo '</div></main>';
}

function pod_add_customize_button(): void
{
    global $product;
    if ($product && $product->is_type('simple')) {
        printf(
            '<a href="%s" class="btn btn--sm btn--ghost pod-customize-link" data-product-id="%d">%s</a>',
            esc_url(get_permalink($product->get_id()) . '#customize'),
            esc_attr($product->get_id()),
            esc_html__('🎨 Customize', 'pod-starter')
        );
    }
}

function pod_loop_add_to_cart_args(array $args, $product): array
{
    $args['class'] .= ' pod-ajax-add-to-cart';
    return $args;
}

// AJAX add to cart handler
add_action('wp_ajax_pod_add_to_cart', 'pod_ajax_add_to_cart');
add_action('wp_ajax_nopriv_pod_add_to_cart', 'pod_ajax_add_to_cart');
function pod_ajax_add_to_cart(): void
{
    check_ajax_referer('pod-cart-nonce', 'nonce');

    $product_id = absint($_POST['product_id'] ?? 0);
    $quantity   = absint($_POST['quantity'] ?? 1);

    if (!$product_id) {
        wp_send_json_error(['message' => __('Invalid product.', 'pod-starter')]);
    }

    $product = wc_get_product($product_id);
    if (!$product) {
        wp_send_json_error(['message' => __('Product not found.', 'pod-starter')]);
    }

    // Handle custom design data
    $cart_item_data = [];
    if (!empty($_POST['custom_design'])) {
        $cart_item_data['pod_custom_design'] = sanitize_text_field(wp_unslash($_POST['custom_design']));
    }
    if (!empty($_POST['custom_text'])) {
        $cart_item_data['pod_custom_text'] = sanitize_text_field(wp_unslash($_POST['custom_text']));
    }
    if (!empty($_POST['design_color'])) {
        $cart_item_data['pod_design_color'] = sanitize_hex_color(wp_unslash($_POST['design_color']));
    }

    $cart_key = WC()->cart->add_to_cart($product_id, $quantity, 0, [], $cart_item_data);

    if ($cart_key) {
        wp_send_json_success([
            'message'    => __('Product added to cart!', 'pod-starter'),
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'cart_total' => WC()->cart->get_cart_total(),
            'cart_hash'  => WC()->cart->get_cart_hash(),
        ]);
    } else {
        wp_send_json_error(['message' => __('Could not add product to cart.', 'pod-starter')]);
    }
}

// Display custom design data in cart and order
add_filter('woocommerce_get_item_data', 'pod_display_custom_design_cart', 10, 2);
function pod_display_custom_design_cart(array $item_data, array $cart_item): array
{
    if (!empty($cart_item['pod_custom_text'])) {
        $item_data[] = [
            'key'   => __('Custom Text', 'pod-starter'),
            'value' => esc_html($cart_item['pod_custom_text']),
        ];
    }
    if (!empty($cart_item['pod_design_color'])) {
        $item_data[] = [
            'key'   => __('Product Color', 'pod-starter'),
            'value' => esc_html($cart_item['pod_design_color']),
        ];
    }
    if (!empty($cart_item['pod_custom_design'])) {
        $item_data[] = [
            'key'   => __('Custom Design', 'pod-starter'),
            'value' => __('✓ Custom design uploaded', 'pod-starter'),
        ];
    }
    return $item_data;
}

// Save custom data to order items
add_action('woocommerce_checkout_create_order_line_item', 'pod_save_custom_design_order', 10, 4);
function pod_save_custom_design_order($item, $cart_item_key, $values, $order): void
{
    if (!empty($values['pod_custom_text'])) {
        $item->add_meta_data(__('Custom Text', 'pod-starter'), sanitize_text_field($values['pod_custom_text']), true);
    }
    if (!empty($values['pod_design_color'])) {
        $item->add_meta_data(__('Product Color', 'pod-starter'), sanitize_text_field($values['pod_design_color']), true);
    }
    if (!empty($values['pod_custom_design'])) {
        $item->add_meta_data(__('Custom Design URL', 'pod-starter'), esc_url($values['pod_custom_design']), true);
    }
}

// ============================================================================
// 4. PRINTIFY / PRINTFUL API INTEGRATION
// ============================================================================

class POD_API_Handler
{
    private string $provider;
    private string $api_key;
    private string $base_url;
    private array $headers;

    public function __construct()
    {
        $this->provider = get_option('pod_provider', 'printify');
        $this->api_key  = get_option('pod_api_key', '');

        if ($this->provider === 'printify') {
            $this->base_url = 'https://api.printify.com/v1/';
            $this->headers  = [
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type'  => 'application/json',
            ];
        } else {
            $this->base_url = 'https://api.printful.com/';
            $this->headers  = [
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type'  => 'application/json',
            ];
        }
    }

    /**
     * Make API request with caching
     */
    private function request(string $endpoint, string $method = 'GET', array $body = []): array|WP_Error
    {
        if (empty($this->api_key)) {
            return new WP_Error('no_api_key', __('POD API key not configured.', 'pod-starter'));
        }

        // Check transient cache for GET requests
        if ($method === 'GET') {
            $cache_key = 'pod_api_' . md5($endpoint);
            $cached    = get_transient($cache_key);
            if ($cached !== false) {
                return $cached;
            }
        }

        $args = [
            'method'  => $method,
            'headers' => $this->headers,
            'timeout' => 30,
        ];

        if (!empty($body)) {
            $args['body'] = wp_json_encode($body);
        }

        $response = wp_remote_request($this->base_url . $endpoint, $args);

        if (is_wp_error($response)) {
            error_log('POD API Error: ' . $response->get_error_message());
            return $response;
        }

        $status = wp_remote_retrieve_response_code($response);
        $data   = json_decode(wp_remote_retrieve_body($response), true);

        if ($status >= 400) {
            $error_msg = $data['message'] ?? "API error (HTTP {$status})";
            error_log("POD API Error [{$status}]: {$error_msg}");
            return new WP_Error('api_error', $error_msg, ['status' => $status]);
        }

        // Cache GET responses for 5 minutes
        if ($method === 'GET') {
            set_transient($cache_key, $data, 5 * MINUTE_IN_SECONDS);
        }

        return $data;
    }

    /**
     * Get available products/catalog
     */
    public function get_catalog(): array|WP_Error
    {
        if ($this->provider === 'printify') {
            return $this->request('catalog/blueprints.json');
        }
        return $this->request('products');
    }

    /**
     * Get specific product details
     */
    public function get_product(int $product_id): array|WP_Error
    {
        if ($this->provider === 'printify') {
            $shop_id = get_option('pod_printify_shop_id', '');
            return $this->request("shops/{$shop_id}/products/{$product_id}.json");
        }
        return $this->request("store/products/{$product_id}");
    }

    /**
     * Create a product with custom design
     */
    public function create_product(array $product_data): array|WP_Error
    {
        if ($this->provider === 'printify') {
            $shop_id = get_option('pod_printify_shop_id', '');
            return $this->request("shops/{$shop_id}/products.json", 'POST', $product_data);
        }
        return $this->request('store/products', 'POST', $product_data);
    }

    /**
     * Submit order for fulfillment
     */
    public function submit_order(int $order_id, array $items): array|WP_Error
    {
        if ($this->provider === 'printify') {
            $shop_id = get_option('pod_printify_shop_id', '');
            return $this->request("shops/{$shop_id}/orders.json", 'POST', [
                'external_id' => (string) $order_id,
                'line_items'  => $items,
            ]);
        }
        return $this->request('orders', 'POST', [
            'external_id' => (string) $order_id,
            'items'       => $items,
        ]);
    }

    /**
     * Upload design image to POD provider
     */
    public function upload_image(string $image_url): array|WP_Error
    {
        if ($this->provider === 'printify') {
            return $this->request('uploads/images.json', 'POST', [
                'file_name' => basename($image_url),
                'url'       => $image_url,
            ]);
        }
        return $this->request('files', 'POST', [
            'type' => 'default',
            'url'  => $image_url,
        ]);
    }

    /**
     * Get shipping rates
     */
    public function get_shipping_rates(array $params): array|WP_Error
    {
        if ($this->provider === 'printify') {
            $shop_id = get_option('pod_printify_shop_id', '');
            return $this->request("shops/{$shop_id}/orders/shipping.json", 'POST', $params);
        }
        return $this->request('shipping/rates', 'POST', $params);
    }

    /**
     * Get order status from POD provider
     */
    public function get_order_status(string $external_id): array|WP_Error
    {
        if ($this->provider === 'printify') {
            $shop_id = get_option('pod_printify_shop_id', '');
            return $this->request("shops/{$shop_id}/orders.json?external_id={$external_id}");
        }
        return $this->request("orders?external_id={$external_id}");
    }
}

// Initialize POD API globally
function pod_api(): POD_API_Handler
{
    static $instance = null;
    if ($instance === null) {
        $instance = new POD_API_Handler();
    }
    return $instance;
}

// Auto-submit orders to POD provider on payment complete
add_action('woocommerce_payment_complete', 'pod_auto_submit_order');
add_action('woocommerce_order_status_processing', 'pod_auto_submit_order');
function pod_auto_submit_order(int $order_id): void
{
    $order = wc_get_order($order_id);
    if (!$order || $order->get_meta('_pod_submitted')) return;

    $items = [];
    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        if (!$product) continue;

        $pod_product_id = $product->get_meta('_pod_product_id');
        if (!$pod_product_id) continue;

        $items[] = [
            'product_id' => $pod_product_id,
            'variant_id' => $product->get_meta('_pod_variant_id'),
            'quantity'    => $item->get_quantity(),
        ];
    }

    if (!empty($items)) {
        $result = pod_api()->submit_order($order_id, $items);
        if (!is_wp_error($result)) {
            $order->update_meta_data('_pod_submitted', true);
            $order->update_meta_data('_pod_order_id', $result['id'] ?? '');
            $order->save();
            $order->add_order_note(__('Order submitted to POD provider for fulfillment.', 'pod-starter'));
        } else {
            $order->add_order_note(
                sprintf(__('POD submission failed: %s', 'pod-starter'), $result->get_error_message())
            );
        }
    }
}

// ============================================================================
// 5. AI PRODUCT DESCRIPTION GENERATOR
// ============================================================================

class POD_AI_Descriptions
{
    private string $api_key;
    private string $model;

    public function __construct()
    {
        $this->api_key = get_option('pod_openai_api_key', '');
        $this->model   = get_option('pod_ai_model', 'gpt-4o-mini');
    }

    /**
     * Generate product description using OpenAI
     */
    public function generate_description(string $product_name, string $category = '', array $attributes = []): string|WP_Error
    {
        if (empty($this->api_key)) {
            return new WP_Error('no_api_key', __('OpenAI API key not configured.', 'pod-starter'));
        }

        $attr_text = '';
        if (!empty($attributes)) {
            $attr_text = "\nProduct attributes: " . implode(', ', array_map(
                fn($k, $v) => "$k: $v",
                array_keys($attributes),
                array_values($attributes)
            ));
        }

        $prompt = sprintf(
            'Write a compelling, SEO-optimized product description for an e-commerce print-on-demand product.

Product name: %s
Category: %s%s

Requirements:
- Write 2-3 engaging paragraphs (150-200 words total)
- Include emotional triggers and benefits
- Mention quality of materials/printing
- Use power words for conversion
- Include a short bullet-point list of key features (4-5 items)
- Be enthusiastic but professional
- Do NOT include the product name as a heading
- Write in second person ("you")
- Optimize for the search keyword: "%s"',
            $product_name,
            $category ?: 'General',
            $attr_text,
            $product_name
        );

        $response = wp_remote_post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type'  => 'application/json',
            ],
            'body'    => wp_json_encode([
                'model'       => $this->model,
                'messages'    => [
                    [
                        'role'    => 'system',
                        'content' => 'You are an expert e-commerce copywriter specializing in print-on-demand products. You write compelling, conversion-focused product descriptions.'
                    ],
                    [
                        'role'    => 'content',
                        'content' => $prompt,
                    ],
                ],
                'max_tokens'  => 500,
                'temperature' => 0.7,
            ]),
            'timeout' => 30,
        ]);

        if (is_wp_error($response)) {
            return $response;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($body['choices'][0]['message']['content'])) {
            return trim($body['choices'][0]['message']['content']);
        }

        return new WP_Error('ai_error', $body['error']['message'] ?? __('AI generation failed.', 'pod-starter'));
    }

    /**
     * Generate SEO meta description
     */
    public function generate_meta_description(string $product_name, string $description): string|WP_Error
    {
        if (empty($this->api_key)) {
            return new WP_Error('no_api_key', __('OpenAI API key not configured.', 'pod-starter'));
        }

        $response = wp_remote_post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type'  => 'application/json',
            ],
            'body'    => wp_json_encode([
                'model'       => $this->model,
                'messages'    => [
                    [
                        'role'    => 'system',
                        'content' => 'Write SEO meta descriptions. Max 155 characters. Include a call to action.',
                    ],
                    [
                        'role'    => 'user',
                        'content' => "Product: {$product_name}\nDescription: {$description}\n\nWrite a meta description.",
                    ],
                ],
                'max_tokens'  => 60,
                'temperature' => 0.5,
            ]),
            'timeout' => 15,
        ]);

        if (is_wp_error($response)) {
            return $response;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        return trim($body['choices'][0]['message']['content'] ?? '');
    }
}

// AJAX handler for AI descriptions (admin)
add_action('wp_ajax_pod_generate_description', 'pod_ajax_generate_description');
function pod_ajax_generate_description(): void
{
    check_ajax_referer('pod-admin-nonce', 'nonce');

    if (!current_user_can('edit_products')) {
        wp_send_json_error(['message' => __('Unauthorized.', 'pod-starter')], 403);
    }

    $product_name = sanitize_text_field($_POST['product_name'] ?? '');
    $category     = sanitize_text_field($_POST['category'] ?? '');
    $attributes   = array_map('sanitize_text_field', (array) ($_POST['attributes'] ?? []));

    if (empty($product_name)) {
        wp_send_json_error(['message' => __('Product name is required.', 'pod-starter')]);
    }

    $ai          = new POD_AI_Descriptions();
    $description = $ai->generate_description($product_name, $category, $attributes);

    if (is_wp_error($description)) {
        wp_send_json_error(['message' => $description->get_error_message()]);
    }

    wp_send_json_success([
        'description' => $description,
    ]);
}

// Add AI button to WooCommerce product editor
add_action('woocommerce_product_options_general_product_data', 'pod_add_ai_button_to_editor');
function pod_add_ai_button_to_editor(): void
{
    if (!get_option('pod_openai_api_key')) return;

    ?>
    <div class="options_group pod-ai-generator">
        <p class="form-field">
            <label><?php esc_html_e('AI Description Generator', 'pod-starter'); ?></label>
            <button type="button" id="pod-generate-description" class="button button-secondary">
                🤖 <?php esc_html_e('Generate with AI', 'pod-starter'); ?>
            </button>
            <span class="description">
                <?php esc_html_e('Auto-generate a compelling product description using AI.', 'pod-starter'); ?>
            </span>
            <span id="pod-ai-loading" style="display:none;">
                <span class="spinner is-active" style="float:none;margin:0;"></span>
                <?php esc_html_e('Generating...', 'pod-starter'); ?>
            </span>
        </p>
    </div>
    <script>
    jQuery(document).ready(function($) {
        $('#pod-generate-description').on('click', function() {
            var productName = $('#title').val() || $('input#post_title').val();
            if (!productName) {
                alert('<?php esc_html_e('Please enter a product name first.', 'pod-starter'); ?>');
                return;
            }

            var $btn = $(this);
            var $loading = $('#pod-ai-loading');

            $btn.prop('disabled', true);
            $loading.show();

            $.ajax({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'pod_generate_description',
                    nonce: '<?php echo wp_create_nonce('pod-admin-nonce'); ?>',
                    product_name: productName,
                    category: $('#product_cat-all input:checked').first().parent().text().trim()
                },
                success: function(response) {
                    if (response.success && response.data.description) {
                        // Set content in WP editor
                        if (typeof wp !== 'undefined' && wp.data) {
                            wp.data.dispatch('core/editor').editPost({
                                content: response.data.description
                            });
                        } else if (typeof tinymce !== 'undefined' && tinymce.get('content')) {
                            tinymce.get('content').setContent(response.data.description);
                        } else {
                            $('#content').val(response.data.description);
                        }
                    } else {
                        alert(response.data?.message || 'Generation failed.');
                    }
                },
                error: function() {
                    alert('Request failed. Please try again.');
                },
                complete: function() {
                    $btn.prop('disabled', false);
                    $loading.hide();
                }
            });
        });
    });
    </script>
    <?php
}

// ============================================================================
// 6. AI CHATBOT BACKEND (REST API)
// ============================================================================

add_action('rest_api_init', 'pod_register_chatbot_endpoints');
function pod_register_chatbot_endpoints(): void
{
    register_rest_route('pod/v1', '/chatbot', [
        'methods'             => 'POST',
        'callback'            => 'pod_chatbot_response',
        'permission_callback' => '__return_true', // Public endpoint
        'args'                => [
            'message' => [
                'required'          => true,
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'session_id' => [
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ],
        ],
    ]);

    register_rest_route('pod/v1', '/chatbot/order-status', [
        'methods'             => 'POST',
        'callback'            => 'pod_chatbot_order_status',
        'permission_callback' => '__return_true',
        'args'                => [
            'order_id' => [
                'required' => true,
                'type'     => 'string',
            ],
            'email' => [
                'required' => true,
                'type'     => 'string',
            ],
        ],
    ]);
}

function pod_chatbot_response(WP_REST_Request $request): WP_REST_Response
{
    $message    = $request->get_param('message');
    $session_id = $request->get_param('session_id') ?: wp_generate_uuid4();

    // Check for common queries first (no AI needed)
    $quick_response = pod_check_quick_responses($message);
    if ($quick_response) {
        return new WP_REST_Response([
            'reply'      => $quick_response,
            'session_id' => $session_id,
            'type'       => 'quick',
        ], 200);
    }

    // Use OpenAI for complex queries
    $api_key = get_option('pod_openai_api_key', '');
    if (empty($api_key)) {
        return new WP_REST_Response([
            'reply'      => __('Thanks for your message! Our team will get back to you shortly. You can also email us at support@yourstore.com.', 'pod-starter'),
            'session_id' => $session_id,
            'type'       => 'fallback',
        ], 200);
    }

    // Build context from store info
    $store_context = pod_build_store_context();

    $response = wp_remote_post('https://api.openai.com/v1/chat/completions', [
        'headers' => [
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type'  => 'application/json',
        ],
        'body'    => wp_json_encode([
            'model'       => 'gpt-4o-mini',
            'messages'    => [
                [
                    'role'    => 'system',
                    'content' => "You are a friendly, helpful customer support agent for an online print-on-demand store. Here's the store info:\n\n{$store_context}\n\nRules:\n- Be concise (2-3 sentences max)\n- Be warm and helpful\n- If you don't know something, direct to support email\n- Never make up order details\n- Suggest products when appropriate",
                ],
                [
                    'role'    => 'user',
                    'content' => $message,
                ],
            ],
            'max_tokens'  => 200,
            'temperature' => 0.7,
        ]),
        'timeout' => 15,
    ]);

    if (is_wp_error($response)) {
        return new WP_REST_Response([
            'reply'      => __('I\'m having trouble connecting right now. Please try again or email support@yourstore.com.', 'pod-starter'),
            'session_id' => $session_id,
            'type'       => 'error',
        ], 200);
    }

    $body  = json_decode(wp_remote_retrieve_body($response), true);
    $reply = $body['choices'][0]['message']['content'] ?? __('I\'m sorry, I couldn\'t process that. Please try again.', 'pod-starter');

    return new WP_REST_Response([
        'reply'      => trim($reply),
        'session_id' => $session_id,
        'type'       => 'ai',
    ], 200);
}

function pod_check_quick_responses(string $message): ?string
{
    $message_lower = strtolower($message);

    $quick_responses = [
        'shipping'    => __('🚚 We offer worldwide shipping! Standard shipping takes 5-12 business days. Express shipping (3-5 days) is available at checkout. Free shipping on orders over $50!', 'pod-starter'),
        'return'      => __('↩️ We accept returns within 30 days of delivery. Items must be unused and in original packaging. Custom/personalized items can be returned if there\'s a quality issue. Start a return at your account page or email support@yourstore.com.', 'pod-starter'),
        'track'       => __('📦 To track your order, go to My Account → Orders, or use the tracking link in your shipping confirmation email. Need help? Share your order number and I\'ll look it up!', 'pod-starter'),
        'payment'     => __('💳 We accept Visa, Mastercard, American Express, PayPal, Apple Pay, and Google Pay. All transactions are encrypted and secure.', 'pod-starter'),
        'custom'      => __('🎨 Yes! You can customize most of our products. Use the "Customize" button on any product page to upload your own design or add text. Our mockup generator lets you preview before ordering!', 'pod-starter'),
        'size'        => __('📏 Size guides are available on each product page. Click "Size Guide" below the size selector. For t-shirts, we recommend going one size up for a relaxed fit. Need specific measurements? Just ask!', 'pod-starter'),
        'discount'    => __('🎉 Sign up for our newsletter to get 10% off your first order! We also run seasonal sales. Follow us on social media to stay updated on deals.', 'pod-starter'),
        'quality'     => __('✨ We use premium materials and advanced direct-to-garment (DTG) printing technology. Colors are vibrant and long-lasting. All products go through quality checks before shipping.', 'pod-starter'),
        'bulk'        => __('📦 Yes, we offer bulk/wholesale pricing! For orders of 25+ items, email wholesale@yourstore.com for a custom quote. Great for teams, events, and businesses.', 'pod-starter'),
    ];

    foreach ($quick_responses as $keyword => $response) {
        if (str_contains($message_lower, $keyword)) {
            return $response;
        }
    }

    return null;
}

function pod_build_store_context(): string
{
    $store_name  = get_bloginfo('name');
    $store_url   = home_url();

    return "Store: {$store_name}
URL: {$store_url}
Type: Print-on-demand e-commerce store
Products: Custom t-shirts, hoodies, mugs, phone cases, posters, tote bags
Shipping: Worldwide, 5-12 business days standard, 3-5 express. Free over \$50.
Returns: 30-day return policy. Quality guarantee on custom items.
Payment: All major credit cards, PayPal, Apple Pay, Google Pay.
Support email: support@yourstore.com
Customization: Customers can upload designs or add custom text.";
}

function pod_chatbot_order_status(WP_REST_Request $request): WP_REST_Response
{
    $order_id = absint($request->get_param('order_id'));
    $email    = sanitize_email($request->get_param('email'));

    if (!$order_id || !$email) {
        return new WP_REST_Response([
            'reply' => __('Please provide both your order number and email address.', 'pod-starter'),
        ], 400);
    }

    $order = wc_get_order($order_id);
    if (!$order || $order->get_billing_email() !== $email) {
        return new WP_REST_Response([
            'reply' => __('Order not found. Please check your order number and email, then try again.', 'pod-starter'),
        ], 404);
    }

    $status       = wc_get_order_status_name($order->get_status());
    $date_created = $order->get_date_created()->date_i18n(get_option('date_format'));
    $total        = $order->get_formatted_order_total();

    $reply = sprintf(
        __("📦 **Order #%d**\n\n• **Status:** %s\n• **Date:** %s\n• **Total:** %s\n\nFor more details, check your email or visit My Account → Orders.", 'pod-starter'),
        $order_id,
        $status,
        $date_created,
        $total
    );

    return new WP_REST_Response(['reply' => $reply], 200);
}

// ============================================================================
// 7. CUSTOM REST API ENDPOINTS (FOR MOBILE APP)
// ============================================================================

add_action('rest_api_init', 'pod_register_custom_rest_routes');
function pod_register_custom_rest_routes(): void
{
    // Featured products
    register_rest_route('pod/v1', '/featured-products', [
        'methods'             => 'GET',
        'callback'            => 'pod_rest_featured_products',
        'permission_callback' => '__return_true',
        'args'                => [
            'per_page' => ['default' => 10, 'type' => 'integer'],
        ],
    ]);

    // Product categories with images
    register_rest_route('pod/v1', '/product-categories', [
        'methods'             => 'GET',
        'callback'            => 'pod_rest_product_categories',
        'permission_callback' => '__return_true',
    ]);

    // Mockup generation
    register_rest_route('pod/v1', '/generate-mockup', [
        'methods'             => 'POST',
        'callback'            => 'pod_rest_generate_mockup',
        'permission_callback' => function () {
            return is_user_logged_in();
        },
    ]);

    // Store config (for mobile app)
    register_rest_route('pod/v1', '/store-config', [
        'methods'             => 'GET',
        'callback'            => 'pod_rest_store_config',
        'permission_callback' => '__return_true',
    ]);
}

function pod_rest_featured_products(WP_REST_Request $request): WP_REST_Response
{
    $per_page = $request->get_param('per_page');

    $args = [
        'status'   => 'publish',
        'featured' => true,
        'limit'    => $per_page,
        'orderby'  => 'date',
        'order'    => 'DESC',
    ];

    $products = wc_get_products($args);
    $data     = [];

    foreach ($products as $product) {
        $data[] = [
            'id'             => $product->get_id(),
            'name'           => $product->get_name(),
            'slug'           => $product->get_slug(),
            'price'          => $product->get_price(),
            'regular_price'  => $product->get_regular_price(),
            'sale_price'     => $product->get_sale_price(),
            'on_sale'        => $product->is_on_sale(),
            'image'          => wp_get_attachment_url($product->get_image_id()),
            'gallery'        => array_map('wp_get_attachment_url', $product->get_gallery_image_ids()),
            'short_desc'     => $product->get_short_description(),
            'permalink'      => get_permalink($product->get_id()),
            'average_rating' => $product->get_average_rating(),
            'review_count'   => $product->get_review_count(),
            'customizable'   => (bool) $product->get_meta('_pod_customizable'),
        ];
    }

    return new WP_REST_Response($data, 200);
}

function pod_rest_product_categories(WP_REST_Request $request): WP_REST_Response
{
    $categories = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'parent'     => 0,
    ]);

    $data = [];
    foreach ($categories as $cat) {
        $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
        $data[]       = [
            'id'          => $cat->term_id,
            'name'        => $cat->name,
            'slug'        => $cat->slug,
            'description' => $cat->description,
            'count'       => $cat->count,
            'image'       => $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : null,
            'link'        => get_term_link($cat),
        ];
    }

    return new WP_REST_Response($data, 200);
}

function pod_rest_generate_mockup(WP_REST_Request $request): WP_REST_Response
{
    $design_url  = esc_url($request->get_param('design_url'));
    $product_type = sanitize_text_field($request->get_param('product_type'));
    $color        = sanitize_hex_color($request->get_param('color'));

    // This would integrate with your mockup generation service
    // For now, return the parameters for client-side Fabric.js rendering
    return new WP_REST_Response([
        'status'       => 'success',
        'design_url'   => $design_url,
        'product_type' => $product_type,
        'color'        => $color,
        'mockup_url'   => null, // Server-side generation would return URL here
    ], 200);
}

function pod_rest_store_config(WP_REST_Request $request): WP_REST_Response
{
    return new WP_REST_Response([
        'store_name'     => get_bloginfo('name'),
        'store_url'      => home_url(),
        'currency'       => get_woocommerce_currency(),
        'currency_symbol' => get_woocommerce_currency_symbol(),
        'logo'           => wp_get_attachment_url(get_theme_mod('custom_logo')),
        'primary_color'  => get_theme_mod('pod_primary_color', '#6C5CE7'),
        'features'       => [
            'customization' => true,
            'ai_chatbot'    => !empty(get_option('pod_openai_api_key')),
            'wishlist'      => true,
        ],
        'social'         => [
            'instagram' => get_option('pod_instagram', ''),
            'facebook'  => get_option('pod_facebook', ''),
            'twitter'   => get_option('pod_twitter', ''),
            'tiktok'    => get_option('pod_tiktok', ''),
        ],
    ], 200);
}

// ============================================================================
// 8. THEME CUSTOMIZER
// ============================================================================

add_action('customize_register', 'pod_customize_register');
function pod_customize_register(WP_Customize_Manager $wp_customize): void
{
    // ---- POD Settings Panel ----
    $wp_customize->add_panel('pod_settings', [
        'title'       => __('POD Store Settings', 'pod-starter'),
        'description' => __('Configure your Print on Demand store settings.', 'pod-starter'),
        'priority'    => 30,
    ]);

    // ---- Brand Colors Section ----
    $wp_customize->add_section('pod_colors', [
        'title' => __('Brand Colors', 'pod-starter'),
        'panel' => 'pod_settings',
    ]);

    $colors = [
        'pod_primary_color'   => ['label' => __('Primary Color', 'pod-starter'), 'default' => '#6C5CE7'],
        'pod_secondary_color' => ['label' => __('Secondary Color', 'pod-starter'), 'default' => '#00CEC9'],
        'pod_accent_color'    => ['label' => __('Accent Color', 'pod-starter'), 'default' => '#FD79A8'],
    ];

    foreach ($colors as $id => $args) {
        $wp_customize->add_setting($id, [
            'default'           => $args['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, [
            'label'   => $args['label'],
            'section' => 'pod_colors',
        ]));
    }

    // ---- Hero Section ----
    $wp_customize->add_section('pod_hero', [
        'title' => __('Hero Section', 'pod-starter'),
        'panel' => 'pod_settings',
    ]);

    $hero_fields = [
        'pod_hero_badge'       => ['label' => __('Hero Badge Text', 'pod-starter'), 'default' => '🔥 New Designs Just Dropped'],
        'pod_hero_title'       => ['label' => __('Hero Title', 'pod-starter'), 'default' => 'Design Your Perfect Custom Products'],
        'pod_hero_subtitle'    => ['label' => __('Hero Subtitle', 'pod-starter'), 'default' => 'Upload your design, preview it in real-time, and order premium quality custom products delivered to your door.'],
        'pod_hero_cta_text'    => ['label' => __('CTA Button Text', 'pod-starter'), 'default' => 'Start Designing'],
        'pod_hero_cta_url'     => ['label' => __('CTA Button URL', 'pod-starter'), 'default' => '/shop'],
        'pod_hero_cta2_text'   => ['label' => __('Secondary CTA Text', 'pod-starter'), 'default' => 'Browse Products'],
        'pod_hero_cta2_url'    => ['label' => __('Secondary CTA URL', 'pod-starter'), 'default' => '/shop'],
    ];

    foreach ($hero_fields as $id => $args) {
        $wp_customize->add_setting($id, [
            'default'           => $args['default'],
            'sanitize_callback' => ($id === 'pod_hero_cta_url' || $id === 'pod_hero_cta2_url')
                ? 'esc_url_raw'
                : 'sanitize_text_field',
            'transport'         => 'postMessage',
        ]);

        $wp_customize->add_control($id, [
            'label'   => $args['label'],
            'section' => 'pod_hero',
            'type'    => str_contains($id, '_url') ? 'url' : 'text',
        ]);
    }

    // Hero Image
    $wp_customize->add_setting('pod_hero_image', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'pod_hero_image', [
        'label'   => __('Hero Product Image', 'pod-starter'),
        'section' => 'pod_hero',
    ]));

    // ---- Social Media Section ----
    $wp_customize->add_section('pod_social', [
        'title' => __('Social Media', 'pod-starter'),
        'panel' => 'pod_settings',
    ]);

    $socials = ['instagram', 'facebook', 'twitter', 'tiktok', 'youtube', 'pinterest'];
    foreach ($socials as $social) {
        $wp_customize->add_setting("pod_{$social}", [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control("pod_{$social}", [
            'label'   => ucfirst($social) . ' URL',
            'section' => 'pod_social',
            'type'    => 'url',
        ]);
    }

    // ---- API Settings Section ----
    $wp_customize->add_section('pod_api_settings', [
        'title'       => __('API Settings', 'pod-starter'),
        'panel'       => 'pod_settings',
        'description' => __('Configure API keys for POD provider and AI features. For security, use Settings → POD Settings in the admin panel for sensitive keys.', 'pod-starter'),
    ]);

    $wp_customize->add_setting('pod_provider', [
        'default'           => 'printify',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('pod_provider', [
        'label'   => __('POD Provider', 'pod-starter'),
        'section' => 'pod_api_settings',
        'type'    => 'select',
        'choices' => [
            'printify' => 'Printify',
            'printful' => 'Printful',
        ],
    ]);

    // ---- Footer Section ----
    $wp_customize->add_section('pod_footer', [
        'title' => __('Footer', 'pod-starter'),
        'panel' => 'pod_settings',
    ]);

    $wp_customize->add_setting('pod_footer_text', [
        'default'           => sprintf('© %d Your Store. All rights reserved.', date('Y')),
        'sanitize_callback' => 'wp_kses_post',
    ]);

    $wp_customize->add_control('pod_footer_text', [
        'label'   => __('Footer Copyright Text', 'pod-starter'),
        'section' => 'pod_footer',
        'type'    => 'textarea',
    ]);

    $wp_customize->add_setting('pod_footer_description', [
        'default'           => __('Premium custom products, designed by you. Quality printing, worldwide shipping.', 'pod-starter'),
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('pod_footer_description', [
        'label'   => __('Footer Brand Description', 'pod-starter'),
        'section' => 'pod_footer',
        'type'    => 'textarea',
    ]);
}

// Output custom CSS from Customizer
add_action('wp_head', 'pod_customizer_css', 999);
function pod_customizer_css(): void
{
    $primary   = get_theme_mod('pod_primary_color', '#6C5CE7');
    $secondary = get_theme_mod('pod_secondary_color', '#00CEC9');
    $accent    = get_theme_mod('pod_accent_color', '#FD79A8');

    // Convert hex to RGB
    $primary_rgb = implode(', ', array_map('hexdec', str_split(ltrim($primary, '#'), 2)));

    ?>
    <style id="pod-customizer-css">
        :root {
            --color-primary: <?php echo esc_attr($primary); ?>;
            --color-primary-rgb: <?php echo esc_attr($primary_rgb); ?>;
            --color-secondary: <?php echo esc_attr($secondary); ?>;
            --color-accent: <?php echo esc_attr($accent); ?>;
        }
    </style>
    <?php
}

// ============================================================================
// 9. ADMIN SETTINGS PAGE
// ============================================================================

add_action('admin_menu', 'pod_admin_menu');
function pod_admin_menu(): void
{
    add_menu_page(
        __('POD Settings', 'pod-starter'),
        __('POD Settings', 'pod-starter'),
        'manage_options',
        'pod-settings',
        'pod_settings_page',
        'dashicons-store',
        58
    );
}

add_action('admin_init', 'pod_register_settings');
function pod_register_settings(): void
{
    // POD Provider Settings
    register_setting('pod_settings_group', 'pod_provider');
    register_setting('pod_settings_group', 'pod_api_key', [
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    register_setting('pod_settings_group', 'pod_printify_shop_id', [
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    // AI Settings
    register_setting('pod_settings_group', 'pod_openai_api_key', [
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    register_setting('pod_settings_group', 'pod_ai_model', [
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'gpt-4o-mini',
    ]);

    // Social Media
    $socials = ['instagram', 'facebook', 'twitter', 'tiktok', 'youtube', 'pinterest'];
    foreach ($socials as $social) {
        register_setting('pod_settings_group', "pod_{$social}", [
            'sanitize_callback' => 'esc_url_raw',
        ]);
    }
}

function pod_settings_page(): void
{
    if (!current_user_can('manage_options')) return;
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('POD Store Settings', 'pod-starter'); ?></h1>

        <form method="post" action="options.php">
            <?php settings_fields('pod_settings_group'); ?>

            <h2 class="nav-tab-wrapper">
                <a href="#pod-tab" class="nav-tab nav-tab-active"><?php esc_html_e('POD Provider', 'pod-starter'); ?></a>
                <a href="#ai-tab" class="nav-tab"><?php esc_html_e('AI Settings', 'pod-starter'); ?></a>
                <a href="#social-tab" class="nav-tab"><?php esc_html_e('Social Media', 'pod-starter'); ?></a>
            </h2>

            <!-- POD Provider Tab -->
            <div id="pod-tab" class="tab-content">
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('POD Provider', 'pod-starter'); ?></th>
                        <td>
                            <select name="pod_provider">
                                <option value="printify" <?php selected(get_option('pod_provider'), 'printify'); ?>>Printify</option>
                                <option value="printful" <?php selected(get_option('pod_provider'), 'printful'); ?>>Printful</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('API Key', 'pod-starter'); ?></th>
                        <td>
                            <input type="password" name="pod_api_key" value="<?php echo esc_attr(get_option('pod_api_key')); ?>" class="regular-text" autocomplete="off" />
                            <p class="description"><?php esc_html_e('Your Printify/Printful API key.', 'pod-starter'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Printify Shop ID', 'pod-starter'); ?></th>
                        <td>
                            <input type="text" name="pod_printify_shop_id" value="<?php echo esc_attr(get_option('pod_printify_shop_id')); ?>" class="regular-text" />
                            <p class="description"><?php esc_html_e('Only required for Printify.', 'pod-starter'); ?></p>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- AI Settings Tab -->
            <div id="ai-tab" class="tab-content" style="display:none;">
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('OpenAI API Key', 'pod-starter'); ?></th>
                        <td>
                            <input type="password" name="pod_openai_api_key" value="<?php echo esc_attr(get_option('pod_openai_api_key')); ?>" class="regular-text" autocomplete="off" />
                            <p class="description"><?php esc_html_e('Powers the AI chatbot and product description generator.', 'pod-starter'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('AI Model', 'pod-starter'); ?></th>
                        <td>
                            <select name="pod_ai_model">
                                <option value="gpt-4o-mini" <?php selected(get_option('pod_ai_model', 'gpt-4o-mini'), 'gpt-4o-mini'); ?>>GPT-4o Mini (Fast & Affordable)</option>
                                <option value="gpt-4o" <?php selected(get_option('pod_ai_model'), 'gpt-4o'); ?>>GPT-4o (Best Quality)</option>
                                <option value="gpt-4-turbo" <?php selected(get_option('pod_ai_model'), 'gpt-4-turbo'); ?>>GPT-4 Turbo</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Social Media Tab -->
            <div id="social-tab" class="tab-content" style="display:none;">
                <table class="form-table">
                    <?php
                    $socials = [
                        'instagram' => 'Instagram',
                        'facebook'  => 'Facebook',
                        'twitter'   => 'X (Twitter)',
                        'tiktok'    => 'TikTok',
                        'youtube'   => 'YouTube',
                        'pinterest' => 'Pinterest',
                    ];
                    foreach ($socials as $key => $label) : ?>
                        <tr>
                            <th scope="row"><?php echo esc_html($label); ?></th>
                            <td>
                                <input type="url" name="pod_<?php echo esc_attr($key); ?>" value="<?php echo esc_url(get_option("pod_{$key}")); ?>" class="regular-text" />
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <?php submit_button(); ?>
        </form>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('.nav-tab').on('click', function(e) {
            e.preventDefault();
            $('.nav-tab').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');
            $('.tab-content').hide();
            $($(this).attr('href')).show();
        });
    });
    </script>
    <?php
}

// ============================================================================
// 10. WIDGET AREAS
// ============================================================================

add_action('widgets_init', 'pod_register_sidebars');
function pod_register_sidebars(): void
{
    $sidebars = [
        'sidebar-shop' => [
            'name'        => __('Shop Sidebar', 'pod-starter'),
            'description' => __('Widgets for the shop page.', 'pod-starter'),
        ],
        'sidebar-product' => [
            'name'        => __('Product Sidebar', 'pod-starter'),
            'description' => __('Widgets for single product pages.', 'pod-starter'),
        ],
        'footer-1' => [
            'name'        => __('Footer Column 1', 'pod-starter'),
            'description' => __('First footer widget area.', 'pod-starter'),
        ],
        'footer-2' => [
            'name'        => __('Footer Column 2', 'pod-starter'),
            'description' => __('Second footer widget area.', 'pod-starter'),
        ],
        'footer-3' => [
            'name'        => __('Footer Column 3', 'pod-starter'),
            'description' => __('Third footer widget area.', 'pod-starter'),
        ],
    ];

    foreach ($sidebars as $id => $args) {
        register_sidebar([
            'name'          => $args['name'],
            'id'            => $id,
            'description'   => $args['description'],
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
    }
}

// ============================================================================
// 11. ELEMENTOR COMPATIBILITY
// ============================================================================

add_action('elementor/theme/register_locations', 'pod_elementor_locations');
function pod_elementor_locations($elementor_theme_manager): void
{
    $elementor_theme_manager->register_all_core_location();
}

// Register Elementor widgets category
add_action('elementor/elements/categories_registered', 'pod_elementor_category');
function pod_elementor_category($elements_manager): void
{
    $elements_manager->add_category('pod-starter', [
        'title' => __('POD Starter', 'pod-starter'),
        'icon'  => 'fa fa-tshirt',
    ]);
}

// Add Elementor-specific body class
add_filter('body_class', 'pod_body_classes');
function pod_body_classes(array $classes): array
{
    if (defined('ELEMENTOR_VERSION')) {
        $classes[] = 'elementor-compatible';
    }

    if (pod_is_woocommerce_active()) {
        if (is_shop()) $classes[] = 'pod-shop-page';
        if (is_product()) $classes[] = 'pod-product-page';
        if (is_cart()) $classes[] = 'pod-cart-page';
        if (is_checkout()) $classes[] = 'pod-checkout-page';
    }

    // Add customizer-based class
    $classes[] = 'pod-theme';

    return $classes;
}

// ============================================================================
// 12. PERFORMANCE & SECURITY
// ============================================================================

// Remove unnecessary WordPress features
add_action('init', 'pod_cleanup_wp_head');
function pod_cleanup_wp_head(): void
{
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
}

// Add security headers
add_action('send_headers', 'pod_security_headers');
function pod_security_headers(): void
{
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    }
}

// Preload critical resources
add_action('wp_head', 'pod_preload_resources', 1);
function pod_preload_resources(): void
{
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <?php
    if (pod_is_woocommerce_active()) {
        echo '<link rel="dns-prefetch" href="//api.printify.com">';
        echo '<link rel="dns-prefetch" href="//api.printful.com">';
    }
}

// Add defer/async to scripts
add_filter('script_loader_tag', 'pod_async_defer_scripts', 10, 3);
function pod_async_defer_scripts(string $tag, string $handle, string $src): string
{
    $async_scripts = ['pod-lazy-load', 'pod-chatbot-js'];
    $defer_scripts = ['pod-mockup-js', 'fabric-js', 'pod-main-js'];

    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }

    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }

    return $tag;
}

// Limit post revisions
if (!defined('WP_POST_REVISIONS')) {
    define('WP_POST_REVISIONS', 5);
}

// ============================================================================
// 13. CUSTOM DESIGN UPLOAD HANDLING
// ============================================================================

add_action('wp_ajax_pod_upload_design', 'pod_handle_design_upload');
add_action('wp_ajax_nopriv_pod_upload_design', 'pod_handle_design_upload');
function pod_handle_design_upload(): void
{
    check_ajax_referer('pod-mockup-nonce', 'nonce');

    if (empty($_FILES['design'])) {
        wp_send_json_error(['message' => __('No file uploaded.', 'pod-starter')]);
    }

    $file = $_FILES['design'];

    // Validate file type
    $allowed_types = ['image/png', 'image/jpeg', 'image/svg+xml', 'image/webp'];
    if (!in_array($file['type'], $allowed_types)) {
        wp_send_json_error(['message' => __('Invalid file type. Please upload PNG, JPG, SVG, or WebP.', 'pod-starter')]);
    }

    // Validate file size (max 25MB)
    $max_size = 25 * 1024 * 1024;
    if ($file['size'] > $max_size) {
        wp_send_json_error(['message' => __('File too large. Maximum size is 25MB.', 'pod-starter')]);
    }

    // Use WordPress upload handling
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    // Upload to a custom directory
    add_filter('upload_dir', 'pod_custom_upload_dir');
    $attachment_id = media_handle_upload('design', 0);
    remove_filter('upload_dir', 'pod_custom_upload_dir');

    if (is_wp_error($attachment_id)) {
        wp_send_json_error(['message' => $attachment_id->get_error_message()]);
    }

    $url = wp_get_attachment_url($attachment_id);

    wp_send_json_success([
        'url'           => $url,
        'attachment_id'  => $attachment_id,
        'message'       => __('Design uploaded successfully!', 'pod-starter'),
    ]);
}

function pod_custom_upload_dir(array $uploads): array
{
    $custom_dir = '/pod-designs/' . date('Y/m');
    $uploads['path']   = $uploads['basedir'] . $custom_dir;
    $uploads['url']    = $uploads['baseurl'] . $custom_dir;
    $uploads['subdir'] = $custom_dir;
    return $uploads;
}

// ============================================================================
// 14. SHORTCODES
// ============================================================================

// [pod_featured_products count="8"]
add_shortcode('pod_featured_products', 'pod_featured_products_shortcode');
function pod_featured_products_shortcode(array $atts): string
{
    $atts = shortcode_atts([
        'count'   => 8,
        'columns' => 4,
    ], $atts);

    if (!pod_is_woocommerce_active()) {
        return '<p>' . __('WooCommerce is required for this feature.', 'pod-starter') . '</p>';
    }

    return do_shortcode(sprintf(
        '[products limit="%d" columns="%d" visibility="featured" orderby="date"]',
        absint($atts['count']),
        absint($atts['columns'])
    ));
}

// [pod_category_grid]
add_shortcode('pod_category_grid', 'pod_category_grid_shortcode');
function pod_category_grid_shortcode(array $atts): string
{
    $atts = shortcode_atts([
        'count' => 6,
    ], $atts);

    if (!pod_is_woocommerce_active()) return '';

    $categories = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'number'     => absint($atts['count']),
        'parent'     => 0,
    ]);

    if (empty($categories) || is_wp_error($categories)) return '';

    ob_start();
    ?>
    <div class="categories__grid">
        <?php foreach ($categories as $cat) :
            $thumb_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
            $thumb_url = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'pod-category-thumb') : POD_THEME_ASSETS . '/images/hero-placeholder.jpg';
            ?>
            <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="category-card">
                <img src="<?php echo esc_url($thumb_url); ?>"
                     alt="<?php echo esc_attr($cat->name); ?>"
                     class="category-card__image"
                     loading="lazy">
                <div class="category-card__overlay">
                    <h3 class="category-card__title"><?php echo esc_html($cat->name); ?></h3>
                    <span class="category-card__count">
                        <?php printf(
                            esc_html(_n('%d Product', '%d Products', $cat->count, 'pod-starter')),
                            $cat->count
                        ); ?>
                    </span>
                </div>
                <span class="category-card__arrow" aria-hidden="true">→</span>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}

// [pod_mockup_generator]
add_shortcode('pod_mockup_generator', 'pod_mockup_generator_shortcode');
function pod_mockup_generator_shortcode(): string
{
    ob_start();
    get_template_part('template-parts/live-preview');
    return ob_get_clean();
}

// ============================================================================
// 15. WEBHOOKS FOR POD PROVIDER CALLBACKS
// ============================================================================

add_action('rest_api_init', 'pod_register_webhook_endpoints');
function pod_register_webhook_endpoints(): void
{
    // Printify Webhook
    register_rest_route('pod/v1', '/webhook/printify', [
        'methods'             => 'POST',
        'callback'            => 'pod_handle_printify_webhook',
        'permission_callback' => 'pod_verify_webhook_signature',
    ]);

    // Printful Webhook
    register_rest_route('pod/v1', '/webhook/printful', [
        'methods'             => 'POST',
        'callback'            => 'pod_handle_printful_webhook',
        'permission_callback' => 'pod_verify_webhook_signature',
    ]);
}

function pod_verify_webhook_signature(WP_REST_Request $request): bool
{
    // Basic verification - in production, verify signatures
    $provider = str_contains($request->get_route(), 'printify') ? 'printify' : 'printful';

    // Log webhook receipt
    error_log("POD Webhook received from {$provider}: " . $request->get_body());

    return true; // Implement proper signature verification
}

function pod_handle_printify_webhook(WP_REST_Request $request): WP_REST_Response
{
    $data = $request->get_json_params();
    $type = $data['type'] ?? '';

    switch ($type) {
        case 'order:shipped':
            $external_id = $data['resource']['external_id'] ?? '';
            $tracking    = $data['resource']['shipments'][0]['tracking_number'] ?? '';
            $carrier     = $data['resource']['shipments'][0]['carrier'] ?? '';

            if ($external_id) {
                $order = wc_get_order(absint($external_id));
                if ($order) {
                    $order->update_status('completed');
                    $order->update_meta_data('_pod_tracking_number', $tracking);
                    $order->update_meta_data('_pod_carrier', $carrier);
                    $order->save();
                    $order->add_order_note(
                        sprintf(__('Shipped via %s. Tracking: %s', 'pod-starter'), $carrier, $tracking)
                    );
                }
            }
            break;

        case 'order:created':
            // Order confirmed by Printify
            break;

        case 'product:updated':
            // Product sync
            break;
    }

    return new WP_REST_Response(['status' => 'ok'], 200);
}

function pod_handle_printful_webhook(WP_REST_Request $request): WP_REST_Response
{
    $data = $request->get_json_params();
    $type = $data['type'] ?? '';

    switch ($type) {
        case 'package_shipped':
            $external_id = $data['data']['order']['external_id'] ?? '';
            $shipments   = $data['data']['shipment'] ?? [];

            if ($external_id && !empty($shipments)) {
                $order = wc_get_order(absint($external_id));
                if ($order) {
                    $order->update_status('completed');
                    $order->update_meta_data('_pod_tracking_number', $shipments['tracking_number'] ?? '');
                    $order->update_meta_data('_pod_tracking_url', $shipments['tracking_url'] ?? '');
                    $order->save();
                }
            }
            break;
    }

    return new WP_REST_Response(['status' => 'ok'], 200);
}

// ============================================================================
// 16. HELPER FUNCTIONS
// ============================================================================

/**
 * Get theme mod with fallback
 */
function pod_get_mod(string $key, $default = ''): mixed
{
    return get_theme_mod($key, $default);
}

/**
 * Render SVG icon
 */
function pod_icon(string $name, int $size = 24): string
{
    $icons = [
        'cart'    => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="m1 1 4 2 2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>',
        'search'  => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>',
        'user'    => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
        'heart'   => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>',
        'eye'     => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>',
        'send'    => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>',
        'chat'    => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>',
        'close'   => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>',
        'upload'  => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>',
        'star'    => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
    ];

    return $icons[$name] ?? '';
}

/**
 * Breadcrumbs
 */
function pod_breadcrumbs(): void
{
    if (pod_is_woocommerce_active()) {
        woocommerce_breadcrumb([
            'delimiter'   => ' <span class="breadcrumb-sep">›</span> ',
            'wrap_before' => '<nav class="pod-breadcrumbs" aria-label="' . esc_attr__('Breadcrumb', 'pod-starter') . '">',
            'wrap_after'  => '</nav>',
        ]);
    }
}

/**
 * Estimated delivery date
 */
function pod_estimated_delivery(): string
{
    $min_days = 5;
    $max_days = 12;
    $min_date = date_i18n('M j', strtotime("+{$min_days} weekdays"));
    $max_date = date_i18n('M j', strtotime("+{$max_days} weekdays"));

    return sprintf(__('Est. delivery: %s - %s', 'pod-starter'), $min_date, $max_date);
}

// ============================================================================
// 17. INCLUDE MODULAR FILES
// ============================================================================

$include_files = [
    '/inc/theme-support.php',
    '/inc/customizer.php',
    '/inc/security.php',
];

foreach ($include_files as $file) {
    $filepath = POD_THEME_DIR . $file;
    if (file_exists($filepath)) {
        require_once $filepath;
    }
}

// ============================================================================
// 18. ACTIVATION / SETUP NOTICE
// ============================================================================

add_action('after_switch_theme', 'pod_theme_activation');
function pod_theme_activation(): void
{
    // Set default options
    $defaults = [
        'pod_provider'  => 'printify',
        'pod_ai_model'  => 'gpt-4o-mini',
    ];

    foreach ($defaults as $key => $value) {
        if (!get_option($key)) {
            update_option($key, $value);
        }
    }

    // Flush rewrite rules for custom endpoints
    flush_rewrite_rules();

    // Set transient for admin notice
    set_transient('pod_activation_notice', true, 60);
}

add_action('admin_notices', 'pod_activation_admin_notice');
function pod_activation_admin_notice(): void
{
    if (!get_transient('pod_activation_notice')) return;
    delete_transient('pod_activation_notice');

    $settings_url = admin_url('admin.php?page=pod-settings');
    ?>
    <div class="notice notice-success is-dismissible">
        <h3>🎉 <?php esc_html_e('POD Starter Pro activated successfully!', 'pod-starter'); ?></h3>
        <p><?php esc_html_e('To get started, please configure your settings:', 'pod-starter'); ?></p>
        <ol>
            <li><?php esc_html_e('Install & activate WooCommerce', 'pod-starter'); ?></li>
            <li><?php printf(__('Configure your <a href="%s">POD Settings</a> (API keys)', 'pod-starter'), esc_url($settings_url)); ?></li>
            <li><?php esc_html_e('Install the Printify or Printful plugin for product sync', 'pod-starter'); ?></li>
            <li><?php esc_html_e('Customize your theme in Appearance → Customize', 'pod-starter'); ?></li>
        </ol>
    </div>
    <?php
}