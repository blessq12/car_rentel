/**
 * CarRental JavaScript
 */

import "./bootstrap";

// Alpine.js
import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

// Мобильное меню
document.addEventListener("DOMContentLoaded", function () {
    // Инициализация мобильного меню
    const mobileMenuButton = document.querySelector("[data-mobile-menu]");
    const mobileMenu = document.querySelector("[data-mobile-menu-panel]");

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener("click", function () {
            mobileMenu.classList.toggle("hidden");
        });
    }

    // Закрытие мобильного меню при клике вне его
    document.addEventListener("click", function (event) {
        if (
            !mobileMenu?.contains(event.target) &&
            !mobileMenuButton?.contains(event.target)
        ) {
            mobileMenu?.classList.add("hidden");
        }
    });
});

// Уведомления
window.showNotification = function (message, type = "success") {
    const notification = document.createElement("div");
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${
        type === "success" ? "bg-green-500 text-white" : "bg-red-500 text-white"
    }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
};
