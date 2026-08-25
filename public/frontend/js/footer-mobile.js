/**
 * Footer Mobile Enhancements
 * Improves footer UX on mobile devices
 */

document.addEventListener('DOMContentLoaded', function() {
    // Check if mobile device
    const isMobile = window.innerWidth <= 768;

    if (isMobile) {
        initMobileFooter();
    }

    // Re-initialize on window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            const isNowMobile = window.innerWidth <= 768;
            if (isNowMobile) {
                initMobileFooter();
            } else {
                removeMobileFooter();
            }
        }, 250);
    });
});

/**
 * Initialize mobile footer features
 */
function initMobileFooter() {
    // Add mobile class to footer
    const footer = document.querySelector('.footer-section');
    if (footer) {
        footer.classList.add('mobile-footer');
    }

    // Reduce logo size for mobile
    reduceMobileLogo();

    // Make footer columns collapsible
    makeFooterCollapsible();

    // Enhance social links for touch
    enhanceSocialLinks();

    // Add smooth scroll for auth button
    smoothScrollAuthButton();

    // Add haptic feedback for iOS
    addHapticFeedback();

    // Hide auth button if user is logged in
    checkAuthStatus();
}

/**
 * Remove mobile footer features
 */
function removeMobileFooter() {
    const footer = document.querySelector('.footer-section');
    if (footer) {
        footer.classList.remove('mobile-footer');
    }

    // Remove collapsible functionality
    const columns = document.querySelectorAll('.footer-column');
    columns.forEach(column => {
        const title = column.querySelector('.footer-column-title');
        const menu = column.querySelector('.footer-menu, .contact-info');

        if (title) {
            title.style.cursor = 'default';
        }

        if (menu) {
            menu.style.display = '';
            menu.style.maxHeight = '';
            menu.style.overflow = '';
            menu.style.transition = '';
        }
    });
}

/**
 * Make footer columns collapsible on mobile
 */
function makeFooterCollapsible() {

    const columns = document.querySelectorAll('.footer-column');

    columns.forEach((column, index) => {
        const title = column.querySelector('.footer-column-title');
        const content = column.querySelector('.footer-menu, .contact-info');

        if (title && content) {
            // Add collapsible attributes
            title.style.cursor = 'pointer';
            title.setAttribute('role', 'button');
            // All columns closed by default
            title.setAttribute('aria-expanded', 'false');
            title.setAttribute('tabindex', '0');

            // Set initial state (all columns closed)
            content.style.display = 'none';
            content.style.maxHeight = '0';
            content.style.overflow = 'hidden';
            content.style.transition = 'max-height 0.3s ease';

            // Add click handler
            title.addEventListener('click', function() {
                toggleColumn(column, title, content);
            });

            // Add keyboard support
            title.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleColumn(column, title, content);
                }
            });
        }
    });
}

/**
 * Toggle footer column visibility
 */
function toggleColumn(column, title, content) {
    const isExpanded = title.getAttribute('aria-expanded') === 'true';

    // Close all other columns
    const allColumns = document.querySelectorAll('.footer-column');
    allColumns.forEach(col => {
        if (col !== column) {
            const otherTitle = col.querySelector('.footer-column-title');
            const otherContent = col.querySelector('.footer-menu, .contact-info');

            if (otherTitle && otherContent) {
                otherTitle.setAttribute('aria-expanded', 'false');
                otherContent.style.maxHeight = '0';
                setTimeout(() => {
                    otherContent.style.display = 'none';
                }, 300);
            }
        }
    });

    // Toggle current column
    if (isExpanded) {
        title.setAttribute('aria-expanded', 'false');
        content.style.maxHeight = '0';
        setTimeout(() => {
            content.style.display = 'none';
        }, 300);
    } else {
        title.setAttribute('aria-expanded', 'true');
        content.style.display = 'block';
        // Force reflow
        content.offsetHeight;
        content.style.maxHeight = content.scrollHeight + 'px';
    }

    // Update arrow indicator
    updateArrowIndicator(title, !isExpanded);
}




/**
 * Update arrow indicator for collapsible columns
 */
function updateArrowIndicator(title, isExpanded) {
    const pseudo = window.getComputedStyle(title, '::after');
    if (pseudo) {
        title.style.setProperty('--arrow-rotation', isExpanded ? '180deg' : '0deg');
    }
}

/**
 * Enhance social links for better touch interaction
 */
