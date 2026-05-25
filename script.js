document.addEventListener("DOMContentLoaded", function () {

    const sideMenu = document.getElementById("sideMenu");
    const profileMenu = document.getElementById("profileMenu");
    const menuBtn = document.querySelector(".menu-btn");
    const profileBtn = document.querySelector(".profile-btn");

    window.toggleMenu = function () {
        if (sideMenu) {
            sideMenu.classList.toggle("show");
        }

        if (profileMenu) {
            profileMenu.classList.remove("show");
        }
    };

    window.toggleProfile = function () {
        if (profileMenu) {
            profileMenu.classList.toggle("show");
        }

        if (sideMenu) {
            sideMenu.classList.remove("show");
        }
    };

    document.addEventListener("click", function (event) {

        if (
            sideMenu &&
            menuBtn &&
            !sideMenu.contains(event.target) &&
            !menuBtn.contains(event.target)
        ) {
            sideMenu.classList.remove("show");
        }

        if (
            profileMenu &&
            profileBtn &&
            !profileMenu.contains(event.target) &&
            !profileBtn.contains(event.target)
        ) {
            profileMenu.classList.remove("show");
        }

    });

});