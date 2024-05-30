document.addEventListener('DOMContentLoaded', function () {
    const navMenu = document.getElementById('navMenu');
    const navIcon = document.getElementById('navIcon');

    navIcon.addEventListener('click', function () {
        navMenu.classList.toggle('active');
    });
});