function enhanceSocialLinks() {
    const socialLinks = document.querySelectorAll('.social-link');

    socialLinks.forEach(link => {
        // Add touch feedback
        link.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.95)';
        });

        link.addEventListener('touchend', function() {
            this.style.transform = 'scale(1)';
        });

        // Prevent accidental clicks
        let touchStartTime;
        link.addEventListener('touchstart', function() {
            touchStartTime = Date.now();
        });

        link.addEventListener('touchend', function(e) {
            const touchDuration = Date.now() - touchStartTime;
            if (touchDuration < 100) {
                e.preventDefault(); // Too quick, probably accidental
            }
        });
    });
}

/**
 * Add smooth scroll for auth button
 */
function smoothScrollAuthButton() {
    const authLink = document.querySelector('.auth-link');

    if (authLink) {
        authLink.addEventListener('click', function(e) {
            // If it's a link to login page, add smooth transition
            if (this.getAttribute('href') && this.getAttribute('href').includes('login')) {
                // Optional: Add loading state
                this.style.opacity = '0.7';
                this.style.pointerEvents = 'none';

                // Add loading spinner
                const originalContent = this.innerHTML;
                this.innerHTML += '<span class="spinner-border spinner-border-sm ms-2" role="status"></span>';

                // Reset after a moment (in case navigation is cancelled)
                setTimeout(() => {
                    this.style.opacity = '1';
                    this.style.pointerEvents = 'auto';
                    this.innerHTML = originalContent;
                }, 3000);
            }
        });
    }
}

/**
 * Add haptic feedback for iOS devices
 */
function addHapticFeedback() {
    // Check if device supports haptic feedback
    if ('vibrate' in navigator) {
        const interactiveElements = document.querySelectorAll(
            '.footer-section .social-link, .footer-section .auth-link, .footer-column-title[role="button"]'
        );

        interactiveElements.forEach(element => {
            element.addEventListener('touchstart', function() {
                // Light haptic feedback
                navigator.vibrate(10);
            });
        });
    }
}

/**
 * Reduce logo size for mobile
 */
function reduceMobileLogo() {
    const logo = document.querySelector('.footer-logo img');
    if (logo && window.innerWidth <= 768) {
        // Force smaller size on mobile
        logo.style.width = '45px';
        logo.style.height = 'auto';
        logo.style.maxWidth = '45px';

        // Add specific mobile class
        logo.classList.add('mobile-logo');
    }
}

/**
 * Check authentication status and hide/show auth button
 */
function checkAuthStatus() {
    // Check if user is logged in (you can modify this based on your auth system)
    const authLinks = document.querySelector('.auth-links');
    if (authLinks) {
        // Check for any indicator that user is logged in
        // This could be a cookie, localStorage item, or data attribute
        const isLoggedIn = document.body.dataset.userLoggedIn === 'true' ||
                          localStorage.getItem('user_logged_in') === 'true' ||
                          document.querySelector('.user-menu') !== null;

        if (isLoggedIn) {
            authLinks.style.display = 'none';
        }
    }
}

/**
 * Add CSS for collapsible animation and mobile optimizations
 */
const style = document.createElement('style');
style.textContent = `
    .mobile-footer .footer-column-title::after {
        transition: transform 0.3s ease;
        transform: rotate(var(--arrow-rotation, 0deg));
    }

    .mobile-footer .footer-menu,
    .mobile-footer .contact-info {
        transition: max-height 0.3s ease, opacity 0.3s ease;
    }

    .mobile-footer .social-link {
        transition: transform 0.2s ease, background-color 0.3s ease;
    }

    .mobile-footer .auth-link {
        transition: all 0.3s ease;
    }

    /* Force smaller logo on mobile */
    .mobile-footer .footer-logo img,
    .footer-logo img.mobile-logo {
        width: 45px !important;
        height: auto !important;
        max-width: 45px !important;
    }

    /* Compact footer for mobile */
    @media (max-width: 768px) {
        .footer-section {
            padding: 20px 0 0 !important;
        }

        .footer-content {
            padding: 15px 10px !important;
        }

        .footer-brand {
            padding: 10px !important;
            margin-bottom: 10px !important;
        }

        .footer-description {
            font-size: 0.75rem !important;
            line-height: 1.2 !important;
        }

        .footer-logo {
            margin-bottom: 8px !important;
        }

        .footer-bottom {
            padding: 10px 0 !important;
        }

        .footer-bottom-content {
            padding: 0 10px !important;
        }

        .copyright {
            font-size: 0.7rem !important;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .mobile-footer * {
            transition: none !important;
            animation: none !important;
        }
    }
`;
document.head.appendChild(style);
