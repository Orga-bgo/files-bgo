<?php
/**
 * Site Header with Navigation
 * Matches babixgo.de design and navigation
 */
?>

<header class="site-header">
  <div class="header-brand">
    <a href="/" class="header-logo">
      <span class="logo-babix">babix</span><span class="logo-go">GO</span>
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
    <a href="https://babixgo.de/">Home</a>
    <div class="menu-dropdown">
      <button class="menu-dropdown-toggle" aria-expanded="false" type="button">
        Angebote
        <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M2.5 4.5L6 8L9.5 4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
      <div class="menu-dropdown-content">
        <a href="https://babixgo.de/wuerfel/">Würfel</a>
        <a href="https://babixgo.de/partnerevents/">Partnerevents</a>
        <a href="https://babixgo.de/accounts/">Accounts</a>
        <a href="https://babixgo.de/tycoon-racers/">Tycoon Racers</a>
        <a href="https://babixgo.de/anleitungen/freundschaftsbalken-fuellen/">Freundschaftsbalken</a>
        <a href="https://babixgo.de/sticker/">Sticker</a>
      </div>
    </div>
    <a href="https://babixgo.de/anleitungen/">Anleitungen</a>
    <a href="/">Downloads</a>
    <a href="https://babixgo.de/kontakt/">Kontakt</a>
  </div>
</nav>
