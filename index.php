<?php
/**
 * Homepage - Hoofdpagina van de website
 */

// Laad benodigde bestanden
require_once 'config/database.php';
require_once 'includes/functions.php';

// Laad modellen
require_once 'models/Post.php';
require_once 'models/User.php';
require_once 'models/Comment.php';
require_once 'models/Category.php';

// Laad controllers
require_once 'controllers/PostController.php';

// Start een sessie als die nog niet bestaat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connectie
$db = getDbConnection();

// Initialiseer controller
$postController = new PostController($db);

// Toon de homepage
$postController->showHomePage();
?> 