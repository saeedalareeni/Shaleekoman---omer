{{-- Font Awesome Class Converter --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Clean up duplicate and conflicting classes
    function cleanIconClasses() {
        const icons = document.querySelectorAll('[class*="fa-"]');
        
        icons.forEach(function(icon) {
            let classes = icon.className.split(' ');
            let cleanedClasses = [];
            let hasFA = false;
            let hasFAS = false;
            let hasFAR = false;
            let hasFAB = false;
            let hasSolid = false;
            let hasRegular = false;
            let hasBrands = false;
            
            // First pass: identify what we have
            classes.forEach(function(cls) {
                if (cls === 'fa') hasFA = true;
                else if (cls === 'fas') hasFAS = true;
                else if (cls === 'far') hasFAR = true;
                else if (cls === 'fab') hasFAB = true;
                else if (cls === 'fa-solid') hasSolid = true;
                else if (cls === 'fa-regular') hasRegular = true;
                else if (cls === 'fa-brands') hasBrands = true;
            });
            
            // Determine the correct style
            let style = 'solid'; // default
            if (hasFAR || hasRegular) style = 'regular';
            else if (hasFAB || hasBrands) style = 'brands';
            else if (hasFAS || hasSolid) style = 'solid';
            
            // Add the correct base classes
            if (style === 'solid') {
                cleanedClasses.push('fas');
            } else if (style === 'regular') {
                cleanedClasses.push('far');
            } else if (style === 'brands') {
                cleanedClasses.push('fab');
            }
            
            // Add icon classes and other classes
            classes.forEach(function(cls) {
                // Skip duplicate style classes
                if (cls === 'fa' || cls === 'fas' || cls === 'far' || cls === 'fab' || 
                    cls === 'fa-solid' || cls === 'fa-regular' || cls === 'fa-brands') {
                    return;
                }
                // Keep icon classes and other classes
                if (cls && cls.trim()) {
                    cleanedClasses.push(cls);
                }
            });
            
            // Apply cleaned classes
            icon.className = cleanedClasses.join(' ');
        });
    }
    
    // Clean classes immediately
    cleanIconClasses();
    // Map old Font Awesome classes to new ones
    const iconClassMap = {
        // Common icons that changed from FA5 to FA6
        'fa-check-circle': 'fa-circle-check',
        'fa-times-circle': 'fa-circle-xmark',
        'fa-exclamation-circle': 'fa-circle-exclamation',
        'fa-info-circle': 'fa-circle-info',
        'fa-question-circle': 'fa-circle-question',
        'fa-plus-circle': 'fa-circle-plus',
        'fa-minus-circle': 'fa-circle-minus',
        'fa-arrow-circle-up': 'fa-circle-arrow-up',
        'fa-arrow-circle-down': 'fa-circle-arrow-down',
        'fa-arrow-circle-left': 'fa-circle-arrow-left',
        'fa-arrow-circle-right': 'fa-circle-arrow-right',
        'fa-check-square': 'fa-square-check',
        'fa-times': 'fa-xmark',
        'fa-home': 'fa-house',
        'fa-trash-alt': 'fa-trash-can',
        'fa-edit': 'fa-pen-to-square',
        'fa-save': 'fa-floppy-disk',
        'fa-file-alt': 'fa-file-lines',
        'fa-calendar-alt': 'fa-calendar-days',
        'fa-map-marker-alt': 'fa-location-dot',
        'fa-user-circle': 'fa-circle-user',
        'fa-sign-out-alt': 'fa-right-from-bracket',
        'fa-sign-in-alt': 'fa-right-to-bracket',
        'fa-external-link-alt': 'fa-up-right-from-square',
        'fa-ellipsis-v': 'fa-ellipsis-vertical',
        'fa-ellipsis-h': 'fa-ellipsis',
        'fa-money-bill-alt': 'fa-money-bill-1',
        'fa-chart-bar': 'fa-chart-column',
        'fa-tachometer-alt': 'fa-gauge-high',
        'fa-shopping-cart': 'fa-cart-shopping',
        'fa-angle-double-left': 'fa-angles-left',
        'fa-angle-double-right': 'fa-angles-right',
        'fa-angle-double-up': 'fa-angles-up',
        'fa-angle-double-down': 'fa-angles-down'
    };

    // Function to fix icon classes
    function fixIconClasses() {
        // First clean the classes
        cleanIconClasses();
        
        // Then fix old icon names
        const icons = document.querySelectorAll('[class*="fa-"]');
        
        icons.forEach(function(icon) {
            let classes = icon.className.split(' ');
            let newClasses = [];
            
            classes.forEach(function(cls) {
                // Check if this class needs to be replaced
                if (iconClassMap[cls]) {
                    newClasses.push(iconClassMap[cls]);
                } else {
                    newClasses.push(cls);
                }
            });
            
            icon.className = newClasses.join(' ');
        });
    }

    // Fix icons on page load
    fixIconClasses();
    
    // Fix icons when new content is added
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                setTimeout(fixIconClasses, 100);
            }
        });
    });
    
    if (document.body) {
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
    
    // Also fix after AJAX calls
    if (window.jQuery) {
        jQuery(document).ajaxComplete(function() {
            setTimeout(fixIconClasses, 100);
        });
    }
    
    // Fix after any dynamic content load
    ['DOMContentLoaded', 'load', 'resize'].forEach(function(event) {
        window.addEventListener(event, function() {
            setTimeout(fixIconClasses, 100);
        });
    });
});

