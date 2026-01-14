<?php
/**
 * BabixGO Files - Impressum Page
 */

require_once __DIR__ . '/init.php';

initSession();

$pageTitle = 'Impressum';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Impressum - BabixGO Files">
    <meta name="theme-color" content="#A0D8FA">
    
    <title><?php echo e($pageTitle); ?> - <?php echo e(SITE_NAME); ?></title>
    
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/assets/icons/icon-192.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/header-new.css">
    <link rel="stylesheet" href="/assets/css/cookie-banner.css">
    <?php
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (strpos($host, 'files.babixgo.de') !== false): ?>
    <link rel="stylesheet" href="/assets/css/files-bgo.css">
    <?php endif; ?>
    
    <!-- Google Analytics Tracking Configuration -->
    <?php include INCLUDES_PATH . 'tracking.php'; ?>
</head>
<body>
    <?php include INCLUDES_PATH . 'header.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="content-card">
                <h1>Impressum</h1>
                
                <p>Für weitere Informationen besuchen Sie bitte das Hauptimpressum unter:</p>
                <p><a href="https://babixgo.de/impressum/" target="_blank" rel="noopener">https://babixgo.de/impressum/</a></p>
                
                <h2>Kontakt</h2>
                <p>Für Fragen zum Download-Portal wenden Sie sich bitte an:</p>
                <p><a href="https://babixgo.de/kontakt/" target="_blank" rel="noopener">https://babixgo.de/kontakt/</a></p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-links">
                <a href="https://babixgo.de">BabixGO</a>
                <a href="/impressum.php">Impressum</a>
                <a href="/datenschutz.php">Datenschutz</a>
            </div>
            <p>&copy; <?php echo date('Y'); ?> <?php echo e(SITE_NAME); ?>. Alle Rechte vorbehalten.</p>
        </div>
    </footer>

    <!-- Cookie Consent Banner -->
    <?php include INCLUDES_PATH . 'cookie-banner.php'; ?>

    <!-- Scripts -->
    <script src="/assets/js/header-new.js"></script>
    <script src="/assets/js/app.js"></script>
    <script src="/assets/js/cookie-consent.js"></script>
</body>
</html>
