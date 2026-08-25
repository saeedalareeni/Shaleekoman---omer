/* Shaleek Design System — shared interactions for the redesigned screens */

function shaleekToggleMenu() {
    var menu = document.getElementById('shaleekMobileMenu');
    if (menu) menu.classList.toggle('open');
}

function shaleekToggleTheme() {
    var isDark = document.documentElement.classList.toggle('shaleek-dark');
    try { localStorage.setItem('shaleek-theme', isDark ? 'dark' : 'light'); } catch (e) {}
}

function shaleekOpenFilters() {
    var sheet = document.getElementById('shaleekFilterSheet');
    if (sheet) sheet.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function shaleekCloseFilters() {
    var sheet = document.getElementById('shaleekFilterSheet');
    if (sheet) sheet.classList.remove('open');
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', function () {
    // Filter chip toggles (visual only — form fields drive the real filtering)
    document.querySelectorAll('.js-shaleek-filter-toggle').forEach(function (opt) {
        opt.addEventListener('click', function () {
            this.classList.toggle('active');
        });
    });
});
