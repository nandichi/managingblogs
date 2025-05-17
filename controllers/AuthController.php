<?php
/**
 * AuthController - Beheert gebruikersauthenticatie en sessiecontrole
 */
class AuthController {
    private $db;
    private $user;
    
    public function __construct($db) {
        $this->db = $db;
        $this->user = new User($db);
        
        // Start een sessie als er nog geen actief is
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Verwerkt het registratieformulier
     */
    public function register($username, $email, $password, $confirmPassword) {
        $errors = [];
        
        // Valideer gebruikersnaam
        if (empty($username) || strlen($username) < 3) {
            $errors[] = "Gebruikersnaam moet minimaal 3 tekens bevatten";
        }
        
        // Valideer e-mail
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Een geldig e-mailadres is vereist";
        }
        
        // Valideer wachtwoord
        if (empty($password) || strlen($password) < 8) {
            $errors[] = "Wachtwoord moet minimaal 8 tekens bevatten";
        }
        
        // Controleer of wachtwoorden overeenkomen
        if ($password !== $confirmPassword) {
            $errors[] = "Wachtwoorden komen niet overeen";
        }
        
        // Controleer of gebruikersnaam al bestaat
        if ($this->user->getUserByUsername($username)) {
            $errors[] = "Gebruikersnaam is al in gebruik";
        }
        
        // Controleer of e-mail al bestaat
        if ($this->user->getUserByEmail($email)) {
            $errors[] = "E-mailadres is al in gebruik";
        }
        
        // Als er geen errors zijn, maak de gebruiker aan
        if (empty($errors)) {
            if ($this->user->createUser($username, $email, $password)) {
                // Gebruiker meteen inloggen na registratie
                $user = $this->user->getUserByUsername($username);
                $this->setLoggedInUser($user);
                return true;
            } else {
                $errors[] = "Er is een fout opgetreden bij het aanmaken van je account";
            }
        }
        
        return $errors;
    }
    
    /**
     * Verwerkt het inlogformulier
     */
    public function login($username, $password) {
        $user = $this->user->login($username, $password);
        
        if ($user) {
            $this->setLoggedInUser($user);
            return true;
        }
        
        return "Ongeldige gebruikersnaam of wachtwoord";
    }
    
    /**
     * Logt de gebruiker uit
     */
    public function logout() {
        // Verwijder gebruikersgegevens uit de sessie
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['is_admin']);
        
        // Vernietig de sessie
        session_destroy();
        
        // Stuur de gebruiker naar de homepage
        header("Location: index.php");
        exit;
    }
    
    /**
     * Slaat gebruikersgegevens op in de sessie
     */
    private function setLoggedInUser($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'] ?? 0;
    }
    
    /**
     * Controleert of de gebruiker is ingelogd
     */
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Controleert of de ingelogde gebruiker admin is
     */
    public function isAdmin() {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
    }
    
    /**
     * Haalt de huidige ingelogde gebruiker op
     */
    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'is_admin' => $_SESSION['is_admin'] ?? 0
            ];
        }
        
        return null;
    }
    
    /**
     * Voert een rechtencontrole uit voor toegang tot bepaalde pagina's
     */
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            $_SESSION['error'] = "Je moet ingelogd zijn om deze pagina te bekijken";
            header("Location: login.php");
            exit;
        }
    }
    
    /**
     * Voert een rechtencontrole uit voor toegang tot admin pagina's
     */
    public function requireAdmin() {
        $this->requireLogin();
        
        if (!$this->isAdmin()) {
            $_SESSION['error'] = "Je hebt geen toegang tot deze pagina";
            header("Location: index.php");
            exit;
        }
    }
} 