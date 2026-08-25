{{-- استخدام مكون الفلترات القابل لإعادة الاستخدام --}}
{{-- Use reusable filters component --}}
<div class="filter-pills-container">
    @include('frontend.inc._filters_component')
</div>

<style>
/* Make hero section relative */
.hero-booking-section {
    position: relative !important;
    overflow: visible !important;
}

.hero-booking-section .container-fluid {
    overflow: visible !important;
}

/* Filter Styles - Desktop */
.filter-pills-container {
    position: absolute;
    bottom: -30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 15px;
    background: white;
    padding: 12px 12px;
    border-radius: 60px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    border: 3px solid #FF6341;
    z-index: 100;
    max-width: calc(100% - 60px);
    overflow-x: auto;
    overflow-y: hidden;
}

.filter-pills-container::-webkit-scrollbar {
    display: none;
}

.search-btn {
    width: 70px;
    height: 70px;
    background: linear-gradient(180deg, #26CA8E 0%, #27A173 100%);
    border: none;
    border-radius: 50%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.search-btn svg {
    width: 35px;
    height: 34px;
}

.search-btn:hover {
    background: #138d75;
    transform: scale(1.05);
}

.filter-pill {
    background: #F1F1F1;
    border: none;
    padding: 20px 28px;
    border-radius: 30px;
    font-size: 16px;
    color: #666;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    white-space: nowrap;
    font-weight: 500;
    flex-shrink: 0;
}

.filter-pill:hover {
    background: #d8d8d8;
    transform: translateY(-2px);
}

.filter-pill:active {
    background: #127664;
    color: white;
}

.filter-pill:active i {
    color: white;
}

.filter-pill i {
    font-size: 14px;
    color: #EB5432;
}

.filter-label {
    font-size: 16px;
    line-height: 1;
    font-weight: 500;
}

.filter-count {
    background: #127664;
    color: white;
    border-radius: 8px;
    padding: 1px 5px;
    font-size: 10px;
    font-weight: 600;
    min-width: 16px;
    text-align: center;
    margin-left: 3px;
    line-height: 1.4;
}

/* Ensure filter dropdown is visible */
.filter-dropdown {
    position: relative;
}

.filter-dropdown .dropdown-content {
    position: absolute !important;
    top: 100%;
    left: 0;
    z-index: 9999 !important;
    display: none;
    margin-top: 10px;
}

.filter-dropdown.active .dropdown-content {
    display: block !important;
}

/* Make sure parent containers don't hide overflow */
.filter-pills-container {
    overflow: visible !important;
}

.hero-booking-section {
    overflow: visible !important;
}

/* RTL Support for Arabic */
html[dir="rtl"] .filter-pills-container,
.filter-pills-container.rtl {
    direction: rtl;
    flex-direction: row;
}

/* Search button position for Arabic */
html[dir="rtl"] .search-btn,
.search-btn-ar {
    order: -1; /* Move to the left side (first) */
    margin-left: 0;
    margin-right: 10px;
}

/* Reorder filters for Arabic */
html[dir="rtl"] .filter-dropdown[data-filter="gov"] { order: 1; }
html[dir="rtl"] .filter-dropdown[data-filter="state"] { order: 2; }
html[dir="rtl"] .filter-dropdown[data-filter="area"] { order: 3; }
html[dir="rtl"] .filter-dropdown[data-filter="booking"] { order: 4; }
html[dir="rtl"] .filter-dropdown[data-filter="property"] { order: 5; }
html[dir="rtl"] .filter-dropdown[data-filter="price"] { order: 6; }

/* Ensure proper spacing in RTL */
html[dir="rtl"] .filter-pill,
.filter-pills-container.rtl .filter-pill {
    margin: 0 5px;
}

/* Dropdown content alignment for RTL */
html[dir="rtl"] .dropdown-content,
.filter-pills-container.rtl .dropdown-content {
    right: auto;
    left: 0;
    text-align: right;
}

/* Checkbox alignment for RTL */
html[dir="rtl"] .checkbox-item,
.filter-pills-container.rtl .checkbox-item {
    direction: rtl;
    text-align: right;
}

html[dir="rtl"] .checkbox-item input,
.filter-pills-container.rtl .checkbox-item input {
    margin-right: 0;
    margin-left: 8px;
}

/* Date input alignment for RTL */
html[dir="rtl"] .date-range-container,
.filter-pills-container.rtl .date-range-container {
    direction: rtl;
}

html[dir="rtl"] .date-input-group label,
.filter-pills-container.rtl .date-input-group label {
    text-align: right;
}

/* Hide desktop filters on mobile */
@media (max-width: 768px) {
    .filter-pills-container {
        display: none !important;
    }
}


/* Dropdown Content Styles */
.dropdown-content {
    background: white !important;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    border: 1px solid #e0e0e0;
    min-width: 250px;
    max-width: 320px;
    animation: fadeIn 0.3s ease;
    max-height: 400px;
    overflow-y: auto;
}


@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.filter-header {
    padding: 12px 16px;
    border-bottom: 1px solid #e0e0e0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f8f9fa;
    border-radius: 12px 12px 0 0;
}

.filter-header h5 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    color: #333;
}

.close-dropdown {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #666;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.close-dropdown:hover {
    background: #e0e0e0;
    color: #333;
}

.filter-body {
    padding: 12px;
    max-height: 280px;
    overflow-y: auto;
}

.checkbox-item {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    margin-bottom: 4px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.checkbox-item:hover {
    background: #f8f9fa;
}

.checkbox-item input[type="checkbox"] {
    margin-right: 10px;
    width: 16px;
    height: 16px;
    cursor: pointer;
}

.checkbox-item span {
    font-size: 13px;
    color: #333;
}

/* Date Range Styles */
.date-range-container {
    display: flex;
    gap: 12px;
    margin-bottom: 12px;
}

.date-input-group {
    flex: 1;
}

.date-input-group label {
    display: block;
    font-size: 12px;
    color: #666;
    margin-bottom: 4px;
}

.date-input {
    width: 100%;
    padding: 8px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 13px;
}

.btn-apply-dates {
    width: 100%;
    padding: 10px;
    background: #127664;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-apply-dates:hover {
    background: #0e5a4c;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if page is in Arabic and add RTL class
    const isArabic = document.documentElement.lang === 'ar' || 
                     document.querySelector('html').getAttribute('lang') === 'ar' ||
                     '{{ app()->getLocale() }}' === 'ar';
    
    if (isArabic) {
        document.documentElement.setAttribute('dir', 'rtl');
        const filterContainer = document.querySelector('.filter-pills-container');
        if (filterContainer) {
            filterContainer.classList.add('rtl');
        }
    }
    
    const filterPills = document.querySelectorAll('.filter-pill');
    const searchBtn = document.querySelector('.search-btn, .search-btn-ar');
    
    filterPills.forEach(pill => {
        pill.addEventListener('click', function() {
            console.log('Filter clicked:', this.textContent.trim());
        });
    });
    
    if (searchBtn) {
        searchBtn.addEventListener('click', function() {
            console.log('Search button clicked');
        });
    }
});
</script>
