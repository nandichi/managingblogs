<?php
/**
 * Create Post - Pagina om een nieuwe blogpost aan te maken
 */

// Laad benodigde bestanden
require_once 'config/database.php';
require_once 'includes/functions.php';

// Laad modellen
require_once 'models/Post.php';
require_once 'models/User.php';
require_once 'models/Category.php';
require_once 'models/Comment.php';

// Laad controllers
require_once 'controllers/PostController.php';
require_once 'controllers/AuthController.php';

// Start een sessie als die nog niet bestaat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connectie
$db = getDbConnection();

// Initialiseer controllers
$postController = new PostController($db);
$authController = new AuthController($db);

// Controleer of gebruiker is ingelogd, anders redirect naar login
$authController->requireLogin();

// Als het formulier is verzonden, verwerk de post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postController->createPost($authController);
} else {
    // Haal categorieën op voor het dropdown menu
    $categoryModel = new Category($db);
    $categories = $categoryModel->getAllCategories();
    
    // Toon het create post formulier
    include_once 'views/create_post.php';
}
?> 