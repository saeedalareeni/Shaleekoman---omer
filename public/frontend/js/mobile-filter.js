/**
 * Mobile Filter Enhancements
 * Improves filter UX on mobile devices
 */

document.addEventListener('DOMContentLoaded', function() {
    // Check if mobile
    if (window.innerWidth <= 768) {
        initMobileFilter();
    }

    // Re-initialize on resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth <= 768) {
                initMobileFilter();
            } else {
                removeMobileFilter();
            }
        }, 250);
    });
});

/**
 * Initialize mobile filter features
 */
function initMobileFilter() {
    // Add mobile class
    const filterSection = document.querySelector('.filter-section');
    if (filterSection) {
        filterSection.classList.add('mobile-filter');
    }

    // Improve select placeholders for mobile
    updateSelectPlaceholders();

    // Add touch feedback
    addTouchFeedback();

    // Initialize custom select behavior
    initCustomSelect();

    // Add filter counter
    addFilterCounter();

    // Add clear filters button
    addClearFiltersButton();

    // Save filter state
    saveFilterState();
}

/**
 * Remove mobile filter features
 */
function removeMobileFilter() {
    const filterSection = document.querySelector('.filter-section');
    if (filterSection) {
        filterSection.classList.remove('mobile-filter');
    }
}

/**
 * Update select placeholders for better mobile UX
 */
function updateSelectPlaceholders() {
    const selects = document.querySelectorAll('.filter-section select');
    const isArabic = document.documentElement.lang === 'ar' || document.documentElement.dir === 'rtl';

    selects.forEach(select => {
        const firstOption = select.querySelector('option:first-child');
        if (firstOption && firstOption.value === '0') {
            // Update placeholder text based on select name
            const name = select.getAttribute('name');
            let newText = '';

            switch(name) {
                case 'city':
                    newText = isArabic ? 'المدينة' : 'City';
                    break;
                case 'area':
                    newText = isArabic ? 'المنطقة' : 'Area';
                    break;
                case 'category':
                    newText = isArabic ? 'النوع' : 'Type';
                    break;
                case 'date-price':
                    newText = isArabic ? 'السعر' : 'Price';
                    break;
                default:
                    newText = firstOption.textContent;
            }

            // Update the text
            firstOption.textContent = newText;
            
            // If using Select2, update it
            if ($(select).data('select2')) {
                $(select).trigger('change');
            }
        }
    });
}

/**
 * Add touch feedback to interactive elements
 */
function addTouchFeedback() {
    const interactiveElements = document.querySelectorAll(
        '.filter-section select, .filter-section button, .filter-section .select2-selection'
    );

    interactiveElements.forEach(element => {
        element.addEventListener('touchstart', function() {
            this.style.opacity = '0.8';
        });

        element.addEventListener('touchend', function() {
            this.style.opacity = '1';
        });
    });
}

/**
 * Initialize custom select behavior
 */
function initCustomSelect() {
    const selects = document.querySelectorAll('.filter-section select');

    selects.forEach(select => {
        // Add change event listener
        select.addEventListener('change', function() {
            // Add active class if value is selected
            if (this.value && this.value !== '0') {
                this.classList.add('has-value');
                this.style.background = '#e8f5f0';
                this.style.borderColor = '#127664';
            } else {
                this.classList.remove('has-value');
                this.style.background = '#f8f9fa';
                this.style.borderColor = '#e0e0e0';
            }

            // Update filter counter
            updateFilterCounter();
        });

        // Trigger change event to set initial state
        select.dispatchEvent(new Event('change'));
    });
}

/**
 * Add filter counter badge
 */
function addFilterCounter() {
    const filterSection = document.querySelector('.filter-section');
    if (!filterSection) return;

    // Create counter element
    const counter = document.createElement('div');
    counter.className = 'filter-counter';
    counter.style.cssText = `
        position: absolute;
        top: -8px;
        right: 10px;
        background: #ff4757;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        z-index: 10;
        box-shadow: 0 2px 6px rgba(255, 71, 87, 0.3);
    `;

    // Add to filter section
    filterSection.style.position = 'relative';
    filterSection.appendChild(counter);

    // Update counter
    updateFilterCounter();
}

/**
 * Update filter counter
 */
function updateFilterCounter() {
    const counter = document.querySelector('.filter-counter');
    if (!counter) return;

    const selects = document.querySelectorAll('.filter-section select');
    let activeFilters = 0;

    selects.forEach(select => {
        if (select.value && select.value !== '0' && select.value !== '') {
            activeFilters++;
        }
    });

    if (activeFilters > 0) {
        counter.textContent = activeFilters;
        counter.style.display = 'flex';
    } else {
        counter.style.display = 'none';
    }
}

