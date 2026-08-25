// تطبيق خط Tajwal على جميع العناصر
document.addEventListener('DOMContentLoaded', function() {
    // تطبيق الخط على جميع العناصر
    const allElements = document.querySelectorAll('*');
    allElements.forEach(element => {
        element.style.fontFamily = "'Tajwal', sans-serif";
    });
    
    // Initialize filter handlers immediately
    initSimpleFilterHandlers();
});

// معالج الفلاتر البسيطة
function initSimpleFilterHandlers() {
    console.log('Initializing simple filter handlers...');
    
    const filterPills = document.querySelectorAll('.filter-pill');
    const searchBtn = document.querySelector('.search-btn');
    
    if (filterPills.length > 0) {
        console.log('Found', filterPills.length, 'filter pills');
        
        // إضافة معالج لكل زر فلتر
        filterPills.forEach((pill, index) => {
            pill.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Filter clicked:', this.textContent.trim());
                
                // يمكنك إضافة منطق الفلتر هنا
                // مثلاً: فتح نافذة modal أو تحديث الصفحة
                
                // إضافة/إزالة active class للتأثير البصري
                this.classList.toggle('active');
            });
        });
    }
    
    // معالج زر البحث
    if (searchBtn) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Search button clicked');
            // إضافة منطق البحث هنا
        });
    }
    
    console.log('Simple filter handlers initialized successfully!');
}