// Global function to manually fix icons
window.fixFontAwesomeIcons = function() {
    document.querySelectorAll('[class*="fa-"]').forEach(function(icon) {
        // Remove all classes and re-add them to force refresh
        const classes = icon.className;
        icon.className = '';
        void icon.offsetWidth; // Force reflow
        icon.className = classes;
    });
};
</script>

{{-- Additional CSS to ensure compatibility --}}
<style>
/* Font Awesome 6 Compatibility Layer */
.fas, .fa-solid {
    font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
    font-weight: 900 !important;
    font-style: normal !important;
}

/* Fix for mixed classes like 'fas fa-solid fa-circle-user' */
.fas.fa-solid,
.fa.fas,
.fa.fa-solid {
    font-family: "Font Awesome 6 Free", "Font Awesome 5 Free" !important;
    font-weight: 900 !important;
}

.far, .fa-regular {
    font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
    font-weight: 400 !important;
}

.fab, .fa-brands {
    font-family: "Font Awesome 6 Brands", "Font Awesome 5 Brands" !important;
    font-weight: 400 !important;
}

.fal, .fa-light {
    font-family: "Font Awesome 6 Pro", "Font Awesome 5 Pro" !important;
    font-weight: 300 !important;
}

.fad, .fa-duotone {
    font-family: "Font Awesome 6 Duotone", "Font Awesome 5 Duotone" !important;
    font-weight: 900 !important;
}

/* Ensure all icon containers display properly */
i[class*="fa-"],
span[class*="fa-"] {
    display: inline-block !important;
    font-style: normal !important;
    font-variant: normal !important;
    text-rendering: auto !important;
    line-height: 1 !important;
    -webkit-font-smoothing: antialiased !important;
    -moz-osx-font-smoothing: grayscale !important;
}

/* Fix specific problematic icons */
.fa-check-circle:before,
.fas.fa-check-circle:before {
    content: "\f058" !important;
}

.fa-times-circle:before,
.fas.fa-times-circle:before {
    content: "\f057" !important;
}

.fa-info-circle:before,
.fas.fa-info-circle:before {
    content: "\f05a" !important;
}

.fa-exclamation-circle:before,
.fas.fa-exclamation-circle:before {
    content: "\f06a" !important;
}

.fa-question-circle:before,
.fas.fa-question-circle:before {
    content: "\f059" !important;
}

.fa-user-circle:before,
.fas.fa-user-circle:before {
    content: "\f2bd" !important;
}

.fa-calendar-alt:before,
.fas.fa-calendar-alt:before {
    content: "\f073" !important;
}

.fa-trash-alt:before,
.fas.fa-trash-alt:before {
    content: "\f2ed" !important;
}

.fa-edit:before,
.fas.fa-edit:before {
    content: "\f044" !important;
}

