<?php
/**
 * Register Process - Verwerkt registratieverzoeken
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
    header('Location: register.php');
    exit;
}

// Database connectie
$db = getDbConnection();

// Initialiseer controller
$authController = new AuthController($db);

// Haal registratiegegevens op
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
$terms = isset($_POST['terms']) && $_POST['terms'] === 'on';

// Controleer of de gebruiker akkoord is gegaan met de voorwaarden
if (!$terms) {
    $_SESSION['error'] = "Je moet akkoord gaan met de gebruiksvoorwaarden en het privacybeleid";
    header('Location: register.php');
    exit;
}

// Registreer de gebruiker
$result = $authController->register($username, $email, $password, $confirmPassword);

if ($result === true) {
    // Registratie succesvol
    $_SESSION['success'] = "Je bent succesvol geregistreerd en bent nu ingelogd";
    header('Location: index.php');
    exit;
} else {
    // Registratie mislukt
    $_SESSION['errors'] = $result;
    header('Location: register.php');
    exit;
}
?> 