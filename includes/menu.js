const toggle = document.querySelector('.menu-toggle');
const menu = document.querySelector('.menu');

if (toggle) {
    toggle.addEventListener('click', () => {
        menu.classList.toggle('active');
    });
}