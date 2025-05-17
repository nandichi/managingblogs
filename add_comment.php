<?php
/**
 * Add Comment - Reactie toevoegen aan een post
 */

// Laad benodigde bestanden
require_once 'config/database.php';
require_once 'includes/functions.php';

// Laad modellen
require_once 'models/User.php';
require_once 'models/Post.php';
require_once 'models/Comment.php';

// Laad controllers
require_once 'controllers/AuthController.php';
require_once 'controllers/CommentController.php';

// Start een sessie als die nog niet bestaat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Alleen toegang via POST-verzoeken
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Redirect naar de homepage
    header('Location: index.php');
    exit;
}

// Database connectie
$db = getDbConnection();

// Initialiseer controllers
$authController = new AuthController($db);
$commentController = new CommentController($db);

// Controleer of de gebruiker is ingelogd
if (!$authController->isLoggedIn()) {
    $_SESSION['error'] = "Je moet ingelogd zijn om een reactie te plaatsen";
    
    // Haal de post-ID op om terug te redirecten
    $postId = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
    if ($postId > 0) {
        header("Location: post.php?id=$postId");
    } else {
        header('Location: index.php');
    }
    exit;
}

// Voeg de reactie toe
$commentController->addComment($authController);

// Deze code zal nooit worden bereikt, omdat de controller zelf al doorverwijst
// na het toevoegen van een reactie, of bij een fout
?> 