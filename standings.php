<?php
/**
 * Standings - Competitie standen pagina
 */

// Laad benodigde bestanden
require_once 'config/database.php';
require_once 'includes/functions.php';

// Start een sessie als die nog niet bestaat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connectie - nodig voor sidebar categorieën
$db = getDbConnection();

// Laad modellen voor sidebar categorieën
require_once 'models/Category.php';
require_once 'models/Post.php';

// Haal categorieën op voor de sidebar
$categoryModel = new Category($db);
$categories = $categoryModel->getCategoriesWithPostCount();

// Bepaal welke competitie is geselecteerd
$selectedLeague = isset($_GET['league']) ? $_GET['league'] : 'premier-league';

// Lijst van beschikbare competities
$availableLeagues = [
    'premier-league' => 'Premier League',
    'la-liga' => 'La Liga',
    'eredivisie' => 'Eredivisie',
    'bundesliga' => 'Bundesliga',
    'serie-a' => 'Serie A',
    'ligue-1' => 'Ligue 1'
];

// Laad de standings view
require_once 'views/standings.php';
?> 