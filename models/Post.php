<?php
/**
 * Post Model - Beheert blog posts en gerelateerde functionaliteit
 */
class Post {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Haalt alle posts op, gesorteerd op aanmaakdatum (nieuwste eerst)
     * Ondersteunt paginering
     */
    public function getAllPosts($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        
        $stmt = $this->db->prepare("
            SELECT p.*, u.username as author_name, c.name as category_name
            FROM posts p
            JOIN users u ON p.author_id = u.id
            JOIN categories c ON p.category_id = c.id
            ORDER BY p.created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        
        $stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Telt het totale aantal posts (voor paginering)
     */
    public function countPosts() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM posts");
        return $stmt->fetchColumn();
    }
    
    /**
     * Haalt een specifieke post op basis van ID
     */
    public function getPostById($id) {
        $stmt = $this->db->prepare("
            SELECT p.*, u.username as author_name, c.name as category_name
            FROM posts p
            JOIN users u ON p.author_id = u.id
            JOIN categories c ON p.category_id = c.id
            WHERE p.id = :id
        ");
        
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Haalt posts op uit een specifieke categorie
     */
    public function getPostsByCategory($categoryId, $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        
        $stmt = $this->db->prepare("
            SELECT p.*, u.username as author_name, c.name as category_name
            FROM posts p
            JOIN users u ON p.author_id = u.id
            JOIN categories c ON p.category_id = c.id
            WHERE p.category_id = :category_id
            ORDER BY p.created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Haalt de meest recente posts op
     */
    public function getRecentPosts($limit = 5) {
        $stmt = $this->db->prepare("
            SELECT p.*, u.username as author_name, c.name as category_name
            FROM posts p
            JOIN users u ON p.author_id = u.id
            JOIN categories c ON p.category_id = c.id
            ORDER BY p.created_at DESC
            LIMIT :limit
        ");
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Maakt een nieuwe blogpost
     */
    public function createPost($title, $content, $authorId, $categoryId, $featuredImage = null) {
        $stmt = $this->db->prepare("
            INSERT INTO posts (title, content, author_id, category_id, featured_image)
            VALUES (:title, :content, :author_id, :category_id, :featured_image)
        ");
        
        return $stmt->execute([
            'title' => $title,
            'content' => $content,
            'author_id' => $authorId,
            'category_id' => $categoryId,
            'featured_image' => $featuredImage
        ]);
    }
    
    /**
     * Werkt een bestaande post bij
     */
    public function updatePost($id, $title, $content, $categoryId, $featuredImage = null) {
        $stmt = $this->db->prepare("
            UPDATE posts
            SET title = :title, 
                content = :content, 
                category_id = :category_id,
                featured_image = :featured_image
            WHERE id = :id
        ");
        
        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'content' => $content,
            'category_id' => $categoryId,
            'featured_image' => $featuredImage
        ]);
    }
    
    /**
     * Verwijdert een post
     */
    public function deletePost($id) {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    /**
     * Zoekt in posts
     */
    public function searchPosts($searchTerm, $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $searchParam = "%{$searchTerm}%";
        
        $stmt = $this->db->prepare("
            SELECT p.*, u.username as author_name, c.name as category_name
            FROM posts p
            JOIN users u ON p.author_id = u.id
            JOIN categories c ON p.category_id = c.id
            WHERE p.title LIKE :search OR p.content LIKE :search
            ORDER BY p.created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        
        $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        $stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 