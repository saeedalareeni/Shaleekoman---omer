{{-- Ultimate Icon Fix - Aggressive Solution --}}

<script>
(function() {
    'use strict';
    
    // Wait for DOM to be ready
    function ready(fn) {
        if (document.readyState != 'loading'){
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }
    
    // Main fix function
    function ultimateIconFix() {
        // Get all elements that might be icons
        const iconSelectors = [
            '[class*="fa-"]',
            'i.fa',
            'i.fas',
            'i.far',
            'i.fab',
            'i.fa-solid',
            'i.fa-regular',
            'i.fa-brands',
            'span[class*="fa-"]'
        ];
        
        const allIcons = document.querySelectorAll(iconSelectors.join(','));
        
        allIcons.forEach(function(element) {
            // Get all classes
            let classes = Array.from(element.classList);
            
            // Determine what type of icon this should be
            let iconType = 'solid'; // default
            let iconName = null;
            let otherClasses = [];
            
            // Analyze classes
            classes.forEach(function(cls) {
                // Check for icon name (fa-something)
                if (cls.startsWith('fa-') && 
                    cls !== 'fa-solid' && 
                    cls !== 'fa-regular' && 
                    cls !== 'fa-brands' &&
                    cls !== 'fa-light' &&
                    cls !== 'fa-thin' &&
                    cls !== 'fa-duotone') {
                    iconName = cls;
                }
                // Check for style
                else if (cls === 'far' || cls === 'fa-regular') {
                    iconType = 'regular';
                }
                else if (cls === 'fab' || cls === 'fa-brands') {
                    iconType = 'brands';
                }
                else if (cls === 'fal' || cls === 'fa-light') {
                    iconType = 'light';
                }
                // Keep non-FA classes
                else if (!cls.startsWith('fa') && cls !== 'fas' && cls !== 'far' && cls !== 'fab') {
                    otherClasses.push(cls);
                }
            });
            
            // If we found an icon name, rebuild the classes
            if (iconName) {
                // Clear all classes
                element.className = '';
                
                // Add the correct FA classes
                if (iconType === 'solid') {
                    element.classList.add('fas');
                } else if (iconType === 'regular') {
                    element.classList.add('far');
                } else if (iconType === 'brands') {
                    element.classList.add('fab');
                } else if (iconType === 'light') {
                    element.classList.add('fal');
                }
                
                // Add the icon name
                element.classList.add(iconName);
                
                // Add back other classes
                otherClasses.forEach(function(cls) {
                    if (cls) element.classList.add(cls);
                });
                
                // Force style refresh
                element.style.fontFamily = '';
                element.style.fontWeight = '';
                
                // Set correct font-family inline for reliability
                if (iconType === 'solid') {
                    element.style.fontFamily = '"Font Awesome 6 Free", "Font Awesome 5 Free"';
                    element.style.fontWeight = '900';
                } else if (iconType === 'regular') {
                    element.style.fontFamily = '"Font Awesome 6 Free", "Font Awesome 5 Free"';
                    element.style.fontWeight = '400';
                } else if (iconType === 'brands') {
                    element.style.fontFamily = '"Font Awesome 6 Brands", "Font Awesome 5 Brands"';
                    element.style.fontWeight = '400';
                }
            }
        });
        
        // Fix specific problematic icons
        const iconMappings = {
            'fa-check-circle': 'fa-circle-check',
            'fa-times-circle': 'fa-circle-xmark',
            'fa-exclamation-circle': 'fa-circle-exclamation',
            'fa-info-circle': 'fa-circle-info',
            'fa-user-circle': 'fa-circle-user',
            'fa-question-circle': 'fa-circle-question',
            'fa-trash-alt': 'fa-trash-can',
            'fa-calendar-alt': 'fa-calendar-days',
            'fa-edit': 'fa-pen-to-square'
        };
        
        Object.keys(iconMappings).forEach(function(oldClass) {
            document.querySelectorAll('.' + oldClass).forEach(function(element) {
                element.classList.remove(oldClass);
                element.classList.add(iconMappings[oldClass]);
            });
        });
    }
    
    // Run the fix
    ready(function() {
        // Initial fix
        ultimateIconFix();
        
        // Fix after a short delay (for dynamically loaded content)
        setTimeout(ultimateIconFix, 500);
        setTimeout(ultimateIconFix, 1000);
        setTimeout(ultimateIconFix, 2000);
        
        // Watch for DOM changes
        if (typeof MutationObserver !== 'undefined') {
            let observer = new MutationObserver(function(mutations) {
                let shouldFix = false;
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length > 0) {
                        shouldFix = true;
                    }
                });
                if (shouldFix) {
                    setTimeout(ultimateIconFix, 100);
                }
            });
            
            if (document.body) {
                observer.observe(document.body, {
                    childList: true,
                    subtree: true
                });
            }
        }
        
        // Fix on AJAX complete
        if (window.jQuery) {
            jQuery(document).ajaxComplete(function() {
                setTimeout(ultimateIconFix, 100);
            });
        }
        
        // Fix on window events
        ['load', 'resize', 'orientationchange'].forEach(function(event) {
            window.addEventListener(event, function() {
                setTimeout(ultimateIconFix, 100);
            });
        });
    });
    
    // Expose globally for manual trigger
    window.ultimateIconFix = ultimateIconFix;
})();
</script>

{{-- Aggressive CSS Override --}}
<style>
/* Nuclear option - override everything */
i[class*="fa-"]:not(.material-icons):not(.bi) {
    font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
    font-weight: 900 !important;
    font-style: normal !important;
    font-variant: normal !important;
    text-rendering: auto !important;
    -webkit-font-smoothing: antialiased !important;
    display: inline-block !important;
}

/* Specific overrides for different styles */
i.far[class*="fa-"],
i[class*="fa-"].far {
    font-weight: 400 !important;
}

i.fab[class*="fa-"],
i[class*="fa-"].fab {
    font-family: "Font Awesome 6 Brands", "Font Awesome 5 Brands" !important;
    font-weight: 400 !important;
}

/* Remove all conflicting styles */
.fa.fas.fa-solid,
.fas.fa-solid,
.fa.fas,
.fa.far,
.fa.fab {
    /* Reset everything */
    all: revert !important;
    /* Then apply correct styles */
    display: inline-block !important;
    font-style: normal !important;
    font-variant: normal !important;
    text-rendering: auto !important;
    -webkit-font-smoothing: antialiased !important;
}

/* Ensure icons in buttons and links work */
button i[class*="fa-"],
a i[class*="fa-"],
.btn i[class*="fa-"] {
    display: inline-block !important;
    margin: 0 5px !important;
}
</style>
