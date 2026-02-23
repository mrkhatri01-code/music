

// Initialize dataLayer properly
window.dataLayer = window.dataLayer || [];
window.gtag = function () { window.dataLayer.push(arguments); };
window.gtag('js', new Date());
window.gtag('config', 'G-KGESSQCKEQ');


// Main navigation toggle logic
window.toggleMoreMenu = function () {
    const menu = document.getElementById('moreMenu');
    if (menu) menu.classList.toggle('show');
}

window.toggleFooter = function () {
    const footer = document.querySelector('footer');
    if (footer) {
        // Toggle visibility class
        footer.classList.toggle('active-mobile');

        // If visible, scroll to it
        if (footer.classList.contains('active-mobile')) {
            setTimeout(() => {
                footer.scrollIntoView({ behavior: 'smooth' });
            }, 100);
        }
    }
    // Close more menu
    const menu = document.getElementById('moreMenu');
    if (menu) menu.classList.remove('show');
}

window.toggleSearch = function () {
    const overlay = document.getElementById('searchOverlay');
    const input = document.getElementById('mobileSearchInput');
    if (overlay) {
        overlay.classList.toggle('active');
        if (overlay.classList.contains('active') && input) {
            setTimeout(() => input.focus(), 100);
        }
    }
}

// Close menu when clicking outside
document.addEventListener('click', function (e) {
    const toggle = document.getElementById('moreNavToggle');
    const menu = document.getElementById('moreMenu');
    if (menu && toggle && !toggle.contains(e.target) && menu.classList.contains('show')) {
        menu.classList.remove('show');
    }
});

// Popup Ad Logic
document.addEventListener('DOMContentLoaded', function () {
    if (!sessionStorage.getItem('popupAdShown')) {
        setTimeout(function () {
            const popup = document.getElementById('globalPopupAd');
            if (popup) {
                popup.style.display = 'flex';
            }
        }, 2000);
    }
});

window.closePopupAd = function () {
    const popup = document.getElementById('globalPopupAd');
    if (popup) {
        popup.style.display = 'none';
        sessionStorage.setItem('popupAdShown', 'true');
    }
}
