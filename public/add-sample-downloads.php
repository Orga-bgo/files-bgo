<?php
/**
 * Add Sample Downloads Script
 * This script adds sample downloads to test the category system
 * DELETE THIS FILE AFTER USE!
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/init.php';

// SECURITY: Uncomment these lines in production
// initSession();
// requireAdmin();

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Sample Downloads - BabixGO Files</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #1a1a1a;
            color: #e0e0e0;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            color: #A0D8FA;
            border-bottom: 2px solid #A0D8FA;
            padding-bottom: 10px;
        }
        .success {
            background: #1b5e20;
            padding: 15px;
            border-left: 4px solid #4caf50;
            margin: 10px 0;
        }
        .error {
            background: #b71c1c;
            padding: 15px;
            border-left: 4px solid #f44336;
            margin: 10px 0;
        }
        .warning {
            background: #e65100;
            padding: 15px;
            border-left: 4px solid #ff9800;
            margin: 10px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #A0D8FA;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            margin: 10px 5px;
        }
        .btn:hover {
            background: #81C7F5;
        }
        .btn-danger {
            background: #f44336;
            color: white;
        }
        .btn-danger:hover {
            background: #d32f2f;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            padding: 8px 0;
        }
        li:before {
            content: "✓ ";
            color: #4caf50;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>➕ Add Sample Downloads</h1>
        <p><strong>WARNING:</strong> This script adds test data to your database. Delete this file after use!</p>

        <?php
        $action = $_GET['action'] ?? '';
        
        if ($action === 'add') {
            try {
                $db = getDB();
                
                // First, check if categories exist
                $categories = fetchAll("SELECT id, name, slug FROM categories ORDER BY sort_order ASC");
                
                if (empty($categories)) {
                    echo '<div class="error">❌ No categories found! Please run install.php first.</div>';
                    echo '<p><a href="/install.php" class="btn">Run Installation</a></p>';
                } else {
                    echo '<div class="success">✅ Found ' . count($categories) . ' categories</div>';
                    
                    // Sample downloads data
                    $sampleDownloads = [
                        [
                            'name' => 'BabixGO Utility Script v1.0',
                            'description' => 'Ein nützliches Script für Entwickler und Power-User. Enthält verschiedene Automatisierungs-Tools und Hilfsfunktionen.',
                            'file_size' => '5.2 MB',
                            'file_type' => 'ZIP',
                            'download_link' => 'https://files.babixgo.de/downloads/sample-script.zip',
                            'alternative_link' => '',
                            'category_slug' => 'scripts',
                            'download_count' => 42
                        ],
                        [
                            'name' => 'BabixGO Development Tools',
                            'description' => 'Sammlung von Entwickler-Tools speziell für BabixGO-Projekte. Beinhaltet Code-Templates, Snippets und Konfigurationsdateien.',
                            'file_size' => '12.8 MB',
                            'file_type' => 'ZIP',
                            'download_link' => 'https://files.babixgo.de/downloads/dev-tools.zip',
                            'alternative_link' => 'https://github.com/babixgo/dev-tools/archive/main.zip',
                            'category_slug' => 'scripts',
                            'download_count' => 28
                        ],
                        [
                            'name' => 'Freundschaftsbalken Android v2.5.0',
                            'description' => 'Die beliebte Freundschaftsbalken-App für Android-Geräte. Zeige deinen Freunden, wie viel sie dir bedeuten! Unterstützt Android 8.0 und höher.',
                            'file_size' => '18.4 MB',
                            'file_type' => 'APK',
                            'download_link' => 'https://files.babixgo.de/downloads/freundschaftsbalken-android.apk',
                            'alternative_link' => '',
                            'category_slug' => 'freundschaftsbalken-android',
                            'download_count' => 156
                        ],
                        [
                            'name' => 'Freundschaftsbalken Android Beta v3.0.0',
                            'description' => 'BETA VERSION! Die neueste Version mit Material You Design und neuen Features. Kann Bugs enthalten. Bitte Feedback geben!',
                            'file_size' => '22.1 MB',
                            'file_type' => 'APK',
                            'download_link' => 'https://files.babixgo.de/downloads/freundschaftsbalken-android-beta.apk',
                            'alternative_link' => '',
                            'category_slug' => 'freundschaftsbalken-android',
                            'download_count' => 73
                        ],
                        [
                            'name' => 'Freundschaftsbalken Windows v2.0.1',
                            'description' => 'Die Windows-Version der Freundschaftsbalken-App. Optimiert für Windows 10 und 11. Zeigt Benachrichtigungen direkt auf deinem Desktop.',
                            'file_size' => '35.7 MB',
                            'file_type' => 'EXE',
                            'download_link' => 'https://files.babixgo.de/downloads/freundschaftsbalken-windows.exe',
                            'alternative_link' => '',
                            'category_slug' => 'freundschaftsbalken-windows',
                            'download_count' => 89
                        ],
                        [
                            'name' => 'Freundschaftsbalken Windows Portable',
                            'description' => 'Portable Version für Windows - keine Installation erforderlich! Perfekt für USB-Sticks oder wenn du keine Admin-Rechte hast.',
                            'file_size' => '32.3 MB',
                            'file_type' => 'ZIP',
                            'download_link' => 'https://files.babixgo.de/downloads/freundschaftsbalken-windows-portable.zip',
                            'alternative_link' => '',
                            'category_slug' => 'freundschaftsbalken-windows',
                            'download_count' => 45
                        ]
                    ];
                    
                    // Build category slug to ID map
                    $categoryMap = [];
                    foreach ($categories as $cat) {
                        $categoryMap[$cat['slug']] = $cat['id'];
                    }
                    
                    $inserted = 0;
                    $skipped = 0;
                    
                    echo '<h2>Adding Sample Downloads...</h2>';
                    
                    foreach ($sampleDownloads as $download) {
                        $categoryId = $categoryMap[$download['category_slug']] ?? null;
                        
                        if (!$categoryId) {
                            echo '<div class="warning">⚠️ Skipped: ' . e($download['name']) . ' (category not found: ' . e($download['category_slug']) . ')</div>';
                            $skipped++;
                            continue;
                        }
                        
                        // Check if download already exists
                        $existing = fetchOne(
                            "SELECT id FROM downloads WHERE name = ?",
                            's',
                            [$download['name']]
                        );
                        
                        if ($existing) {
                            echo '<div class="warning">⚠️ Skipped: ' . e($download['name']) . ' (already exists)</div>';
                            $skipped++;
                            continue;
                        }
                        
                        // Insert download
                        $result = insertRow(
                            "INSERT INTO downloads (name, description, file_size, file_type, download_link, alternative_link, category_id, download_count, created_at) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())",
                            'ssssssii',
                            [
                                $download['name'],
                                $download['description'],
                                $download['file_size'],
                                $download['file_type'],
                                $download['download_link'],
                                $download['alternative_link'],
                                $categoryId,
                                $download['download_count']
                            ]
                        );
                        
                        if ($result) {
                            echo '<div class="success">✅ Added: ' . e($download['name']) . '</div>';
                            $inserted++;
                        } else {
                            echo '<div class="error">❌ Failed: ' . e($download['name']) . '</div>';
                        }
                    }
                    
                    echo '<hr style="margin: 30px 0; border-color: #404040;">';
                    echo '<div class="success">';
                    echo '<h3>Summary:</h3>';
                    echo '<ul>';
                    echo '<li>Downloads inserted: ' . $inserted . '</li>';
                    echo '<li>Downloads skipped: ' . $skipped . '</li>';
                    echo '<li>Total downloads in sample set: ' . count($sampleDownloads) . '</li>';
                    echo '</ul>';
                    echo '</div>';
                    
                    if ($inserted > 0) {
                        echo '<p><strong>✅ Success!</strong> Sample downloads have been added to the database.</p>';
                        echo '<p><a href="/index.php" class="btn">View Homepage</a></p>';
                        echo '<p><a href="/db-diagnostic.php" class="btn">Run Diagnostics</a></p>';
                    }
                }
                
            } catch (Exception $e) {
                echo '<div class="error">❌ Error: ' . e($e->getMessage()) . '</div>';
            }
            
        } else {
            // Show confirmation form
            echo '<div class="warning">';
            echo '<h2>⚠️ Warning</h2>';
            echo '<p>This will add 6 sample downloads to your database for testing purposes:</p>';
            echo '<ul>';
            echo '<li>2 downloads in "Scripts" category</li>';
            echo '<li>2 downloads in "Freundschaftsbalken - Android" category</li>';
            echo '<li>2 downloads in "Freundschaftsbalken - Windows" category</li>';
            echo '</ul>';
            echo '<p><strong>Note:</strong> Existing downloads with the same names will be skipped.</p>';
            echo '</div>';
            
            echo '<p>';
            echo '<a href="?action=add" class="btn">➕ Add Sample Downloads</a>';
            echo '<a href="/db-diagnostic.php" class="btn">🔍 Run Diagnostics First</a>';
            echo '<a href="/index.php" class="btn">❌ Cancel</a>';
            echo '</p>';
            
            echo '<div class="warning">';
            echo '<h3>🗑️ Remove Sample Data Later</h3>';
            echo '<p>To remove the sample downloads after testing:</p>';
            echo '<ol>';
            echo '<li>Login as admin</li>';
            echo '<li>Go to Admin Panel → Manage Downloads</li>';
            echo '<li>Delete the sample downloads one by one</li>';
            echo '</ol>';
            echo '<p>Or use SQL:</p>';
            echo '<pre>DELETE FROM downloads WHERE name LIKE \'%BabixGO%\' OR name LIKE \'%Freundschaftsbalken%\';</pre>';
            echo '</div>';
        }
        ?>

        <hr style="margin: 40px 0; border-color: #404040;">
        <div class="error" style="text-align: center;">
            <p><strong>🔒 SECURITY REMINDER:</strong></p>
            <p>Delete this file (add-sample-downloads.php) after adding sample data!</p>
            <p><small>This script should not be accessible in production.</small></p>
        </div>
    </div>
</body>
</html>
