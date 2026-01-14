<?php
/**
 * New Site Header with Navigation
 * Matches the requested design with clean HTML structure
 */
?>

<!-- ========== HEADER ========== -->
<header class="site-header">
  <div class="header-brand">
    <a href="/" class="header-logo">
      <span class="logo-files">files.</span><span class="logo-babix">babix</span><span class="logo-go">GO</span>
    </a>
    <div class="header-tagline">Downloadportal</div>
  </div>
  
  <button class="menu-toggle" aria-label="Menü öffnen" aria-controls="mobileMenu" aria-expanded="false" id="menuToggle" type="button">
    <span></span>
    <span></span>
    <span></span>
  </button>
</header>

<!-- ========== MOBILE MENU ========== -->
<nav class="mobile-menu" id="mobileMenu" aria-hidden="true">
  <div class="mobile-menu-inner">
    <a href="/">Startseite</a>
    <a href="https://babixgo.de" target="_blank" rel="noopener">Zu babixGO.de</a>
    
    <!-- DROPDOWN: KATEGORIEN -->
    <div class="menu-dropdown">
      <button class="menu-dropdown-toggle" aria-expanded="false" type="button">
        Kategorien
        <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
      <div class="menu-dropdown-content">
        <?php 
        // Get categories from database
        $categories = getCategories();
        foreach($categories as $category): 
        ?>
          <a href="/kategorie/<?= e($category['slug']) ?>"><?= e($category['name']) ?></a>
        <?php endforeach; ?>
      </div>
    </div>
    
    <!-- AUTH SECTION -->
    <div class="menu-auth">
      <?php if (!isLoggedIn()): ?>
        <a href="/login.php" class="auth-button auth-button--login">Anmelden</a>
        <a href="/register.php" class="auth-button auth-button--register">Registrieren</a>
      <?php else: ?>
        <a href="/profile.php" class="auth-button auth-button--login">Profil</a>
        <a href="/logout.php" class="auth-button auth-button--register">Abmelden</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
