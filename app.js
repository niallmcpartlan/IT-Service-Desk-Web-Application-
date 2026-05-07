// Select the mobile menu icon (hamburger icon)
const menu = document.querySelector('#mobile-menu');

// Select the navigation menu links container
const menuLinks = document.querySelector('.navbar__menu');

// Add a click event to toggle the mobile menu open/closed
menu.addEventListener('click', function() {

  // Toggle the "is-active" class on the menu icon (for animation)
  menu.classList.toggle('is-active');

  // Toggle the "active" class on the menu links (shows or hides the menu)
  menuLinks.classList.toggle('active');
});