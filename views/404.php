<?php
// Inclusief header met navigatie
require_once 'includes/header.php';
// Inclusief helper functies als die nog niet zijn geladen
require_once 'includes/functions.php';
?>

<div class="flex flex-col items-center justify-center py-12">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-primary mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Pagina niet gevonden</h2>
        <p class="text-gray-600 mb-8">
            De pagina die je zoekt bestaat niet of is verplaatst.
        </p>
        <div class="flex justify-center space-x-4">
            <a href="javascript:history.back()" class="px-6 py-2 border border-primary text-primary rounded-md hover:bg-primary hover:text-white transition-colors">
                Ga terug
            </a>
            <a href="index.php" class="px-6 py-2 bg-primary text-white rounded-md hover:bg-opacity-90 transition-colors">
                Naar homepage
            </a>
        </div>
    </div>
    
    <div class="mt-12">
        <img src="public/images/404.svg" alt="404 Illustratie" class="w-full max-w-md h-auto">
    </div>
</div>

<?php
// Inclusief footer
require_once 'includes/footer.php';
?> 