<?php
/**
 * Category Model - Beheert categorieën voor posts
 */
class Category {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Haalt alle categorieën op
     */
    public function getAllCategories() {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Haalt een categorie op basis van ID
     */
    public function getCategoryById($id) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Haalt een categorie op basis van naam
     */
    public function getCategoryByName($name) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE name = :name");
        $stmt->execute(['name' => $name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Voegt een nieuwe categorie toe
     */
    public function addCategory($name) {
        // Controleer of de categorie al bestaat
        if ($this->getCategoryByName($name)) {
            return false;
        }
        
        $stmt = $this->db->prepare("INSERT INTO categories (name) VALUES (:name)");
        return $stmt->execute(['name' => $name]);
    }
    
    /**
     * Werkt een bestaande categorie bij
     */
    public function updateCategory($id, $name) {
        // Controleer of er een andere categorie bestaat met deze naam
        $existingCategory = $this->getCategoryByName($name);
        if ($existingCategory && $existingCategory['id'] != $id) {
            return false;
        }
        
        $stmt = $this->db->prepare("UPDATE categories SET name = :name WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'name' => $name
        ]);
    }
    
    /**
     * Verwijdert een categorie
     */
    public function deleteCategory($id) {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    /**
     * Haalt categorieën op met aantal posts per categorie
     */
    public function getCategoriesWithPostCount() {
        $stmt = $this->db->query("
            SELECT c.*, COUNT(p.id) as post_count
            FROM categories c
            LEFT JOIN posts p ON c.id = p.category_id
            GROUP BY c.id
            ORDER BY c.name
        ");
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 