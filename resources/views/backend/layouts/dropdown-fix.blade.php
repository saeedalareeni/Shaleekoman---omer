{{-- Dropdown Menu Fix for Admin Panel --}}
<style>
/* Reset and base styles for dropdowns */
.navigation-menu {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.navigation-menu > li {
    position: relative;
    list-style: none;
}

.navigation-menu > li > a {
    display: block;
    padding: 10px 15px;
    text-decoration: none;
    cursor: pointer;
}

/* Submenu styles */
.navigation-menu .submenu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 200px;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: 1px solid #e3e3e3;
    border-radius: 0 0 4px 4px;
    z-index: 9999;
    padding: 0;
    margin: 0;
    list-style: none;
}

.navigation-menu .submenu li {
    list-style: none;
    margin: 0;
    padding: 0;
}

.navigation-menu .submenu a {
    display: block;
    padding: 10px 20px;
    color: #333;
    text-decoration: none;
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.navigation-menu .submenu a:hover {
    background: #f8f9fa;
    color: #14b024;
    padding-left: 25px;
}

.navigation-menu .submenu li:last-child a {
    border-bottom: none;
}

/* Show submenu when parent has 'open' class */
.navigation-menu li.open > .submenu {
    display: block !important;
}

/* Arrow indicator */
.navigation-menu .arrow-down {
    display: inline-block;
    margin-left: 5px;
    transition: transform 0.3s ease;
}

.navigation-menu li.open .arrow-down {
    transform: rotate(180deg);
}

/* Header dropdown styles */
.dropdown-menu {
    display: none;
    position: absolute;
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    z-index: 9999;
    min-width: 160px;
    padding: 5px 0;
    margin: 2px 0 0;
}

.dropdown-menu.show {
    display: block !important;
}

.dropdown-menu .dropdown-item {
    display: block;
    padding: 8px 20px;
    color: #333;
    text-decoration: none;
    transition: all 0.3s ease;
}

.dropdown-menu .dropdown-item:hover {
    background: #f8f9fa;
    color: #14b024;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .navigation-menu {
        flex-direction: column;
    }
    
    .navigation-menu .submenu {
        position: static;
        width: 100%;
        box-shadow: none;
        border: none;
        background: #f8f9fa;
        padding-left: 20px;
    }
}
</style>

<script>
(function() {
    'use strict';
    
    // Function to initialize dropdowns
    function initializeDropdowns() {
        console.log('Initializing dropdown menus...');
        
        // Handle navigation menu dropdowns
        const navLinks = document.querySelectorAll('.navigation-menu li.has-submenu > a');
        
        navLinks.forEach(function(link) {
            // Remove any existing event listeners
            const newLink = link.cloneNode(true);
            link.parentNode.replaceChild(newLink, link);
            
            // Add click event
            newLink.addEventListener('click', function(e) {
                const parent = this.parentElement;
                const submenu = parent.querySelector('.submenu');
                
                // If has submenu or arrow, prevent navigation
                if (submenu || this.querySelector('.arrow-down')) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Close all other submenus
                    document.querySelectorAll('.navigation-menu li.has-submenu').forEach(function(item) {
                        if (item !== parent) {
                            item.classList.remove('open');
                        }
                    });
                    
                    // Toggle current submenu
                    parent.classList.toggle('open');
                    
                    console.log('Toggled:', this.textContent.trim());
                }
            });
        });
        
        // Handle header dropdown menus (user menu, language, etc.)
        const dropdownToggles = document.querySelectorAll('[data-toggle="dropdown"]');
        
        dropdownToggles.forEach(function(toggle) {
            // Remove existing listeners
            const newToggle = toggle.cloneNode(true);
            toggle.parentNode.replaceChild(newToggle, toggle);
            
            // Add click event
            newToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const menu = this.nextElementSibling;
                if (menu && menu.classList.contains('dropdown-menu')) {
                    // Close all other dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(function(m) {
                        if (m !== menu) {
                            m.classList.remove('show');
                        }
                    });
                    
                    // Toggle current dropdown
                    menu.classList.toggle('show');
                }
            });
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            // Close navigation submenus
            if (!e.target.closest('.navigation-menu')) {
                document.querySelectorAll('.navigation-menu li.has-submenu').forEach(function(item) {
                    item.classList.remove('open');
                });
            }
            
            // Close header dropdowns
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                    menu.classList.remove('show');
                });
            }
        });
        
        console.log('Dropdowns initialized successfully!');
    }
    
    // Initialize on different events to ensure it works
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeDropdowns);
    } else {
        // DOM is already loaded
        initializeDropdowns();
    }
    
    // Also initialize on window load as fallback
    window.addEventListener('load', function() {
        setTimeout(initializeDropdowns, 100);
    });
    
    // Reinitialize after AJAX calls if jQuery is available
    if (typeof jQuery !== 'undefined') {
        jQuery(document).ajaxComplete(function() {
            setTimeout(initializeDropdowns, 100);
        });
    }
})();
</script>
