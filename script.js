function toggleMenu() {
    document.getElementById("sideMenu").classList.toggle("show");
}

function toggleProfile() {
    document.getElementById("profileMenu").classList.toggle("show");
}

window.onclick = function(event) {
    if (!event.target.matches('.profile-btn')) {
        var dropdown = document.getElementById("profileMenu");
        if (dropdown && dropdown.classList.contains("show")) {
            dropdown.classList.remove("show");
        }
    }
};