/**
 * Add clear filters button
 */
function addClearFiltersButton() {
    const searchButton = document.querySelector('.filter-section .btn-circle, .filter-section .btn-gradient');
    if (!searchButton) return;

    const isArabic = document.documentElement.lang === 'ar' || document.documentElement.dir === 'rtl';

    // Check if clear button already exists
    if (document.querySelector('.clear-filters-btn')) return;

    // Create clear button
    const clearButton = document.createElement('button');
    clearButton.type = 'button';
    clearButton.className = 'clear-filters-btn';
    clearButton.innerHTML = `
        <i class="fas fa-times-circle"></i>
        <span>${isArabic ? 'مسح' : 'Clear'}</span>
    `;
    clearButton.style.cssText = `
        width: 100%;
        height: 36px;
        margin-top: 8px;
        padding: 0 16px;
        background: white;
        border: 1.5px solid #e0e0e0;
        border-radius: 10px;
        color: #666;
        font-size: 0.85rem;
        font-weight: 500;
        display: none;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.3s ease;
        cursor: pointer;
    `;

    // Add hover effect
    clearButton.addEventListener('mouseenter', function() {
        this.style.background = '#f8f9fa';
        this.style.borderColor = '#ff4757';
        this.style.color = '#ff4757';
    });

    clearButton.addEventListener('mouseleave', function() {
        this.style.background = 'white';
        this.style.borderColor = '#e0e0e0';
        this.style.color = '#666';
    });

    // Add click handler
    clearButton.addEventListener('click', function() {
        clearAllFilters();
    });

    // Insert after search button
    searchButton.parentElement.appendChild(clearButton);

    // Show/hide based on filter state
    updateClearButton();
}

/**
 * Clear all filters
 */
function clearAllFilters() {
    const selects = document.querySelectorAll('.filter-section select');
    
    selects.forEach(select => {
        select.value = '0';
        select.classList.remove('has-value');
        select.style.background = '#f8f9fa';
        select.style.borderColor = '#e0e0e0';
        
        // Trigger change event
        select.dispatchEvent(new Event('change'));
        
        // Update Select2 if exists
        if ($(select).data('select2')) {
            $(select).val('0').trigger('change');
        }
    });

    // Update counter and clear button
    updateFilterCounter();
    updateClearButton();

    // Add animation feedback
    const filterSection = document.querySelector('.filter-section');
    filterSection.style.animation = 'shake 0.3s ease';
    setTimeout(() => {
        filterSection.style.animation = '';
    }, 300);
}

/**
 * Update clear button visibility
 */
function updateClearButton() {
    const clearButton = document.querySelector('.clear-filters-btn');
    if (!clearButton) return;

    const selects = document.querySelectorAll('.filter-section select');
    let hasActiveFilters = false;

    selects.forEach(select => {
        if (select.value && select.value !== '0' && select.value !== '') {
            hasActiveFilters = true;
        }
    });

    clearButton.style.display = hasActiveFilters ? 'flex' : 'none';
}

/**
 * Save filter state to localStorage
 */
function saveFilterState() {
    const selects = document.querySelectorAll('.filter-section select');
    
    selects.forEach(select => {
        select.addEventListener('change', function() {
            const filterState = {};
            
            document.querySelectorAll('.filter-section select').forEach(s => {
                if (s.value && s.value !== '0') {
                    filterState[s.name] = s.value;
                }
            });
            
            localStorage.setItem('filterState', JSON.stringify(filterState));
        });
    });

    // Restore filter state on page load
    restoreFilterState();
}

/**
 * Restore filter state from localStorage
 */
function restoreFilterState() {
    const savedState = localStorage.getItem('filterState');
    if (!savedState) return;

    try {
        const filterState = JSON.parse(savedState);
        
        Object.keys(filterState).forEach(name => {
            const select = document.querySelector(`.filter-section select[name="${name}"]`);
            if (select) {
                select.value = filterState[name];
                select.dispatchEvent(new Event('change'));
                
                // Update Select2 if exists
                if ($(select).data('select2')) {
                    $(select).val(filterState[name]).trigger('change');
                }
            }
        });

        // Update UI
        updateFilterCounter();
        updateClearButton();
    } catch (e) {
        console.error('Error restoring filter state:', e);
    }
}

/**
 * Add shake animation
 */
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
`;
document.head.appendChild(style);
