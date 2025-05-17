<?php
/**
 * Profile - Gebruikersprofiel pagina
 */

// Laad benodigde bestanden
require_once 'config/database.php';
require_once 'includes/functions.php';

// Start een sessie als die nog niet bestaat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Laad modellen
require_once 'models/User.php';
require_once 'models/Category.php';
require_once 'models/Post.php';

// Laad controllers
require_once 'controllers/AuthController.php';

// Database connectie
$db = getDbConnection();

// Initialiseer controllers
$authController = new AuthController($db);
$userModel = new User($db);

// Zorg ervoor dat gebruiker is ingelogd
$authController->requireLogin();

// Verkrijg de ingelogde gebruiker
$currentUser = $authController->getCurrentUser();
$userDetails = $userModel->getUserById($currentUser['id']);

// Initialiseer berichten arrays
$success = [];
$errors = [];

// Zorg ervoor dat de uploads map bestaat
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

// Verwerk formulierinzendingen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Upload profielfoto
    if (isset($_POST['upload_profile_image']) && isset($_FILES['profile_image'])) {
        $file = $_FILES['profile_image'];
        
        // Debug informatie toevoegen
        $debug = "File upload info: " . print_r($file, true);
        error_log($debug);
        
        // Controleer op uploadfouten
        if ($file['error'] === 0) {
            // Controleer bestandstype
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $detectedType = finfo_file($fileInfo, $file['tmp_name']);
            
            error_log("Detected file type: " . $detectedType);
            
            if (in_array($detectedType, $allowedTypes)) {
                // Genereer unieke bestandsnaam
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $newFilename = 'uploads/profile_' . $currentUser['id'] . '_' . time() . '.' . $extension;
                
                error_log("New filename: " . $newFilename);
                
                // Zorg ervoor dat de uploads map bestaat en schrijfbaar is
                if (!file_exists('uploads')) {
                    mkdir('uploads', 0777, true);
                    error_log("Created uploads directory");
                }
                
                // Verplaats bestand naar uploads map
                if (move_uploaded_file($file['tmp_name'], $newFilename)) {
                    error_log("File successfully moved to: " . $newFilename);
                    
                    // Verwijder oude profielfoto als deze bestaat
                    if (!empty($userDetails['profile_image']) && file_exists($userDetails['profile_image']) && $userDetails['profile_image'] !== $newFilename) {
                        unlink($userDetails['profile_image']);
                        error_log("Removed old profile image: " . $userDetails['profile_image']);
                    }
                    
                    // Update gebruikersprofiel in de database
                    $updateData = [
                        'profile_image' => $newFilename
                    ];
                    
                    error_log("Updating user profile with image: " . $newFilename);
                    
                    if ($userModel->updateUser($currentUser['id'], $updateData)) {
                        $success[] = "Profielfoto is succesvol bijgewerkt";
                        
                        // Haal de bijgewerkte gebruikersgegevens op
                        $userDetails = $userModel->getUserById($currentUser['id']);
                        error_log("Updated user details: " . print_r($userDetails, true));
                        
                        // Voeg het profile_image rechtstreeks toe aan de sessie voor onmiddellijke weergave
                        $_SESSION['profile_image'] = $newFilename;
                    } else {
                        $errors[] = "Er is een fout opgetreden bij het bijwerken van je profielfoto";
                        error_log("Failed to update user profile in database");
                    }
                } else {
                    $errors[] = "Er is een fout opgetreden bij het uploaden van je profielfoto";
                    error_log("Failed to move uploaded file to: " . $newFilename);
                }
            } else {
                $errors[] = "Alleen afbeeldingsbestanden (JPEG, PNG, GIF, WEBP) zijn toegestaan";
                error_log("Invalid file type: " . $detectedType);
            }
        } else {
            error_log("File upload error code: " . $file['error']);
            switch ($file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $errors[] = "Het bestand is te groot";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $errors[] = "Het bestand is slechts gedeeltelijk geüpload";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $errors[] = "Geen bestand geselecteerd";
                    break;
                default:
                    $errors[] = "Er is een fout opgetreden bij het uploaden";
            }
        }
    }
    
    // Profiel update
    if (isset($_POST['update_profile'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        
        // Valideer gebruikersnaam
        if (empty($username) || strlen($username) < 3) {
            $errors[] = "Gebruikersnaam moet minimaal 3 tekens bevatten";
        }
        
        // Valideer e-mail
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Een geldig e-mailadres is vereist";
        }
        
        // Controleer of gebruikersnaam al bestaat (behalve voor huidige gebruiker)
        $existingUser = $userModel->getUserByUsername($username);
        if ($existingUser && $existingUser['id'] != $currentUser['id']) {
            $errors[] = "Gebruikersnaam is al in gebruik";
        }
        
        // Controleer of e-mail al bestaat (behalve voor huidige gebruiker)
        $existingEmail = $userModel->getUserByEmail($email);
        if ($existingEmail && $existingEmail['id'] != $currentUser['id']) {
            $errors[] = "E-mailadres is al in gebruik";
        }
        
        // Update profiel als er geen fouten zijn
        if (empty($errors)) {
            $updateData = [
                'username' => $username,
                'email' => $email
            ];
            
            if ($userModel->updateUser($currentUser['id'], $updateData)) {
                // Update sessie gegevens
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                
                $success[] = "Je profiel is succesvol bijgewerkt";
                $userDetails = $userModel->getUserById($currentUser['id']);
            } else {
                $errors[] = "Er is een fout opgetreden bij het bijwerken van je profiel";
            }
        }
    }
    
    // Wachtwoord wijziging
    if (isset($_POST['change_password'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];
        
        // Valideer huidige wachtwoord
        $user = $userModel->getUserByUsername($currentUser['username']);
        if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
            $errors[] = "Huidig wachtwoord is onjuist";
        }
        
        // Valideer nieuw wachtwoord
        if (empty($newPassword) || strlen($newPassword) < 8) {
            $errors[] = "Nieuw wachtwoord moet minimaal 8 tekens bevatten";
        }
        
        // Controleer of wachtwoorden overeenkomen
        if ($newPassword !== $confirmPassword) {
            $errors[] = "Nieuwe wachtwoorden komen niet overeen";
        }
        
        // Wijzig wachtwoord als er geen fouten zijn
        if (empty($errors)) {
            if ($userModel->changePassword($currentUser['id'], $newPassword)) {
                $success[] = "Je wachtwoord is succesvol gewijzigd";
            } else {
                $errors[] = "Er is een fout opgetreden bij het wijzigen van je wachtwoord";
            }
        }
    }
}

// Haal categorieën op voor de sidebar
$categoryModel = new Category($db);
$categories = $categoryModel->getCategoriesWithPostCount();

// Laad de profile view
require_once 'views/profile.php';
?> 