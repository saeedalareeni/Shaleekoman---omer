/**
 * Owner Dashboard Mobile JavaScript
 * Handles mobile interactions and responsive behavior
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ========================================
    // 1. MOBILE MENU TOGGLE
    // ========================================
    
    // Create mobile menu toggle button if not exists
    function createMobileMenuToggle() {
        if (window.innerWidth <= 768 && !document.querySelector('.mobile-menu-toggle')) {
            const headerRight = document.querySelector('.owner-header .header-right');
            if (headerRight) {
                const toggleBtn = document.createElement('button');
                toggleBtn.className = 'mobile-menu-toggle';
                toggleBtn.innerHTML = `
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                `;
                toggleBtn.addEventListener('click', toggleMobileMenu);
                headerRight.appendChild(toggleBtn);
            }
        }
    }
    
    // Toggle mobile menu
    function toggleMobileMenu() {
        const sidebar = document.querySelector('.owner-sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        
        if (sidebar) {
            sidebar.classList.toggle('active');
        }
        
        if (overlay) {
            overlay.classList.toggle('active');
        } else {
            // Create overlay if not exists
            const newOverlay = document.createElement('div');
            newOverlay.className = 'sidebar-overlay';
            newOverlay.addEventListener('click', closeMobileMenu);
            document.body.appendChild(newOverlay);
            setTimeout(() => newOverlay.classList.add('active'), 10);
        }
    }
    
    // Close mobile menu
    function closeMobileMenu() {
        const sidebar = document.querySelector('.owner-sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        
        if (sidebar) {
            sidebar.classList.remove('active');
        }
        
        if (overlay) {
            overlay.classList.remove('active');
        }
    }
    
    // ========================================
    // 2. RESPONSIVE TABLES
    // ========================================
    
    // Convert tables to card view on mobile
    function convertTablesToCards() {
        if (window.innerWidth <= 576) {
            const tables = document.querySelectorAll('.table-responsive table');
            
            tables.forEach(table => {
                // Check if already converted
                if (table.parentElement.querySelector('.mobile-table-card')) {
                    return;
                }
                
                const cardContainer = document.createElement('div');
                cardContainer.className = 'mobile-table-card';
                
                const tbody = table.querySelector('tbody');
                if (tbody) {
                    const rows = tbody.querySelectorAll('tr');
                    const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
                    
                    rows.forEach(row => {
                        const card = document.createElement('div');
                        card.className = 'card mb-2';
                        
                        const cardBody = document.createElement('div');
                        cardBody.className = 'card-body';
                        
                        const cells = row.querySelectorAll('td');
                        cells.forEach((cell, index) => {
                            if (headers[index]) {
                                const cardRow = document.createElement('div');
                                cardRow.className = 'card-row';
                                cardRow.innerHTML = `
                                    <span class="card-label">${headers[index]}:</span>
                                    <span class="card-value">${cell.innerHTML}</span>
                                `;
                                cardBody.appendChild(cardRow);
                            }
                        });
                        
                        card.appendChild(cardBody);
                        cardContainer.appendChild(card);
                    });
                }
                
                // Insert card view after table
                table.parentElement.parentElement.appendChild(cardContainer);
            });
        }
    }
    
    // ========================================
    // 3. DROPDOWN POSITIONING
    // ========================================
    
    // Fix dropdown positioning on mobile
    function fixDropdownPosition() {
        const dropdowns = document.querySelectorAll('.dropdown-menu');
        
        dropdowns.forEach(dropdown => {
            const rect = dropdown.getBoundingClientRect();
            const viewportWidth = window.innerWidth;
            
            // Check if dropdown goes outside viewport
            if (rect.right > viewportWidth) {
                dropdown.style.left = 'auto';
                dropdown.style.right = '0';
            }
            
            if (rect.left < 0) {
                dropdown.style.left = '0';
                dropdown.style.right = 'auto';
            }
        });
    }
    
    // ========================================
    // 4. TOUCH INTERACTIONS
    // ========================================
    
    // Add touch support for hover effects
    function addTouchSupport() {
        const hoverElements = document.querySelectorAll('.card, .btn, .menu-item');
        
        hoverElements.forEach(element => {
            element.addEventListener('touchstart', function() {
                this.classList.add('touch-active');
            });
            
            element.addEventListener('touchend', function() {
                setTimeout(() => {
                    this.classList.remove('touch-active');
                }, 300);
            });
        });
    }
    
    // ========================================
    // 5. FORM ENHANCEMENTS
    // ========================================
    
    // Auto-resize textareas
    function autoResizeTextareas() {
        const textareas = document.querySelectorAll('textarea');
        
        textareas.forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        });
    }
    
    // ========================================
    // 6. NOTIFICATION HANDLING
    // ========================================
    
    // Handle notification dropdown on mobile
    function handleNotifications() {
        const notificationBtn = document.querySelector('.notifications .header-btn');
        const notificationDropdown = document.querySelector('.notifications .dropdown-menu');
        
        if (notificationBtn && notificationDropdown) {
            notificationBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Close other dropdowns
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    if (menu !== notificationDropdown) {
                        menu.classList.remove('show');
                    }
                });
                
                // Toggle notification dropdown
                notificationDropdown.classList.toggle('show');
                
                // Position dropdown on mobile
                if (window.innerWidth <= 768) {
                    notificationDropdown.style.position = 'fixed';
                    notificationDropdown.style.top = '60px';
                    notificationDropdown.style.left = '10px';
                    notificationDropdown.style.right = '10px';
                    notificationDropdown.style.width = 'auto';
                }
            });
        }
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.header-item')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });
    
    // ========================================
    // 7. CALENDAR MOBILE VIEW
    // ========================================
    
    // Optimize calendar for mobile
    function optimizeCalendar() {
        if (window.innerWidth <= 768) {
            const calendar = document.querySelector('.fc');
            if (calendar) {
                // Force day view on very small screens
                if (window.innerWidth <= 480) {
                    const dayButton = document.querySelector('.fc-dayGridDay-button');
                    if (dayButton) {
                        dayButton.click();
                    }
                }
            }
        }
    }
    
    // ========================================
    // 8. CHARTS RESPONSIVE
    // ========================================
    
    // Resize charts on window resize
    function resizeCharts() {
        if (typeof Chart !== 'undefined') {
            Chart.helpers.each(Chart.instances, function(instance) {
                instance.resize();
            });
        }
    }
    
    // ========================================
    // 9. IMAGE LAZY LOADING
    // ========================================
    
    // Implement lazy loading for images
    function lazyLoadImages() {
        const images = document.querySelectorAll('img[data-src]');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    }
    
    // ========================================
    // 10. SMOOTH SCROLLING
    // ========================================
    
    // Add smooth scrolling to anchor links
    function smoothScrolling() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }
    
    // ========================================
    // 11. SWIPE GESTURES
    // ========================================
    
    // Add swipe support for sidebar
    function addSwipeSupport() {
        let touchStartX = 0;
        let touchEndX = 0;
        
        document.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        document.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });
        
        function handleSwipe() {
            const swipeThreshold = 50;
            const sidebar = document.querySelector('.owner-sidebar');
            
            if (touchEndX < touchStartX - swipeThreshold) {
                // Swipe left - close sidebar
                if (sidebar && sidebar.classList.contains('active')) {
                    closeMobileMenu();
                }
            }
            
            if (touchEndX > touchStartX + swipeThreshold) {
                // Swipe right - open sidebar (only from edge)
                if (touchStartX < 20 && sidebar) {
                    toggleMobileMenu();
                }
            }
        }
    }
    
    // ========================================
    // 12. ORIENTATION CHANGE
    // ========================================
    
    // Handle orientation change
    function handleOrientationChange() {
        window.addEventListener('orientationchange', function() {
            setTimeout(() => {
                // Recalculate layouts
                fixDropdownPosition();
                resizeCharts();
                convertTablesToCards();
            }, 300);
        });
    }
    
    // ========================================
    // 13. PERFORMANCE OPTIMIZATION
    // ========================================
    
    // Debounce function for performance
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // ========================================
    // 14. INITIALIZE ALL FUNCTIONS
    // ========================================
    
    function initMobileFeatures() {
        createMobileMenuToggle();
        convertTablesToCards();
        fixDropdownPosition();
        addTouchSupport();
        autoResizeTextareas();
        handleNotifications();
        optimizeCalendar();
        lazyLoadImages();
        smoothScrolling();
        addSwipeSupport();
        handleOrientationChange();
    }
    
    // Initialize on load
    initMobileFeatures();
    
    // Reinitialize on resize
    const debouncedResize = debounce(function() {
        createMobileMenuToggle();
        convertTablesToCards();
        fixDropdownPosition();
        resizeCharts();
    }, 250);
    
    window.addEventListener('resize', debouncedResize);
    
    // ========================================
    // 15. EXPORT FUNCTIONS
    // ========================================
    
    // Make functions available globally
    window.ownerMobile = {
        toggleMenu: toggleMobileMenu,
        closeMenu: closeMobileMenu,
        fixDropdowns: fixDropdownPosition,
        resizeCharts: resizeCharts
    };
});
