<?php
// Inclusief header met navigatie
require_once 'includes/header.php';
// Inclusief helper functies als die nog niet zijn geladen
require_once 'includes/functions.php';
?>

<div class="flex justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-2xl font-bold text-center mb-6">Inloggen</h1>
            
            <form action="login_process.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-medium mb-2">Gebruikersnaam of e-mail</label>
                    <input type="text" id="username" name="username" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-primary">
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Wachtwoord</label>
                    <input type="password" id="password" name="password" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-primary">
                </div>
                
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-gray-700">Onthoud mij</label>
                    </div>
                    
                    <a href="forgot_password.php" class="text-sm text-primary hover:underline">Wachtwoord vergeten?</a>
                </div>
                
                <div>
                    <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition">
                        Inloggen
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Nog geen account? <a href="register.php" class="text-primary hover:underline">Registreer hier</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php
// Inclusief footer
require_once 'includes/footer.php';
?> 