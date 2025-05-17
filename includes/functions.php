<?php
/**
 * Algemene helper functies voor de toepassing
 */

/**
 * Toont een flash bericht uit de sessie
 */
function showFlashMessage() {
    if (isset($_SESSION['success'])) {
        echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">';
        echo '<p class="font-bold">Succes!</p>';
        echo '<p>' . htmlspecialchars($_SESSION['success']) . '</p>';
        echo '</div>';
        unset($_SESSION['success']);
    }
    
    if (isset($_SESSION['error'])) {
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">';
        echo '<p class="font-bold">Fout!</p>';
        echo '<p>' . htmlspecialchars($_SESSION['error']) . '</p>';
        echo '</div>';
        unset($_SESSION['error']);
    }
    
    if (isset($_SESSION['errors']) && is_array($_SESSION['errors'])) {
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">';
        echo '<p class="font-bold">Er zijn fouten opgetreden:</p>';
        echo '<ul class="list-disc pl-5">';
        foreach ($_SESSION['errors'] as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul>';
        echo '</div>';
        unset($_SESSION['errors']);
    }
}

/**
 * Formatteert een datum in een leesbaar formaat
 */
function formatDate($date) {
    $timestamp = strtotime($date);
    return date('d-m-Y H:i', $timestamp);
}

/**
 * Genereert een samenvatting van een tekst met een bepaalde lengte
 */
function createExcerpt($text, $length = 150) {
    // Verwijder HTML tags
    $text = strip_tags($text);
    
    if (strlen($text) <= $length) {
        return $text;
    }
    
    // Knip de tekst af op de juiste lengte
    $excerpt = substr($text, 0, $length);
    
    // Zorg ervoor dat we geen woord halverwege afbreken
    $excerpt = substr($excerpt, 0, strrpos($excerpt, ' '));
    
    return $excerpt . '...';
}

/**
 * Beveiligt output tegen XSS
 */
function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Genereert paginatielinks
 */
function generatePagination($currentPage, $totalPages, $urlPattern) {
    if ($totalPages <= 1) {
        return '';
    }
    
    $html = '<div class="flex justify-center my-8">';
    $html .= '<nav class="inline-flex rounded-md shadow">';
    
    // Vorige pagina link
    if ($currentPage > 1) {
        $prevPage = $currentPage - 1;
        $html .= '<a href="' . sprintf($urlPattern, $prevPage) . '" class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">';
        $html .= 'Vorige';
        $html .= '</a>';
    } else {
        $html .= '<span class="px-3 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-500">';
        $html .= 'Vorige';
        $html .= '</span>';
    }
    
    // Paginanummers
    $startPage = max(1, $currentPage - 2);
    $endPage = min($totalPages, $startPage + 4);
    
    for ($i = $startPage; $i <= $endPage; $i++) {
        if ($i == $currentPage) {
            $html .= '<span class="px-3 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">';
            $html .= $i;
            $html .= '</span>';
        } else {
            $html .= '<a href="' . sprintf($urlPattern, $i) . '" class="px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">';
            $html .= $i;
            $html .= '</a>';
        }
    }
    
    // Volgende pagina link
    if ($currentPage < $totalPages) {
        $nextPage = $currentPage + 1;
        $html .= '<a href="' . sprintf($urlPattern, $nextPage) . '" class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">';
        $html .= 'Volgende';
        $html .= '</a>';
    } else {
        $html .= '<span class="px-3 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-500">';
        $html .= 'Volgende';
        $html .= '</span>';
    }
    
    $html .= '</nav>';
    $html .= '</div>';
    
    return $html;
}

/**
 * Genereert een thumbnail URL, of een standaard afbeelding als de featured image niet bestaat
 */
function getThumbnailUrl($featuredImage) {
    if ($featuredImage && file_exists($featuredImage)) {
        return $featuredImage;
    }
    
    // Gebruik een placeholder afbeelding als de standaard afbeelding ontbreekt
    return 'https://via.placeholder.com/800x500/1a365d/ffffff?text=Real+Madrid';
}

/**
 * Reageert met een 404 fout
 */
function show404() {
    header("HTTP/1.0 404 Not Found");
    include_once 'views/404.php';
    exit;
}

/**
 * Valideert of een variabele een geldig e-mailadres is
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Genereert een veilige random token
 */
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

/**
 * Stuurt een JSON response terug
 */
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

/**
 * Haalt de huidige URL op
 */
function getCurrentUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Genereert een Gravatar URL voor een e-mailadres
 */
function getGravatarUrl($email, $size = 80) {
    $hash = md5(strtolower(trim($email)));
    return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d=mp";
} 