/**
 * POD Starter Pro - Main JavaScript
 */

(function () {
    'use strict';

    // ===========================================
    // HEADER SCROLL BEHAVIOR
    // ===========================================
    const header = document.getElementById('site-header');
    let lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        if (currentScroll > 50) {
            header.classList.add('is-scrolled');
        } else {
            header.classList.remove('is-scrolled');
        }

        lastScroll = currentScroll;
    }, { passive: true });

    // ===========================================
    // MOBILE MENU
    // ===========================================
    const menuToggle = document.getElementById('menu-toggle');
    const mobileNav = document.getElementById('mobile-nav');
    const mobileOverlay = document.getElementById('mobile-nav-overlay');
    const mobileClose = document.getElementById('mobile-nav-close');

    function openMobileMenu() {
        mobileNav.classList.add('is-open');
        mobileOverlay.classList.add('is-visible');
        menuToggle.classList.add('is-active');
        menuToggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileMenu() {
        mobileNav.classList.remove('is-open');
        mobileOverlay.classList.remove('is-visible');
        menuToggle.classList.remove('is-active');
        menuToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            if (mobileNav.classList.contains('is-open')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
    }

    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', closeMobileMenu);
    }

    if (mobileClose) {
        mobileClose.addEventListener('click', closeMobileMenu);
    }

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeMobileMenu();
        }
    });

    // ===========================================
    // SCROLL ANIMATIONS (Intersection Observer)
    // ===========================================
    const animatedElements = document.querySelectorAll('[data-animate]');

    if (animatedElements.length > 0 && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            },
            {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px',
            }
        );

        animatedElements.forEach((el) => observer.observe(el));
    } else {
        // Fallback: show everything immediately
        animatedElements.forEach((el) => el.classList.add('is-visible'));
    }

    // ===========================================
    // SMOOTH SCROLL FOR ANCHOR LINKS
    // ===========================================
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                const headerHeight = header ? header.offsetHeight : 0;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth',
                });

                // Close mobile menu if open
                closeMobileMenu();
            }
        });
    });

    // ===========================================
    // SEARCH TOGGLE
    // ===========================================
    const searchToggle = document.getElementById('search-toggle');
    if (searchToggle) {
        searchToggle.addEventListener('click', () => {
            // You can expand this into a full search overlay
            const searchForm = document.querySelector('.search-overlay');
            if (searchForm) {
                searchForm.classList.toggle('is-open');
            } else {
                // Simple fallback: focus the WooCommerce search
                const searchInput = document.querySelector('.woocommerce-product-search input[type="search"]');
                if (searchInput) {
                    searchInput.focus();
                }
            }
        });
    }

    // ===========================================
    // LAZY LOAD IMAGES (Native + Fallback)
    // ===========================================
    if ('loading' in HTMLImageElement.prototype) {
        // Browser supports native lazy loading
        document.querySelectorAll('img[loading="lazy"]').forEach((img) => {
            if (img.dataset.src) {
                img.src = img.dataset.src;
            }
        });
    }

    // ===========================================
    // WooCommerce Cart Fragment Update
    // ===========================================
    function updateCartCount(count) {
        const cartCountEl = document.querySelector('.cart-count');
        if (cartCountEl) {
            cartCountEl.textContent = count;
            if (count > 0) {
                cartCountEl.style.display = 'flex';
            } else {
                cartCountEl.style.display = 'none';
            }
        }
    }

    // Listen for WooCommerce cart updates
    document.addEventListener('wc_cart_updated', function (e) {
        if (e.detail && e.detail.cart_count !== undefined) {
            updateCartCount(e.detail.cart_count);
        }
    });

    console.log('🎨 POD Starter Pro theme loaded successfully.');

})();