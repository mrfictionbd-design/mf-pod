/**
 * POD Starter Pro - Lazy Load Images
 */
(function () {
    'use strict';
    if ('IntersectionObserver' in window) {
        const imgs = document.querySelectorAll('img[data-src]');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    if (img.dataset.srcset) img.srcset = img.dataset.srcset;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        }, { rootMargin: '200px 0px' });
        imgs.forEach(img => observer.observe(img));
    }
})();