.fa-save:before,
.fas.fa-save:before {
    content: "\f0c7" !important;
}

.fa-home:before,
.fas.fa-home:before {
    content: "\f015" !important;
}

.fa-times:before,
.fas.fa-times:before {
    content: "\f00d" !important;
}

.fa-check:before,
.fas.fa-check:before {
    content: "\f00c" !important;
}

.fa-plus:before,
.fas.fa-plus:before {
    content: "\f067" !important;
}

.fa-minus:before,
.fas.fa-minus:before {
    content: "\f068" !important;
}

.fa-bell:before,
.fas.fa-bell:before {
    content: "\f0f3" !important;
}

.fa-heart:before,
.fas.fa-heart:before {
    content: "\f004" !important;
}

.fa-star:before,
.fas.fa-star:before {
    content: "\f005" !important;
}

.fa-user:before,
.fas.fa-user:before {
    content: "\f007" !important;
}

.fa-clock:before,
.fas.fa-clock:before,
.far.fa-clock:before {
    content: "\f017" !important;
}

.fa-calendar:before,
.fas.fa-calendar:before {
    content: "\f133" !important;
}

.fa-envelope:before,
.fas.fa-envelope:before {
    content: "\f0e0" !important;
}

.fa-phone:before,
.fas.fa-phone:before {
    content: "\f095" !important;
}

.fa-map-marker-alt:before,
.fas.fa-map-marker-alt:before {
    content: "\f3c5" !important;
}

.fa-cog:before,
.fas.fa-cog:before {
    content: "\f013" !important;
}

.fa-trash:before,
.fas.fa-trash:before {
    content: "\f1f8" !important;
}

.fa-print:before,
.fas.fa-print:before {
    content: "\f02f" !important;
}

.fa-download:before,
.fas.fa-download:before {
    content: "\f019" !important;
}

.fa-upload:before,
.fas.fa-upload:before {
    content: "\f093" !important;
}

.fa-search:before,
.fas.fa-search:before {
    content: "\f002" !important;
}

.fa-filter:before,
.fas.fa-filter:before {
    content: "\f0b0" !important;
}

.fa-eye:before,
.fas.fa-eye:before {
    content: "\f06e" !important;
}

.fa-shopping-cart:before,
.fas.fa-shopping-cart:before {
    content: "\f07a" !important;
}

.fa-sign-out-alt:before,
.fas.fa-sign-out-alt:before {
    content: "\f2f5" !important;
}

.fa-bars:before,
.fas.fa-bars:before {
    content: "\f0c9" !important;
}

.fa-ellipsis-v:before,
.fas.fa-ellipsis-v:before {
    content: "\f142" !important;
}

.fa-bed:before,
.fas.fa-bed:before {
    content: "\f236" !important;
}

.fa-bath:before,
.fas.fa-bath:before {
    content: "\f2cd" !important;
}

.fa-users:before,
.fas.fa-users:before {
    content: "\f0c0" !important;
}

.fa-money-bill-wave:before,
.fas.fa-money-bill-wave:before {
    content: "\f53a" !important;
}

.fa-chart-line:before,
.fas.fa-chart-line:before {
    content: "\f201" !important;
}

.fa-hashtag:before,
.fas.fa-hashtag:before {
    content: "\f292" !important;
}

.fa-location-arrow:before,
.fas.fa-location-arrow:before {
    content: "\f124" !important;
}

.fa-undo:before,
.fas.fa-undo:before {
    content: "\f0e2" !important;
}

.fa-camera:before,
.fas.fa-camera:before {
    content: "\f030" !important;
}

.fa-lock:before,
.fas.fa-lock:before {
    content: "\f023" !important;
}

.fa-bookmark:before,
.fas.fa-bookmark:before {
    content: "\f02e" !important;
}

.fa-bell-slash:before,
.fas.fa-bell-slash:before {
    content: "\f1f6" !important;
}

.fa-check-double:before,
.fas.fa-check-double:before {
    content: "\f560" !important;
}

.fa-arrows-alt-h:before,
.fas.fa-arrows-alt-h:before {
    content: "\f337" !important;
}
</style>
