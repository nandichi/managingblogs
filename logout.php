<?php
/**
 * Logout - Uitloggen van de gebruiker
 */

// Laad benodigde bestanden
require_once 'config/database.php';
require_once 'includes/functions.php';

// Laad modellen
require_once 'models/User.php';

// Laad controllers
require_once 'controllers/AuthController.php';

// Start een sessie als die nog niet bestaat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verwijder sessievariabelen
$_SESSION = array();

// Als er een sessie cookie is, verwijder deze dan
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Vernietig de sessie
session_destroy();

// Verwijder remember-me cookie als dat bestaat
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/');
}

// Stuur gebruiker terug naar de homepage
$_SESSION['success'] = "Je bent succesvol uitgelogd.";
header("Location: index.php");
exit;
?> 