<?php
/**
 * Category - Toont posts uit een specifieke categorie
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

// Controleer of er een categorie ID is meegegeven
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: blog.php');
    exit;
}

// Toon posts uit de specifieke categorie
$postController->showCategoryPosts($_GET['id']);
?> 