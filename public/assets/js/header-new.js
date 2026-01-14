// HEADER MENU TOGGLE FUNCTIONALITY
(function() {
  const menuToggle = document.getElementById('menuToggle');
  const mobileMenu = document.getElementById('mobileMenu');

  if (menuToggle && mobileMenu) {
    if (menuToggle.dataset.listenerAttached !== 'true') {
      menuToggle.dataset.listenerAttached = 'true';

      const closeMenu = () => {
        menuToggle.classList.remove('active');
        mobileMenu.classList.remove('active');
        menuToggle.setAttribute('aria-expanded', 'false');
        mobileMenu.setAttribute('aria-hidden', 'true');
        
        // Close any open dropdowns
        mobileMenu.querySelectorAll('.menu-dropdown.active').forEach((dropdown) => {
          dropdown.classList.remove('active');
          const toggle = dropdown.querySelector('.menu-dropdown-toggle');
          if (toggle) toggle.setAttribute('aria-expanded', 'false');
        });
      };

      menuToggle.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        const isActive = menuToggle.classList.toggle('active');
        mobileMenu.classList.toggle('active', isActive);
        menuToggle.setAttribute('aria-expanded', isActive ? 'true' : 'false');
        mobileMenu.setAttribute('aria-hidden', isActive ? 'false' : 'true');
        
        // Reset dropdowns when closing menu
        if (!isActive) {
          mobileMenu.querySelectorAll('.menu-dropdown.active').forEach((dropdown) => {
            dropdown.classList.remove('active');
            const toggle = dropdown.querySelector('.menu-dropdown-toggle');
            if (toggle) toggle.setAttribute('aria-expanded', 'false');
          });
        }
      });

      // Dropdown menu toggle
      const dropdownToggles = mobileMenu.querySelectorAll('.menu-dropdown-toggle');
      dropdownToggles.forEach((toggle) => {
        if (toggle.dataset.listenerAttached === 'true') return;
        toggle.dataset.listenerAttached = 'true';
        
        toggle.addEventListener('click', (event) => {
          event.preventDefault();
          event.stopPropagation();
          const dropdown = toggle.closest('.menu-dropdown');
          const isActive = dropdown.classList.toggle('active');
          toggle.setAttribute('aria-expanded', isActive ? 'true' : 'false');
        });
      });

      mobileMenu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
          closeMenu();
        });
      });

      mobileMenu.addEventListener('click', (event) => {
        event.stopPropagation();
      });

      document.addEventListener('click', (event) => {
        if (!menuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
          closeMenu();
        }
      });

      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
          closeMenu();
        }
      });
    }
  }
})();
