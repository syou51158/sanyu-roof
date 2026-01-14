/**
 * Simple Lightbox Script
 * Adds a click-to-enlarge functionality to all images with class 'lightbox-img' or links with class 'lightbox-link'.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Create lightbox overlay elements
    const lightboxOverlay = document.createElement('div');
    lightboxOverlay.id = 'lightbox-overlay';
    lightboxOverlay.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 9999; display: none; align-items: center; justify-content: center; cursor: zoom-out; opacity: 0; transition: opacity 0.3s ease;';
    
    const lightboxImg = document.createElement('img');
    lightboxImg.style.cssText = 'max-width: 90%; max-height: 90%; border-radius: 4px; box-shadow: 0 5px 20px rgba(0,0,0,0.5); transform: scale(0.9); transition: transform 0.3s ease;';
    
    lightboxOverlay.appendChild(lightboxImg);
    document.body.appendChild(lightboxOverlay);

    // Function to open lightbox
    function openLightbox(src) {
        lightboxImg.src = src;
        lightboxOverlay.style.display = 'flex';
        // Force reflow
        lightboxOverlay.offsetHeight;
        lightboxOverlay.style.opacity = '1';
        lightboxImg.style.transform = 'scale(1)';
    }

    // Function to close lightbox
    function closeLightbox() {
        lightboxOverlay.style.opacity = '0';
        lightboxImg.style.transform = 'scale(0.9)';
        setTimeout(() => {
            lightboxOverlay.style.display = 'none';
            lightboxImg.src = '';
        }, 300);
    }

    // Event listeners
    lightboxOverlay.addEventListener('click', closeLightbox);

    // Attach to images
    // Select all images inside .card-img, .solar-feature, or explicit .lightbox-target
    const targetImages = document.querySelectorAll('.card-img img, .solar-feature img, .lightbox-target');
    
    targetImages.forEach(img => {
        img.style.cursor = 'zoom-in';
        img.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent bubbling if needed
            // Use the image source
            openLightbox(this.src);
        });
    });
});
