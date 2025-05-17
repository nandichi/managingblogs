<?php
/**
 * Database Configuration and Connection
 */
$db_config = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'database' => 'managingblogs'
];

/**
 * PDO Database Connection
 */
function getDbConnection() {
    global $db_config;
    
    try {
        $dsn = "mysql:host={$db_config['host']};dbname={$db_config['database']};charset=utf8mb4";
        $pdo = new PDO($dsn, $db_config['user'], $db_config['password']);
        
        // Set PDO to throw exceptions on error
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Use prepared statements by default
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        return $pdo;
    } catch (PDOException $e) {
        // Log error and display user-friendly message
        error_log("Database Connection Error: " . $e->getMessage());
        die("Er is een probleem met de databaseverbinding. Probeer het later opnieuw.");
    }
} 