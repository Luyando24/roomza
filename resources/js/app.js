import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();

// Ensure bottom navigation stays visible on all devices
document.addEventListener('DOMContentLoaded', function() {
    const bottomNav = document.querySelector('.fixed.bottom-0');
    
    if (bottomNav) {
        // Make sure it's visible
        bottomNav.style.display = 'block';
        
        // Add scroll event listener to keep it visible
        window.addEventListener('scroll', function() {
            bottomNav.style.display = 'block';
        });
        
        // Add resize event listener
        window.addEventListener('resize', function() {
            bottomNav.style.display = 'block';
        });
    }
});



