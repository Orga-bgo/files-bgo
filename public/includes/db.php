<?php
/**
 * Database connection and helper functions
 */

require_once __DIR__ . '/config.php';

/**
 * Get database connection (singleton pattern)
 * @return mysqli
 */
function getDB(): mysqli {
    static $db = null;
    
    if ($db === null) {
        // Check if database credentials are configured
        if (empty(DB_HOST) || empty(DB_NAME) || empty(DB_USER)) {
            $errorMsg = '<h1>Configuration Error</h1>';
            $errorMsg .= '<p>Database credentials are not configured.</p>';
            $errorMsg .= '<p>Please ensure the following environment variables are set:</p>';
            $errorMsg .= '<ul>';
            $errorMsg .= '<li>DB_HOST' . (empty(DB_HOST) ? ' <strong>(missing)</strong>' : ' ✓') . '</li>';
            $errorMsg .= '<li>DB_NAME' . (empty(DB_NAME) ? ' <strong>(missing)</strong>' : ' ✓') . '</li>';
            $errorMsg .= '<li>DB_USER' . (empty(DB_USER) ? ' <strong>(missing)</strong>' : ' ✓') . '</li>';
            $errorMsg .= '<li>DB_PASSWORD' . (empty(DB_PASS) ? ' <strong>(missing)</strong>' : ' ✓') . '</li>';
            $errorMsg .= '</ul>';
            $errorMsg .= '<p>Create a <code>.env</code> file in the web root or set environment variables on your server.</p>';
            $errorMsg .= '<p>See <code>.env.example</code> for reference.</p>';
            die($errorMsg);
        }
        
        $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($db->connect_error) {
            if (DEBUG_MODE) {
                die('Database connection failed: ' . $db->connect_error);
            } else {
                $errorMsg = '<h1>Database Connection Error</h1>';
                $errorMsg .= '<p>Unable to connect to the database. Please contact the site administrator.</p>';
                $errorMsg .= '<p>Error code: ' . $db->connect_errno . '</p>';
                die($errorMsg);
            }
        }
        
        $db->set_charset(DB_CHARSET);
    }
    
    return $db;
}

/**
 * Execute a prepared statement with parameters
 * @param string $sql SQL query with placeholders
 * @param string $types Parameter types (s=string, i=integer, d=double, b=blob)
 * @param array $params Parameters to bind
 * @return mysqli_result|bool
 */
function executeQuery(string $sql, string $types = '', array $params = []) {
    $db = getDB();
    $stmt = $db->prepare($sql);
    
    if (!$stmt) {
        if (DEBUG_MODE) {
            throw new Exception('Query preparation failed: ' . $db->error);
        }
        return false;
    }
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    
    if ($stmt->errno) {
        if (DEBUG_MODE) {
            throw new Exception('Query execution failed: ' . $stmt->error);
        }
        return false;
    }
    
    $result = $stmt->get_result();
    
    if ($result === false && $stmt->affected_rows >= 0) {
        return true;
    }
    
    return $result;
}

/**
 * Get single row from query result
 * @param string $sql SQL query
 * @param string $types Parameter types
 * @param array $params Parameters to bind
 * @return array|null
 */
function fetchOne(string $sql, string $types = '', array $params = []): ?array {
    $result = executeQuery($sql, $types, $params);
    
    if ($result instanceof mysqli_result) {
        $row = $result->fetch_assoc();
        $result->free();
        return $row;
    }
    
    return null;
}

/**
 * Get all rows from query result
 * @param string $sql SQL query
 * @param string $types Parameter types
 * @param array $params Parameters to bind
 * @return array
 */
function fetchAll(string $sql, string $types = '', array $params = []): array {
    $result = executeQuery($sql, $types, $params);
    
    if ($result instanceof mysqli_result) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
        return $rows;
    }
    
    return [];
}

/**
 * Insert a row and return the insert ID
 * @param string $sql SQL query
 * @param string $types Parameter types
 * @param array $params Parameters to bind
 * @return int|false Insert ID or false on failure
 */
function insertRow(string $sql, string $types = '', array $params = []) {
    $db = getDB();
    $result = executeQuery($sql, $types, $params);
    
    if ($result) {
        return $db->insert_id;
    }
    
    return false;
}

/**
 * Get the number of affected rows from last query
 * @return int
 */
function getAffectedRows(): int {
    return getDB()->affected_rows;
}

/**
 * Close database connection
 */
function closeDB(): void {
    $db = getDB();
    if ($db) {
        $db->close();
    }
}
