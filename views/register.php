<?php
// Inclusief header met navigatie
require_once 'includes/header.php';
// Inclusief helper functies als die nog niet zijn geladen
require_once 'includes/functions.php';
?>

<div class="flex justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-2xl font-bold text-center mb-6">Registreer een account</h1>
            
            <form action="register_process.php" method="POST" x-data="{ password: '', confirmPassword: '', isMatch: true }">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-medium mb-2">Gebruikersnaam</label>
                    <input type="text" id="username" name="username" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-primary"
                        pattern=".{3,}" title="Gebruikersnaam moet minimaal 3 tekens bevatten">
                    <p class="text-sm text-gray-500 mt-1">Minimaal 3 tekens</p>
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">E-mailadres</label>
                    <input type="email" id="email" name="email" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-primary">
                </div>
                
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Wachtwoord</label>
                    <input type="password" id="password" name="password" x-model="password" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-primary"
                        pattern=".{8,}" title="Wachtwoord moet minimaal 8 tekens bevatten">
                    <p class="text-sm text-gray-500 mt-1">Minimaal 8 tekens</p>
                </div>
                
                <div class="mb-6">
                    <label for="confirm_password" class="block text-gray-700 font-medium mb-2">Wachtwoord bevestigen</label>
                    <input type="password" id="confirm_password" name="confirm_password" x-model="confirmPassword" required 
                        @input="isMatch = (password === confirmPassword)" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none"
                        :class="{'border-primary': isMatch && confirmPassword.length > 0, 'border-red-500': !isMatch && confirmPassword.length > 0}">
                    <p class="text-sm text-red-500 mt-1" x-show="!isMatch && confirmPassword.length > 0">
                        Wachtwoorden komen niet overeen
                    </p>
                </div>
                
                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="terms" name="terms" required class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-gray-700">
                            Ik ga akkoord met de <a href="terms.php" class="text-primary hover:underline">gebruiksvoorwaarden</a> en 
                            <a href="privacy.php" class="text-primary hover:underline">het privacybeleid</a>
                        </label>
                    </div>
                </div>
                
                <div>
                    <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-opacity-90 transition"
                            :disabled="!isMatch" :class="{'opacity-50 cursor-not-allowed': !isMatch}">
                        Registreren
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Heb je al een account? <a href="login.php" class="text-primary hover:underline">Log hier in</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php
// Inclusief footer
require_once 'includes/footer.php';
?> 