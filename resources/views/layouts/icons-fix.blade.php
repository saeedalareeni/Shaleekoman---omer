{{-- Font Awesome Complete Fix - All Versions --}}

{{-- Font Awesome 6 CDN - Primary --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

{{-- Font Awesome 6 Alternative CDN --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">

{{-- Include Icon Classes Fix After Loading Font Awesome --}}
@include('layouts.icon-classes-fix')

{{-- Include Ultimate Icon Fix --}}
@include('layouts.ultimate-icon-fix')

{{-- Font Awesome 5 CDN as Fallback --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

{{-- Font Awesome 4 CDN for Legacy Icons --}}
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

{{-- Material Icons as Alternative --}}
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

{{-- Bootstrap Icons as Alternative --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

{{-- Critical CSS for Icons --}}
<style>
/* Force Font Awesome to Load */
.fa, .fas, .far, .fab, .fal, .fad,
.fa-solid, .fa-regular, .fa-light, .fa-brands {
    display: inline-block !important;
    font-style: normal !important;
    font-variant: normal !important;
    text-rendering: auto !important;
    line-height: 1 !important;
    -webkit-font-smoothing: antialiased !important;
    -moz-osx-font-smoothing: grayscale !important;
}

/* Fix for elements with multiple conflicting classes */
[class*="fas"][class*="fa-solid"],
[class*="far"][class*="fa-regular"],
[class*="fab"][class*="fa-brands"] {
    font-family: 'Font Awesome 6 Free', 'Font Awesome 5 Free' !important;
}

/* Specific fix for common problematic combinations */
.fas.fa-solid.fa-circle-user,
.fas.fa-solid.fa-check-circle,
.fas.fa-solid.fa-times-circle,
.fas.fa-solid.fa-info-circle {
    font-family: 'Font Awesome 6 Free' !important;
    font-weight: 900 !important;
}

/* Remove fa class conflicts */
.fa.fas,
.fa.far,
.fa.fab {
    font-family: inherit !important;
}

/* Font Awesome 6 */
.fa-solid, .fas {
    font-family: 'Font Awesome 6 Free', 'Font Awesome 5 Free', 'FontAwesome' !important;
    font-weight: 900 !important;
}

.fa-regular, .far {
    font-family: 'Font Awesome 6 Free', 'Font Awesome 5 Free', 'FontAwesome' !important;
    font-weight: 400 !important;
}

.fa-brands, .fab {
    font-family: 'Font Awesome 6 Brands', 'Font Awesome 5 Brands' !important;
    font-weight: 400 !important;
}

/* Font Awesome 5 */
.fa {
    font-family: 'Font Awesome 5 Free', 'FontAwesome' !important;
    font-weight: 900 !important;
}

/* Font Awesome 4 */
.fa:not(.fa-solid):not(.fa-regular):not(.fa-brands) {
    font-family: 'FontAwesome' !important;
    font-weight: normal !important;
}

/* Ensure icons show in buttons and cards */
button i, .btn i, .card i, a i, span i, div i {
    display: inline-block !important;
    width: auto !important;
    height: auto !important;
    margin: 0 5px !important;
}

/* Fix for RTL */
[dir="rtl"] i {
    margin: 0 5px !important;
}

/* Prevent icon hiding */
i[class*="fa-"]:before,
i[class*="fa-"]:after {
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

/* Bootstrap Icons Support */
.bi {
    display: inline-block !important;
    font-style: normal !important;
    font-weight: normal !important;
    line-height: 1 !important;
    vertical-align: -.125em !important;
}

/* Material Icons Support */
.material-icons {
    font-family: 'Material Icons' !important;
    font-weight: normal !important;
    font-style: normal !important;
    font-size: 24px !important;
    line-height: 1 !important;
    letter-spacing: normal !important;
    text-transform: none !important;
    display: inline-block !important;
    white-space: nowrap !important;
    word-wrap: normal !important;
    direction: ltr !important;
    -webkit-font-smoothing: antialiased !important;
}
</style>

{{-- JavaScript Fallback Loader --}}
<script>
(function() {
    // Check if Font Awesome loaded
    function checkFontAwesome() {
        var span = document.createElement('span');
        span.className = 'fa';
        span.style.display = 'none';
        document.body.appendChild(span);
        
        var width = window.getComputedStyle(span, ':before').getPropertyValue('font-family');
        document.body.removeChild(span);
        
        if (width.indexOf('Font Awesome') === -1 && width.indexOf('FontAwesome') === -1) {
            console.log('Font Awesome not loaded, loading via JavaScript...');
            loadFontAwesomeJS();
        }
    }
    
    // Load Font Awesome via JavaScript
    function loadFontAwesomeJS() {
        // Load CSS
        var link1 = document.createElement('link');
        link1.rel = 'stylesheet';
        link1.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css';
        document.head.appendChild(link1);
        
        // Load Kit
        var script = document.createElement('script');
        script.src = 'https://kit.fontawesome.com/a076d05399.js';
        script.crossOrigin = 'anonymous';
        document.head.appendChild(script);
        
        // Force refresh icons after load
        setTimeout(function() {
            refreshIcons();
        }, 1000);
    }
    
    // Refresh all icons on page
    function refreshIcons() {
        var icons = document.querySelectorAll('i[class*="fa-"]');
        icons.forEach(function(icon) {
            var classes = icon.className;
            icon.className = '';
            void icon.offsetWidth; // Force reflow
            icon.className = classes;
        });
    }
    
    // Convert icon placeholders to actual icons
    function convertIconPlaceholders() {
        // Find all elements with data-icon attribute
        var placeholders = document.querySelectorAll('[data-icon]');
        placeholders.forEach(function(el) {
            var iconClass = el.getAttribute('data-icon');
            if (iconClass && !el.querySelector('i')) {
                var icon = document.createElement('i');
                icon.className = iconClass;
                el.insertBefore(icon, el.firstChild);
            }
        });
    }
    
    // Run checks when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(checkFontAwesome, 100);
            convertIconPlaceholders();
        });
    } else {
        setTimeout(checkFontAwesome, 100);
        convertIconPlaceholders();
    }
    
    // Also check after window load
    window.addEventListener('load', function() {
        setTimeout(function() {
            checkFontAwesome();
            refreshIcons();
        }, 500);
    });
    
    // Refresh icons on dynamic content load
    if (typeof MutationObserver !== 'undefined') {
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length) {
                    convertIconPlaceholders();
                    setTimeout(refreshIcons, 100);
                }
            });
        });
        
        if (document.body) {
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        }
    }
})();
</script>

{{-- Alternative Icon Mapping --}}
<script>
// Map Font Awesome classes to Unicode characters as fallback
window.iconFallbacks = {
    'fa-home': '🏠',
    'fa-user': '👤',
    'fa-bell': '🔔',
    'fa-heart': '❤️',
    'fa-star': '⭐',
    'fa-check': '✓',
    'fa-times': '✕',
    'fa-search': '🔍',
    'fa-envelope': '✉️',
    'fa-phone': '📞',
    'fa-calendar': '📅',
    'fa-clock': '🕐',
    'fa-trash': '🗑️',
    'fa-edit': '✏️',
    'fa-plus': '➕',
    'fa-minus': '➖',
    'fa-download': '⬇️',
    'fa-upload': '⬆️',
    'fa-cog': '⚙️',
    'fa-shopping-cart': '🛒'
};

// Apply fallbacks if icons don't load
setTimeout(function() {
    document.querySelectorAll('i[class*="fa-"]').forEach(function(icon) {
        if (window.getComputedStyle(icon, ':before').content === 'none') {
            var classes = icon.className.split(' ');
            for (var i = 0; i < classes.length; i++) {
                if (window.iconFallbacks[classes[i]]) {
                    icon.textContent = window.iconFallbacks[classes[i]];
                    icon.style.fontFamily = 'inherit';
                    break;
                }
            }
        }
    });
}, 2000);
</script>
