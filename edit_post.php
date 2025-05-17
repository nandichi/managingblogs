<?php
/**
 * Edit Post - Pagina om een bestaande blogpost te bewerken
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
    header('Location: blog.php');
    exit;
}

$id = (int)$_GET['id'];

// Als het formulier is verzonden, verwerk de post update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postController->updatePost($id, $authController);
} else {
    // Toon het edit post formulier
    $postController->showEditPostForm($id, $authController);
}
?> 