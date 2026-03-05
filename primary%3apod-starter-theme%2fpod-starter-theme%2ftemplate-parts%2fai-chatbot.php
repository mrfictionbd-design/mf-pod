<?php
/**
 * AI Chatbot widget template
 *
 * @package POD_Starter_Pro
 */
?>

<!-- Chatbot Trigger -->
<button class="chatbot-trigger" id="chatbot-trigger" aria-label="<?php esc_attr_e('Open chat support', 'pod-starter'); ?>">
    <?php echo pod_icon('chat', 28); ?>
    <span class="chatbot-trigger__badge" aria-hidden="true"></span>
</button>

<!-- Chatbot Window -->
<div class="chatbot-window" id="chatbot-window" role="dialog" aria-label="<?php esc_attr_e('Chat Support', 'pod-starter'); ?>">
    <!-- Header -->
    <div class="chatbot-header">
        <div class="chatbot-header__avatar">🤖</div>
        <div class="chatbot-header__info">
            <h4><?php echo esc_html(get_bloginfo('name')); ?> <?php esc_html_e('Support', 'pod-starter'); ?></h4>
            <span class="chatbot-header__status"><?php esc_html_e('Online now', 'pod-starter'); ?></span>
        </div>
        <button class="chatbot-header__close" id="chatbot-close" aria-label="<?php esc_attr_e('Close chat', 'pod-starter'); ?>">
            <?php echo pod_icon('close', 18); ?>
        </button>
    </div>

    <!-- Messages -->
    <div class="chatbot-messages" id="chatbot-messages">
        <div class="chatbot-message chatbot-message--bot">
            <div class="chatbot-message__bubble">
                <?php esc_html_e('Hi there! 👋 How can I help you today?', 'pod-starter'); ?>
            </div>
        </div>
    </div>

    <!-- Quick Replies -->
    <div class="chatbot-quick-replies" id="chatbot-quick-replies">
        <button class="chatbot-quick-reply" data-message="<?php esc_attr_e('Track my order', 'pod-starter'); ?>">
            📦 <?php esc_html_e('Track Order', 'pod-starter'); ?>
        </button>
        <button class="chatbot-quick-reply" data-message="<?php esc_attr_e('How do I customize a product?', 'pod-starter'); ?>">
            🎨 <?php esc_html_e('Customization', 'pod-starter'); ?>
        </button>
        <button class="chatbot-quick-reply" data-message="<?php esc_attr_e('What are your shipping rates?', 'pod-starter'); ?>">
            🚚 <?php esc_html_e('Shipping', 'pod-starter'); ?>
        </button>
        <button class="chatbot-quick-reply" data-message="<?php esc_attr_e('What is your return policy?', 'pod-starter'); ?>">
            ↩️ <?php esc_html_e('Returns', 'pod-starter'); ?>
        </button>
    </div>

    <!-- Input Area -->
    <div class="chatbot-input-area">
        <input type="text"
               class="chatbot-input"
               id="chatbot-input"
               placeholder="<?php esc_attr_e('Type your message...', 'pod-starter'); ?>"
               autocomplete="off"
               maxlength="500">
        <button class="chatbot-send


>> User:
Where will i put this codes?


>> Claude Opus 4.6:
# Where to Put Every File — Step-by-Step Guide

## Let me walk you through this visually so there's zero confusion.

---

## 🖥️ STEP 1: Create the Theme Folder on Your Computer

Open your computer and create a folder on your Desktop:
