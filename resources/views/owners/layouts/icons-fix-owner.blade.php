{{-- Owner Section Icons Fix --}}

<!-- Font Awesome 6 Primary -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Font Awesome 5 Fallback -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* Owner Dashboard Icons Fix */
.owner-wrapper i[class*="fa-"],
.owner-wrapper span[class*="fa-"],
#wrapper i[class*="fa-"],
#wrapper span[class*="fa-"],
i[class*="fa-"],
span[class*="fa-"] {
    font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
    font-weight: 900 !important;
    font-style: normal !important;
    display: inline-block !important;
    -webkit-font-smoothing: antialiased !important;
}

/* Regular icons */
i.far, span.far,
i[class*="fa-"].far,
span[class*="fa-"].far {
    font-weight: 400 !important;
}

/* Brand icons */
i.fab, span.fab,
i[class*="fa-"].fab,
span[class*="fa-"].fab {
    font-family: "Font Awesome 6 Brands", "Font Awesome 5 Brands" !important;
    font-weight: 400 !important;
}

/* Fix specific icons in Owner section */
.fas.fa-home:before { content: "\f015" !important; }
.fas.fa-users:before { content: "\f0c0" !important; }
.fas.fa-calendar:before { content: "\f133" !important; }
.fas.fa-money-bill-wave:before { content: "\f53a" !important; }
.fas.fa-chart-line:before { content: "\f201" !important; }
.fas.fa-bell:before { content: "\f0f3" !important; }
.fas.fa-cog:before { content: "\f013" !important; }
.fas.fa-sign-out-alt:before { content: "\f2f5" !important; }
.fas.fa-check:before { content: "\f00c" !important; }
.fas.fa-times:before { content: "\f00d" !important; }
.fas.fa-edit:before { content: "\f044" !important; }
.fas.fa-trash:before { content: "\f1f8" !important; }
.fas.fa-eye:before { content: "\f06e" !important; }
.fas.fa-download:before { content: "\f019" !important; }
.fas.fa-print:before { content: "\f02f" !important; }
.fas.fa-plus:before { content: "\f067" !important; }
.fas.fa-minus:before { content: "\f068" !important; }
.fas.fa-search:before { content: "\f002" !important; }
.fas.fa-filter:before { content: "\f0b0" !important; }
.fas.fa-bars:before { content: "\f0c9" !important; }
.fas.fa-ellipsis-v:before { content: "\f142" !important; }
.fas.fa-bed:before { content: "\f236" !important; }
.fas.fa-bath:before { content: "\f2cd" !important; }
.fas.fa-hashtag:before { content: "\f292" !important; }
.fas.fa-location-arrow:before { content: "\f124" !important; }
.fas.fa-undo:before { content: "\f0e2" !important; }
.fas.fa-camera:before { content: "\f030" !important; }
.fas.fa-lock:before { content: "\f023" !important; }
.fas.fa-check-circle:before { content: "\f058" !important; }
.fas.fa-times-circle:before { content: "\f057" !important; }
.fas.fa-info-circle:before { content: "\f05a" !important; }
.fas.fa-exclamation-circle:before { content: "\f06a" !important; }
.fas.fa-user-circle:before { content: "\f2bd" !important; }

/* Ensure icons in buttons and links work */
.btn i[class*="fa-"],
button i[class*="fa-"],
a i[class*="fa-"] {
    margin: 0 5px !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Owner Icons Auto-Fix
    function autoFixOwnerIcons() {
        const allIcons = document.querySelectorAll('i[class*="fa-"], span[class*="fa-"]');
        
        allIcons.forEach(function(icon) {
            // Remove conflicting classes
            const classes = icon.className.split(' ');
            const cleanedClasses = [];
            let style = 'solid';
            let iconName = null;
            
            classes.forEach(function(cls) {
                if (cls.startsWith('fa-') && 
                    cls !== 'fa-solid' && 
                    cls !== 'fa-regular' && 
                    cls !== 'fa-brands') {
                    iconName = cls;
                    cleanedClasses.push(cls);
                } else if (cls === 'far' || cls === 'fa-regular') {
                    style = 'regular';
                } else if (cls === 'fab' || cls === 'fa-brands') {
                    style = 'brands';
                } else if (!cls.startsWith('fa') && cls !== 'fas' && cls !== 'far' && cls !== 'fab') {
                    cleanedClasses.push(cls);
                }
            });
            
            // Add correct style class
            if (iconName) {
                if (style === 'solid') {
                    cleanedClasses.unshift('fas');
                } else if (style === 'regular') {
                    cleanedClasses.unshift('far');
                } else if (style === 'brands') {
                    cleanedClasses.unshift('fab');
                }
                
                icon.className = cleanedClasses.join(' ');
            }
        });
        
        // Fix old icon names
        const replacements = {
            'fa-check-circle': 'fa-circle-check',
            'fa-times-circle': 'fa-circle-xmark',
            'fa-info-circle': 'fa-circle-info',
            'fa-user-circle': 'fa-circle-user',
            'fa-trash-alt': 'fa-trash-can',
            'fa-calendar-alt': 'fa-calendar-days',
            'fa-sign-out-alt': 'fa-right-from-bracket'
        };
        
        Object.keys(replacements).forEach(function(oldClass) {
            document.querySelectorAll('.' + oldClass).forEach(function(el) {
                el.classList.remove(oldClass);
                el.classList.add(replacements[oldClass]);
            });
        });
    }
    
    // Run multiple times to ensure all icons are fixed
    autoFixOwnerIcons();
    setTimeout(autoFixOwnerIcons, 100);
    setTimeout(autoFixOwnerIcons, 500);
    setTimeout(autoFixOwnerIcons, 1000);
    
    // Watch for new content
    if (typeof MutationObserver !== 'undefined') {
        const observer = new MutationObserver(function() {
            autoFixOwnerIcons();
        });
        
        if (document.body) {
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        }
    }
    
    // Fix after AJAX
    if (window.jQuery) {
        jQuery(document).ajaxComplete(autoFixOwnerIcons);
    }
});
</script>
