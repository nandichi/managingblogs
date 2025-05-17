<?php
/**
 * Login Process - Verwerkt loginverzoeken
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

// Alleen toegang via POST-verzoeken
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// Database connectie
$db = getDbConnection();

// Initialiseer controller
$authController = new AuthController($db);

// Haal logingegevens op
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$remember = isset($_POST['remember']) && $_POST['remember'] === 'on';

// Probeer de gebruiker in te loggen
$result = $authController->login($username, $password);

if ($result === true) {
    // Inloggen succesvol
    
    // Stel een "remember me" cookie in als dat is aangevraagd
    if ($remember) {
        $token = generateToken();
        
        // Sla het token op in de database (zou gedaan moeten worden met een apart model)
        
        // Stel een cookie in die 30 dagen geldig is
        setcookie('remember_token', $token, time() + (86400 * 30), '/');
    }
    
    // Doorverwijzen naar de homepage of de laatst bezochte pagina
    $redirect = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : 'index.php';
    unset($_SESSION['redirect_after_login']);
    
    header("Location: $redirect");
    exit;
} else {
    // Inloggen mislukt
    $_SESSION['error'] = $result;
    header('Location: login.php');
    exit;
}
?> 