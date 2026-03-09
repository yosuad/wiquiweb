// START PRELOADER
var animation = lottie.loadAnimation({
    container: document.getElementById('preloader__animation'),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: 'img/loader.json',
});

// Hide preloader immediately after page load
window.onload = function() {
    var preloader = document.getElementById('preloader');
    preloader.style.display = 'none';
};

// Hide preloader with a delay after page load
window.onload = function() {
    var preloader = document.getElementById('preloader');
    setTimeout(() => {
        preloader.style.display = 'none';
    }, 600); // wait 600ms after the page has loaded
};
// END PRELOADER


// START MENU MOBILE
document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.querySelector(".navbar__toggle");
    const mobileMenu = document.querySelector(".navbar__mobile");

    if (toggle && mobileMenu) {
        toggle.addEventListener("click", function () {
            toggle.classList.toggle("is-active"); // switch hamburger ↔ X
            mobileMenu.classList.toggle("is-active"); // open/close mobile menu
        });
    }
});
// END MENU MOBILE
