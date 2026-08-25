/* Shaleek Design System — shared interactions for the redesigned screens */

function shaleekToggleMenu() {
    var menu = document.getElementById('shaleekMobileMenu');
    if (menu) menu.classList.toggle('open');
}

function shaleekToggleTheme() {
    var isDark = document.documentElement.classList.toggle('shaleek-dark');
    try { localStorage.setItem('shaleek-theme', isDark ? 'dark' : 'light'); } catch (e) {}
}

function shaleekToggleWishlist(btn, url) {
    if (!window.shaleekLoggedIn) {
        window.location.href = window.shaleekLoginUrl || '/';
        return;
    }
    var csrfMeta = document.querySelector('meta[name="csrf-token"]');
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfMeta ? csrfMeta.content : '',
            'Accept': 'application/json'
        }
    })
    .then(function (r) { return r.json(); })
    .then(function (data) { btn.classList.toggle('active', data.status === 'added'); })
    .catch(function () {});
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
