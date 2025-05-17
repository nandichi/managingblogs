<?php
/**
 * Delete Post - Verwijdert een blogpost
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

// Controleer of er een post ID is meegegeven
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];

// Verwijder de post
$postController->deletePost($id, $authController);
?> 