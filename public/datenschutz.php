<?php
/**
 * BabixGO Files - Datenschutz Page
 */

require_once __DIR__ . '/init.php';

initSession();

$pageTitle = 'Datenschutz';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Datenschutz - BabixGO Files">
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
    <link rel="stylesheet" href="/assets/css/header-simple.css">
    <link rel="stylesheet" href="/assets/css/cookie-banner.css">
    <?php
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (strpos($host, 'files.babixgo.de') !== false): ?>
    <link rel="stylesheet" href="/assets/css/files-bgo.css">
    <?php endif; ?>
    
    <!-- Google Analytics Tracking Configuration -->
    <?php include __DIR__ . '/includes/tracking.php'; ?>
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="content-card">
                <h1>Datenschutzerklärung</h1>
                
                <p>Für die vollständige Datenschutzerklärung besuchen Sie bitte:</p>
                <p><a href="https://babixgo.de/datenschutz/" target="_blank" rel="noopener">https://babixgo.de/datenschutz/</a></p>
                
                <h2>Zusätzliche Informationen für das Download-Portal</h2>
                <p>Dieses Download-Portal ist Teil von BabixGO und unterliegt den gleichen Datenschutzbestimmungen.</p>
                
                <h3>Gespeicherte Daten</h3>
                <ul>
                    <li>Benutzername und E-Mail-Adresse (bei Registrierung)</li>
                    <li>Download-Statistiken (anonymisiert)</li>
                    <li>Kommentare und Bewertungen (mit Benutzernamen verknüpft)</li>
                </ul>
                
                <h3>Cookies</h3>
                <p>Wir verwenden notwendige Cookies für die Funktionalität der Website und optionale Cookies für Analyse-Zwecke (nur mit Ihrer Zustimmung).</p>
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
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>

    <!-- Scripts -->
    <script src="/assets/js/header.js"></script>
    <script src="/assets/js/app.js"></script>
    <script src="/assets/js/cookie-consent.js"></script>
</body>
</html>
