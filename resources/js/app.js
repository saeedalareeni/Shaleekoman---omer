import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// ================================================
// Dropdown و Tabs
// ================================================
document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM loaded, initializing dropdown and tabs...");

    // Dropdown
    const dropdownBtn = document.querySelector(".dropdown-btn");
    const dropdownMenu = document.querySelector(".dropdown-menu");

    if(dropdownBtn && dropdownMenu){
        dropdownBtn.addEventListener("click", () => {
            dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
        });
    }

    // Tabs
    const tabs = document.querySelectorAll(".tab");
    const contents = document.querySelectorAll(".tab-content");

    tabs.forEach((tab, idx) => {
        tab.addEventListener("click", () => {
            tabs.forEach(t => t.classList.remove("active"));
            contents.forEach(c => c.style.display = "none");

            tab.classList.add("active");
            contents[idx].style.display = "block";
        });
    });
});
