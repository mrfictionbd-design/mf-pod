/**
 * POD Starter Pro - AJAX Add to Cart
 */
(function () {
    'use strict';
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.add_to_cart_button');
        if (!btn) return;
        e.preventDefault();
        btn.classList.add('loading');
        const productId = btn.dataset.productId || btn.value;
        const data = new URLSearchParams({
            action: 'woocommerce_ajax_add_to_cart',
            product_id: productId,
            quantity: 1,
            security: (typeof pod_ajax !== 'undefined') ? pod_ajax.nonce : ''
        });
        fetch((typeof pod_ajax !== 'undefined') ? pod_ajax.ajax_url : '/wp-admin/admin-ajax.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: data.toString()
        })
        .then(r => r.json())
        .then(response => {
            btn.classList.remove('loading');
            btn.classList.add('added');
            if (response.fragments) {
                document.querySelector('.cart-count') && (document.querySelector('.cart-count').textContent = response.cart_quantity);
            }
        })
        .catch(() => btn.classList.remove('loading'));
    });
})();
