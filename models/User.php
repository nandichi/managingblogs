<?php
/**
 * User Model - Beheert gebruikersdata en authenticatie
 */
class User {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Haalt een gebruiker op basis van ID
     */
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT id, username, email, profile_image, is_admin, created_at FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Haalt een gebruiker op basis van gebruikersnaam
     */
    public function getUserByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Haalt een gebruiker op basis van e-mail
     */
    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Maakt een nieuwe gebruiker aan
     */
    public function createUser($username, $email, $password) {
        // Controleer of gebruikersnaam of e-mail al bestaat
        if ($this->getUserByUsername($username) || $this->getUserByEmail($email)) {
            return false;
        }
        
        // Hash het wachtwoord
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->db->prepare("
            INSERT INTO users (username, email, password_hash) 
            VALUES (:username, :email, :password_hash)
        ");
        
        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password_hash' => $passwordHash
        ]);
    }
    
    /**
     * Controleert gebruikersgegevens en geeft een gebruiker terug bij succes
     */
    public function login($username, $password) {
        $user = $this->getUserByUsername($username);
        
        if ($user && password_verify($password, $user['password_hash'])) {
            // Verwijder het wachtwoord uit de array voordat we deze teruggeven
            unset($user['password_hash']);
            return $user;
        }
        
        return false;
    }
    
    /**
     * Updatet een gebruikersprofiel
     */
    public function updateUser($id, $data) {
        $allowed = ['username', 'email', 'profile_image'];
        $fields = [];
        $values = ['id' => $id];
        
        foreach ($data as $key => $value) {
            if (in_array($key, $allowed)) {
                $fields[] = "$key = :$key";
                $values[$key] = $value;
            }
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $stmt = $this->db->prepare("
            UPDATE users
            SET " . implode(', ', $fields) . "
            WHERE id = :id
        ");
        
        return $stmt->execute($values);
    }
    
    /**
     * Wijzigt het wachtwoord van een gebruiker
     */
    public function changePassword($id, $newPassword) {
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $stmt = $this->db->prepare("
            UPDATE users
            SET password_hash = :password_hash
            WHERE id = :id
        ");
        
        return $stmt->execute([
            'id' => $id,
            'password_hash' => $passwordHash
        ]);
    }
} 