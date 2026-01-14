<?php
/**
 * Site Header with Navigation
 * Matches babixgo.de design and navigation
 */
?>

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
    
    <!-- Authentication Links -->
    <?php if (!isLoggedIn()): ?>
      <a href="/login.php">🔐 Anmelden</a>
      <a href="/register.php">✨ Registrieren</a>
    <?php else: ?>
      <a href="/profile.php">👤 Profil</a>
      <a href="/logout.php">🚪 Abmelden</a>
    <?php endif; ?>
    
    <!-- Admin Menu with Categories Dropdown -->
    <?php if (isLoggedIn() && isAdmin()): ?>
    <div class="menu-section-divider">
      <div class="menu-dropdown">
        <button class="menu-dropdown-toggle" aria-expanded="false" type="button">
          ⚙️ Admin Menü
          <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        <div class="menu-dropdown-content">
          <a href="/admin/dashboard.php">📊 Dashboard</a>
          <a href="/admin/upload.php">📤 Upload</a>
          <a href="/admin/manage-downloads.php">📥 Downloads verwalten</a>
          <a href="/admin/manage-users.php">👥 Benutzer verwalten</a>
          <a href="/admin/moderate-comments.php">💬 Kommentare moderieren</a>
          
          <!-- Categories submenu -->
          <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--stroke);">
            <div style="font-size: 13px; color: var(--muted); padding: 8px 16px; font-weight: 600;">Kategorien</div>
            <?php 
            $categories = getCategories();
            foreach($categories as $category): 
            ?>
              <a href="/kategorie/<?= e($category['slug']) ?>"><?= e($category['name']) ?></a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    
  </div>
</nav>
