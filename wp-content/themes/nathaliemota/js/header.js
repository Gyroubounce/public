document.addEventListener('DOMContentLoaded', () => {
  const burgerMenu = document.querySelector('.burger-menu');
  const mobileMenu = document.querySelector('.menu-header-container'); // Changez ici

  if (burgerMenu && mobileMenu) {
    // Affichage initial du menu burger et du menu mobile
    console.log('Burger Menu:', burgerMenu);
    console.log('Mobile Menu:', mobileMenu);

    burgerMenu.addEventListener('click', () => {
      // Toggle burger menu active state
      burgerMenu.classList.toggle('active');
      console.log('Burger Menu Active:', burgerMenu.classList.contains('active'));

      // Toggle mobile menu visibility
      mobileMenu.classList.toggle('active');
      console.log('Mobile Menu Active:', mobileMenu.classList.contains('active'));

      // Toggle the background color (red)
      mobileMenu.classList.toggle('menu-open');
      console.log('Mobile Menu Background Red:', mobileMenu.classList.contains('menu-open'));
    });

    mobileMenu.addEventListener('click', (e) => {
      if (e.target.tagName === 'A') {
        // Close menu when clicking on a link
        burgerMenu.classList.remove('active');
        mobileMenu.classList.remove('active');
        mobileMenu.classList.remove('menu-open');
        console.log('Menu Closed');
      }
    });
  } else {
    console.log('Burger Menu or Mobile Menu not found!');
  }
});
