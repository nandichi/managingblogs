<?php
/**
 * Comment Model - Beheert reacties op blogposts
 */
class Comment {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Haalt alle reacties voor een specifieke post op
     */
    public function getCommentsByPostId($postId) {
        $stmt = $this->db->prepare("
            SELECT c.*, u.username, u.email, u.profile_image
            FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.post_id = :post_id
            ORDER BY c.created_at DESC
        ");
        
        $stmt->execute(['post_id' => $postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Haalt een specifieke reactie op basis van ID
     */
    public function getCommentById($id) {
        $stmt = $this->db->prepare("
            SELECT c.*, u.username, u.email, u.profile_image
            FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.id = :id
        ");
        
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Haalt alle reacties van een specifieke gebruiker
     */
    public function getCommentsByUserId($userId) {
        $stmt = $this->db->prepare("
            SELECT c.*, p.title as post_title
            FROM comments c
            JOIN posts p ON c.post_id = p.id
            WHERE c.user_id = :user_id
            ORDER BY c.created_at DESC
        ");
        
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Voegt een nieuwe reactie toe
     */
    public function addComment($postId, $userId, $content) {
        $stmt = $this->db->prepare("
            INSERT INTO comments (post_id, user_id, content)
            VALUES (:post_id, :user_id, :content)
        ");
        
        return $stmt->execute([
            'post_id' => $postId,
            'user_id' => $userId,
            'content' => $content
        ]);
    }
    
    /**
     * Werkt een bestaande reactie bij
     */
    public function updateComment($id, $content) {
        $stmt = $this->db->prepare("
            UPDATE comments
            SET content = :content
            WHERE id = :id
        ");
        
        return $stmt->execute([
            'id' => $id,
            'content' => $content
        ]);
    }
    
    /**
     * Verwijdert een reactie
     */
    public function deleteComment($id) {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    /**
     * Telt het aantal reacties voor een post
     */
    public function countCommentsByPostId($postId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM comments WHERE post_id = :post_id");
        $stmt->execute(['post_id' => $postId]);
        return $stmt->fetchColumn();
    }
} 