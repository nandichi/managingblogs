<?php
/**
 * Login - Inlogpagina
 */

// Laad benodigde bestanden
require_once 'config/database.php';
require_once 'includes/functions.php';

// Start een sessie als die nog niet bestaat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Controleer of gebruiker al is ingelogd
if (isset($_SESSION['user_id'])) {
    // Redirect naar homepage
    header('Location: index.php');
    exit;
}

// Database connectie - nodig voor sidebar categorieën
$db = getDbConnection();

// Laad modellen voor sidebar categorieën
require_once 'models/Category.php';
require_once 'models/Post.php';

// Haal categorieën op voor de sidebar
$categoryModel = new Category($db);
$categories = $categoryModel->getCategoriesWithPostCount();

// Laad de login view
require_once 'views/login.php';
?> 