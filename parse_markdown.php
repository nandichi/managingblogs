<?php
/**
 * Markdown parser endpoint
 * 
 * Dit bestand dient als een AJAX endpoint om Markdown tekst om te zetten naar HTML
 * voor de live preview functionaliteit in de post editor.
 */

// Laad de Composer autoloader indien nog niet geladen
if (!class_exists('\Parsedown')) {
    require_once 'vendor/autoload.php';
}

// Inclusief de helper functies
require_once 'includes/functions.php';

// Controleer of er content is verzonden
if (isset($_POST['content'])) {
    $markdown = $_POST['content'];
    
    // Gebruik de parseMarkdown functie om de markdown om te zetten naar HTML
    $html = parseMarkdown($markdown);
    
    // Stuur de HTML terug
    echo $html;
} else {
    // Als er geen content is, stuur een foutmelding terug
    http_response_code(400);
    echo '<p class="text-red-500">Fout: Geen content aangeleverd om te verwerken.</p>';
}
?> 