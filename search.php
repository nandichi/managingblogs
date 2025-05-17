<?php
/**
 * Search - Toont zoekresultaten
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

// Controleer of er een zoekopdracht is meegegeven
if (!isset($_GET['q']) || empty($_GET['q'])) {
    header('Location: blog.php');
    exit;
}

// Toon zoekresultaten
$postController->showSearchResults();
?> 