<?php
/**
 * Database Diagnostic Script
 * This script checks database connection, tables, and data
 * DELETE THIS FILE AFTER DEBUGGING!
 */

// Enable error reporting for diagnostics
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/init.php';

// Prevent unauthorized access in production
// Uncomment these lines once DB is configured:
// initSession();
// requireAdmin();

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Diagnostic - BabixGO Files</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #1a1a1a;
            color: #e0e0e0;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            color: #A0D8FA;
            border-bottom: 2px solid #A0D8FA;
            padding-bottom: 10px;
        }
        h2 {
            color: #81C7F5;
            margin-top: 30px;
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
        .info {
            background: #01579b;
            padding: 15px;
            border-left: 4px solid #2196f3;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background: #2a2a2a;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #404040;
        }
        th {
            background: #333;
            color: #A0D8FA;
            font-weight: 600;
        }
        tr:hover {
            background: #333;
        }
        pre {
            background: #2a2a2a;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 0.85em;
            font-weight: 600;
        }
        .badge-success { background: #4caf50; color: white; }
        .badge-error { background: #f44336; color: white; }
        .badge-warning { background: #ff9800; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 BabixGO Files - Database Diagnostic</h1>
        <p><strong>WARNING:</strong> Delete this file after diagnostics are complete!</p>

        <?php
        // Step 1: Check Database Connection
        echo "<h2>1️⃣ Database Connection Test</h2>";
        
        try {
            $db = getDB();
            echo '<div class="success">✅ Database connection successful!</div>';
            echo '<div class="info">';
            echo '<strong>Connection Info:</strong><br>';
            echo 'Host: ' . e(DB_HOST) . '<br>';
            echo 'Database: ' . e(DB_NAME) . '<br>';
            echo 'User: ' . e(DB_USER) . '<br>';
            echo 'Charset: ' . e(DB_CHARSET) . '<br>';
            echo '</div>';
        } catch (Exception $e) {
            echo '<div class="error">❌ Database connection failed!<br>';
            echo 'Error: ' . e($e->getMessage()) . '</div>';
            echo '</div></body></html>';
            exit;
        }

        // Step 2: List all tables
        echo "<h2>2️⃣ Database Tables</h2>";
        
        $tables = fetchAll("SHOW TABLES");
        if (empty($tables)) {
            echo '<div class="error">❌ No tables found in database!</div>';
        } else {
            echo '<div class="success">✅ Found ' . count($tables) . ' table(s)</div>';
            echo '<table>';
            echo '<tr><th>#</th><th>Table Name</th><th>Rows</th></tr>';
            
            $tableKey = 'Tables_in_' . DB_NAME;
            foreach ($tables as $i => $table) {
                $tableName = $table[$tableKey];
                
                // Validate table name (only alphanumeric, underscore, and hyphen allowed)
                if (!preg_match('/^[a-zA-Z0-9_-]+$/', $tableName)) {
                    echo '<tr>';
                    echo '<td>' . ($i + 1) . '</td>';
                    echo '<td><strong>' . e($tableName) . '</strong></td>';
                    echo '<td><span class="badge badge-error">Invalid table name</span></td>';
                    echo '</tr>';
                    continue;
                }
                
                $countResult = fetchOne("SELECT COUNT(*) as count FROM `{$tableName}`");
                $rowCount = $countResult['count'] ?? 0;
                
                echo '<tr>';
                echo '<td>' . ($i + 1) . '</td>';
                echo '<td><strong>' . e($tableName) . '</strong></td>';
                echo '<td>' . $rowCount . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }

        // Step 3: Check Categories Table
        echo "<h2>3️⃣ Categories Table</h2>";
        
        $categoriesExist = fetchOne("SHOW TABLES LIKE 'categories'");
        if (!$categoriesExist) {
            echo '<div class="error">❌ Categories table does not exist!<br>';
            echo 'Run install.php to create the categories table.</div>';
        } else {
            echo '<div class="success">✅ Categories table exists</div>';
            
            // Show table structure
            echo '<h3>Table Structure:</h3>';
            $columns = fetchAll("DESCRIBE categories");
            echo '<table>';
            echo '<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>';
            foreach ($columns as $col) {
                echo '<tr>';
                echo '<td>' . e($col['Field']) . '</td>';
                echo '<td>' . e($col['Type']) . '</td>';
                echo '<td>' . e($col['Null']) . '</td>';
                echo '<td>' . e($col['Key']) . '</td>';
                echo '<td>' . e($col['Default'] ?? 'NULL') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            
            // Show data
            echo '<h3>Categories Data:</h3>';
            $categories = fetchAll("SELECT * FROM categories ORDER BY sort_order ASC");
            
            if (empty($categories)) {
                echo '<div class="warning">⚠️ No categories found in database!<br>';
                echo 'Run install.php to add default categories.</div>';
            } else {
                echo '<div class="success">✅ Found ' . count($categories) . ' categorie(s)</div>';
                echo '<table>';
                echo '<tr><th>ID</th><th>Name</th><th>Slug</th><th>Description</th><th>Sort Order</th></tr>';
                foreach ($categories as $cat) {
                    echo '<tr>';
                    echo '<td>' . e($cat['id']) . '</td>';
                    echo '<td><strong>' . e($cat['name']) . '</strong></td>';
                    echo '<td>' . e($cat['slug']) . '</td>';
                    echo '<td>' . e($cat['description']) . '</td>';
                    echo '<td>' . e($cat['sort_order']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
        }

        // Step 4: Check Downloads Table
        echo "<h2>4️⃣ Downloads Table</h2>";
        
        $downloadsExist = fetchOne("SHOW TABLES LIKE 'downloads'");
        if (!$downloadsExist) {
            echo '<div class="error">❌ Downloads table does not exist!</div>';
        } else {
            echo '<div class="success">✅ Downloads table exists</div>';
            
            // Show table structure
            echo '<h3>Table Structure:</h3>';
            $columns = fetchAll("DESCRIBE downloads");
            echo '<table>';
            echo '<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>';
            foreach ($columns as $col) {
                echo '<tr>';
                echo '<td>' . e($col['Field']) . '</td>';
                echo '<td>' . e($col['Type']) . '</td>';
                echo '<td>' . e($col['Null']) . '</td>';
                echo '<td>' . e($col['Key']) . '</td>';
                echo '<td>' . e($col['Default'] ?? 'NULL') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            
            // Check if category_id column exists
            $hasCategoryId = false;
            foreach ($columns as $col) {
                if ($col['Field'] === 'category_id') {
                    $hasCategoryId = true;
                    break;
                }
            }
            
            if (!$hasCategoryId) {
                echo '<div class="error">❌ category_id column missing from downloads table!<br>';
                echo 'Run install.php to add the category_id column.</div>';
            } else {
                echo '<div class="success">✅ category_id column exists</div>';
            }
            
            // Show download counts
            echo '<h3>Downloads Summary:</h3>';
            $downloadCount = fetchOne("SELECT COUNT(*) as count FROM downloads");
            $totalCount = $downloadCount['count'] ?? 0;
            
            if ($totalCount === 0) {
                echo '<div class="warning">⚠️ No downloads found in database!<br>';
                echo 'This is why categories show "0 Downloads".</div>';
            } else {
                echo '<div class="success">✅ Found ' . $totalCount . ' download(s)</div>';
                
                // Show sample downloads
                echo '<h3>Sample Downloads (Latest 10):</h3>';
                $downloads = fetchAll("SELECT * FROM downloads ORDER BY created_at DESC LIMIT 10");
                echo '<table>';
                echo '<tr><th>ID</th><th>Name</th><th>Category ID</th><th>File Type</th><th>Download Count</th><th>Created</th></tr>';
                foreach ($downloads as $dl) {
                    echo '<tr>';
                    echo '<td>' . e($dl['id']) . '</td>';
                    echo '<td><strong>' . e($dl['name']) . '</strong></td>';
                    echo '<td>' . ($dl['category_id'] ? e($dl['category_id']) : '<span class="badge badge-warning">NULL</span>') . '</td>';
                    echo '<td>' . e($dl['file_type'] ?? 'N/A') . '</td>';
                    echo '<td>' . e($dl['download_count'] ?? 0) . '</td>';
                    echo '<td>' . e($dl['created_at']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
        }

        // Step 5: Test Category Download Count Query
        echo "<h2>5️⃣ Category Download Count Test</h2>";
        
        if ($categoriesExist && $downloadsExist) {
            echo '<p>Testing the query used on the homepage to count downloads per category:</p>';
            
            $sql = "SELECT c.*, 
                    COUNT(d.id) as download_count
                    FROM categories c
                    LEFT JOIN downloads d ON d.category_id = c.id
                    GROUP BY c.id
                    ORDER BY c.sort_order ASC";
            
            echo '<pre>' . e($sql) . '</pre>';
            
            try {
                $results = fetchAll($sql);
                
                echo '<div class="success">✅ Query executed successfully</div>';
                echo '<table>';
                echo '<tr><th>Category</th><th>Download Count</th><th>Status</th></tr>';
                foreach ($results as $cat) {
                    $count = $cat['download_count'];
                    $status = $count > 0 ? '<span class="badge badge-success">Has Downloads</span>' : '<span class="badge badge-warning">Empty</span>';
                    
                    echo '<tr>';
                    echo '<td><strong>' . e($cat['name']) . '</strong></td>';
                    echo '<td>' . $count . '</td>';
                    echo '<td>' . $status . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                
                // Check if all are zero
                $allZero = true;
                foreach ($results as $cat) {
                    if ($cat['download_count'] > 0) {
                        $allZero = false;
                        break;
                    }
                }
                
                if ($allZero) {
                    echo '<div class="warning">';
                    echo '⚠️ <strong>ROOT CAUSE FOUND:</strong> All categories show 0 downloads.<br><br>';
                    echo '<strong>Possible reasons:</strong><br>';
                    echo '1. The downloads table is empty (no downloads have been added)<br>';
                    echo '2. Downloads exist but have NULL category_id<br>';
                    echo '3. Downloads exist but belong to non-existent categories<br><br>';
                    echo '<strong>Next steps:</strong><br>';
                    echo '1. Add sample downloads via Admin Panel → Upload<br>';
                    echo '2. Or manually insert test data (see recommendations below)<br>';
                    echo '</div>';
                }
                
            } catch (Exception $e) {
                echo '<div class="error">❌ Query failed!<br>';
                echo 'Error: ' . e($e->getMessage()) . '</div>';
            }
        }

        // Step 6: Foreign Key Check
        echo "<h2>6️⃣ Foreign Key Relationships</h2>";
        
        if ($downloadsExist) {
            $fks = fetchAll("
                SELECT 
                    CONSTRAINT_NAME,
                    TABLE_NAME,
                    COLUMN_NAME,
                    REFERENCED_TABLE_NAME,
                    REFERENCED_COLUMN_NAME
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = ? 
                AND TABLE_NAME = 'downloads'
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ", 's', [DB_NAME]);
            
            if (empty($fks)) {
                echo '<div class="warning">⚠️ No foreign keys found on downloads table</div>';
            } else {
                echo '<div class="success">✅ Found ' . count($fks) . ' foreign key(s)</div>';
                echo '<table>';
                echo '<tr><th>Constraint</th><th>Column</th><th>References</th></tr>';
                foreach ($fks as $fk) {
                    echo '<tr>';
                    echo '<td>' . e($fk['CONSTRAINT_NAME']) . '</td>';
                    echo '<td>' . e($fk['COLUMN_NAME']) . '</td>';
                    echo '<td>' . e($fk['REFERENCED_TABLE_NAME']) . '.' . e($fk['REFERENCED_COLUMN_NAME']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
        }

        // Step 7: Recommendations
        echo "<h2>7️⃣ Recommendations</h2>";
        
        echo '<div class="info">';
        echo '<h3>To add sample downloads for testing:</h3>';
        echo '<pre>';
        echo "-- Option 1: Via Admin Panel (Recommended)\n";
        echo "1. Login as admin at /login.php\n";
        echo "2. Go to Admin Panel → Upload\n";
        echo "3. Fill in the form with download details\n\n";
        
        echo "-- Option 2: Via SQL (Quick Testing)\n";
        echo "INSERT INTO downloads (name, description, file_size, file_type, download_link, category_id, download_count, created_by, created_at) VALUES\n";
        echo "('BabixGO Script v1.0', 'Ein nützliches Script für Entwickler', '5.2 MB', 'ZIP', 'https://example.com/script.zip', 1, 0, NULL, NOW()),\n";
        echo "('Freundschaftsbalken Android v2.0', 'Android App für Freundschaftsbalken', '15.3 MB', 'APK', 'https://example.com/app.apk', 2, 0, NULL, NOW()),\n";
        echo "('Freundschaftsbalken Windows v2.0', 'Windows Anwendung für Freundschaftsbalken', '25.1 MB', 'EXE', 'https://example.com/app.exe', 3, 0, NULL, NOW());\n";
        echo "</pre>";
        echo '</div>';

        echo '<div class="info">';
        echo '<h3>Security Reminders:</h3>';
        echo '<ul>';
        echo '<li>❗ <strong>DELETE THIS FILE</strong> (db-diagnostic.php) after diagnostics</li>';
        echo '<li>Set DEBUG_MODE=false in production (.env file)</li>';
        echo '<li>Ensure only admins can access install.php</li>';
        echo '<li>Keep database credentials secure</li>';
        echo '</ul>';
        echo '</div>';
        ?>

        <hr style="margin: 40px 0; border-color: #404040;">
        <p style="text-align: center; color: #888;">
            BabixGO Files - Database Diagnostic Tool<br>
            <small>Delete this file after use!</small>
        </p>
    </div>
</body>
</html>
