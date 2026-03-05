/**
 * POD Starter Pro - Mockup Generator (Fabric.js)
 *
 * Uses Fabric.js to create a real-time product preview
 * where customers can upload designs and see them on products.
 */

(function () {
    'use strict';

    // Exit if Fabric.js isn't loaded or canvas doesn't exist
    if (typeof fabric === 'undefined') return;

    const canvasEl = document.getElementById('mockup-canvas');
    if (!canvasEl) return;

    // ===========================================
    // INITIALIZE FABRIC CANVAS
    // ===========================================
    const canvas = new fabric.Canvas('mockup-canvas', {
        width: 400,
        height: 500,
        backgroundColor: '#f0f0f0',
        selection: true,
        preserveObjectStacking: true,
    });

    // State
    let currentProduct = 'tshirt';
    let currentColor = '#FFFFFF';
    let productImage = null;
    let userDesign = null;
    let userText = null;
    let printArea = null;

    // Config from WordPress
    const config = typeof podMockup !== 'undefined' ? podMockup : {
        mockups: {
            tshirt: '',
            hoodie: '',
            mug: '',
        },
        printAreas: {
            tshirt: { x: 150, y: 120, width: 200, height: 260 },
            hoodie: { x: 140, y: 130, width: 220, height: 240 },
            mug: { x: 100, y: 80, width: 200, height: 200 },
        },
    };

    // ===========================================
    // LOAD PRODUCT MOCKUP
    // ===========================================
    function loadProduct(productType) {
        currentProduct = productType;
        const area = config.printAreas[productType];

        // Clear canvas
        canvas.clear();
        canvas.setBackgroundColor('#f0f0f0', canvas.renderAll.bind(canvas));

        // Draw product shape (simplified mockup)
        drawProductShape(productType, currentColor);

        // Draw print area indicator
        printArea = new fabric.Rect({
            left: area.x,
            top: area.y,
            width: area.width,
            height: area.height,
            fill: 'transparent',
            stroke: 'rgba(108, 92, 231, 0.4)',
            strokeWidth: 2,
            strokeDashArray: [8, 4],
            selectable: false,
            evented: false,
        });
        canvas.add(printArea);

        // Re-add user design if exists
        if (userDesign) {
            positionDesignInPrintArea(userDesign);
        }
        if (userText) {
            positionDesignInPrintArea(userText);
        }

        canvas.renderAll();
    }

    function drawProductShape(type, color) {
        let shape;

        switch (type) {
            case 'tshirt':
                // T-shirt body
                shape = new fabric.Rect({
                    left: 80,
                    top: 80,
                    width: 240,
                    height: 340,
                    rx: 12,
                    ry: 12,
                    fill: color,
                    stroke: '#ddd',
                    strokeWidth: 1,
                    selectable: false,
                    evented: false,
                });
                canvas.add(shape);

                // Collar
                const collar = new fabric.Ellipse({
                    left: 160,
                    top: 70,
                    rx: 40,
                    ry: 20,
                    fill: color,
                    stroke: '#ddd',
                    strokeWidth: 1,
                    selectable: false,
                    evented: false,
                });
                canvas.add(collar);

                // Sleeves
                const leftSleeve = new fabric.Rect({
                    left: 30,
                    top: 85,
                    width: 60,
                    height: 100,
                    rx: 8,
                    fill: color,
                    stroke: '#ddd',
                    strokeWidth: 1,
                    angle: -5,
                    selectable: false,
                    evented: false,
                });
                canvas.add(leftSleeve);

                const rightSleeve = new fabric.Rect({
                    left: 310,
                    top: 85,
                    width: 60,
                    height: 100,
                    rx: 8,
                    fill: color,
                    stroke: '#ddd',
                    strokeWidth: 1,
                    angle: 5,
                    selectable: false,
                    evented: false,
                });
                canvas.add(rightSleeve);
                break;

            case 'hoodie':
                // Hoodie body
                shape = new fabric.Rect({
                    left: 70,
                    top: 90,
                    width: 260,
                    height: 340,
                    rx: 12,
                    ry: 12,
                    fill: color,
                    stroke: '#ddd',
                    strokeWidth: 1,
                    selectable: false,
                    evented: false,
                });
                canvas.add(shape);

                // Hood
                const hood = new fabric.Ellipse({
                    left: 130,
                    top: 40,
                    rx: 70,
                    ry: 60,
                    fill: color,
                    stroke: '#ddd',
                    strokeWidth: 1,
                    selectable: false,
                    evented: false,
                });
                canvas.add(hood);

                // Pocket
                const pocket = new fabric.Rect({
                    left: 130,
                    top: 310,
                    width: 140,
                    height: 60,
                    rx: 6,
                    fill: 'rgba(0,0,0,0.05)',
                    stroke: 'rgba(0,0,0,0.1)',
                    strokeWidth: 1,
                    selectable: false,
                    evented: false,
                });
                canvas.add(pocket);
                break;

            case 'mug':
                // Mug body
                shape = new fabric.Rect({
                    left: 80,
                    top: 100,
                    width: 220,
                    height: 280,
                    rx: 16,
                    ry: 16,
                    fill: color,
                    stroke: '#ddd',
                    strokeWidth: 1,
                    selectable: false,
                    evented: false,
                });
                canvas.add(shape);

                // Handle
                const handle = new fabric.Ellipse({
                    left: 300,
                    top: 180,
                    rx: 30,
                    ry: 50,
                    fill: 'transparent',
                    stroke: color === '#FFFFFF' ? '#ccc' : color,
                    strokeWidth: 12,
                    selectable: false,
                    evented: false,
                });
                canvas.add(handle);
                break;
        }
    }

    function positionDesignInPrintArea(obj) {
        const area = config.printAreas[currentProduct];
        obj.set({
            left: area.x + area.width / 2,
            top: area.y + area.height / 2,
            originX: 'center',
            originY: 'center',
        });

        // Scale to fit print area
        const scaleX = area.width / obj.width;
        const scaleY = area.height / obj.height;
        const scale = Math.min(scaleX, scaleY) * 0.8;
        obj.scale(scale);

        // Clip to print area
        obj.set({
            clipPath: new fabric.Rect({
                left: area.x - (area.x + area.width / 2),
                top: area.y - (area.y + area.height / 2),
                width: area.width,
                height: area.height,
                absolutePositioned: false,
            }),
        });

        canvas.add(obj);
        canvas.setActiveObject(obj);
        canvas.renderAll();
    }

    // ===========================================
    // EVENT HANDLERS
    // ===========================================

    // Product Selector
    document.querySelectorAll('.mockup-product-btn').forEach((btn) => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.mockup-product-btn').forEach((b) => b.classList.remove('is-active'));
            this.classList.add('is-active');
            loadProduct(this.dataset.product);
        });
    });

    // Color Picker
    document.querySelectorAll('.mockup-color-swatch').forEach((swatch) => {
        swatch.addEventListener('click', function () {
            document.querySelectorAll('.mockup-color-swatch').forEach((s) => s.classList.remove('is-active'));
            this.classList.add('is-active');
            currentColor = this.dataset.color;
            loadProduct(currentProduct);
        });
    });

    // File Upload
    const uploadZone = document.getElementById('mockup-upload-zone');
    const fileInput = document.getElementById('mockup-file-input');

    if (uploadZone && fileInput) {
        uploadZone.addEventListener('click', () => fileInput.click());

        uploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadZone.classList.add('is-dragover');
        });

        uploadZone.addEventListener('dragleave', () => {
            uploadZone.classList.remove('is-dragover');
        });

        uploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadZone.classList.remove('is-dragover');
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                handleImageUpload(file);
            }
        });

        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                handleImageUpload(file);
            }
        });
    }

    function handleImageUpload(file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            fabric.Image.fromURL(e.target.result, function (img) {
                // Remove old design
                if (userDesign) {
                    canvas.remove(userDesign);
                }

                userDesign = img;
                positionDesignInPrintArea(img);

                // Update upload zone text
                uploadZone.querySelector('.mockup-upload-zone__text').innerHTML =
                    '<strong>✓ Design uploaded!</strong><br><small>Click to change</small>';
            });
        };
        reader.readAsDataURL(file);
    }

    // Custom Text Input
    const textInput = document.getElementById('mockup-text-input');
    let textDebounce = null;

    if (textInput) {
        textInput.addEventListener('input', function () {
            clearTimeout(textDebounce);
            textDebounce = setTimeout(() => {
                const text = this.value.trim();

                if (userText) {
                    canvas.remove(userText);
                    userText = null;
                }

                if (text) {
                    userText = new fabric.Text(text, {
                        fontSize: 28,
                        fontFamily: 'Inter, Arial, sans-serif',
                        fontWeight: 'bold',
                        fill: currentColor === '#FFFFFF' || currentColor === '#FDCB6E'
                            ? '#000000'
                            : '#FFFFFF',
                        textAlign: 'center',
                        originX: 'center',
                        originY: 'center',
                    });
                    positionDesignInPrintArea(userText);
                }
            }, 300);
        });
    }

    // Download Preview
    const downloadBtn = document.getElementById('mockup-download');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', () => {
            const dataURL = canvas.toDataURL({
                format: 'png',
                quality: 1,
                multiplier: 2,
            });

            const link = document.createElement('a');
            link.download = `mockup-${currentProduct}-${Date.now()}.png`;
            link.href = dataURL;
            link.click();
        });
    }

    // Add to Cart
    const addToCartBtn = document.getElementById('mockup-add-to-cart');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', () => {
            // Get canvas as image
            const designImage = canvas.toDataURL({
                format: 'png',
                quality: 1,
            });

            // Store in session for checkout
            sessionStorage.setItem('pod_custom_design', designImage);
            sessionStorage.setItem('pod_product_type', currentProduct);
            sessionStorage.setItem('pod_product_color', currentColor);

            // Redirect to shop or trigger add-to-cart
            alert('Design saved! Redirecting to product page...');
            // window.location.href = '/shop';
        });
    }

    // ===========================================
    // INITIALIZE
    // ===========================================
    loadProduct('tshirt');

    console.log('🎨 Mockup Generator initialized');

})();