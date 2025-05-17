<?php
/**
 * CommentController - Beheert reacties op posts
 */
class CommentController {
    private $db;
    private $commentModel;
    private $postModel;
    
    public function __construct($db) {
        $this->db = $db;
        $this->commentModel = new Comment($db);
        $this->postModel = new Post($db);
    }
    
    /**
     * Voegt een nieuwe reactie toe (AJAX of regulier)
     */
    public function addComment($authController) {
        // Controleer of gebruiker is ingelogd
        $authController->requireLogin();
        
        $postId = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
        $content = isset($_POST['content']) ? trim($_POST['content']) : '';
        $isAjax = isset($_POST['ajax']) && $_POST['ajax'] == 1;
        
        // Validatie
        $errors = [];
        
        if (empty($content)) {
            $errors[] = "Reactie mag niet leeg zijn";
        }
        
        // Controleer of de post bestaat
        if (!$this->postModel->getPostById($postId)) {
            $errors[] = "Post niet gevonden";
        }
        
        // Als er geen errors zijn, voeg de reactie toe
        if (empty($errors)) {
            $currentUser = $authController->getCurrentUser();
            
            if ($this->commentModel->addComment($postId, $currentUser['id'], $content)) {
                if ($isAjax) {
                    // Voor AJAX requests, stuur JSON terug
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'message' => 'Reactie succesvol toegevoegd',
                        'comment' => [
                            'username' => $currentUser['username'],
                            'content' => $content,
                            'created_at' => date('Y-m-d H:i:s')
                        ]
                    ]);
                    exit;
                } else {
                    // Voor reguliere requests, redirect terug naar de post
                    $_SESSION['success'] = "Reactie succesvol toegevoegd";
                    header("Location: post.php?id=$postId");
                    exit;
                }
            } else {
                $errors[] = "Er is een fout opgetreden bij het toevoegen van je reactie";
            }
        }
        
        // Als er errors zijn
        if ($isAjax) {
            // Voor AJAX requests, stuur JSON met errors terug
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'errors' => $errors
            ]);
            exit;
        } else {
            // Voor reguliere requests, set errors in session en redirect terug
            $_SESSION['errors'] = $errors;
            header("Location: post.php?id=$postId");
            exit;
        }
    }
    
    /**
     * Toont het formulier voor het bewerken van een reactie
     */
    public function showEditCommentForm($id, $authController) {
        // Controleer of gebruiker is ingelogd
        $authController->requireLogin();
        
        // Haal de reactie op
        $comment = $this->commentModel->getCommentById($id);
        
        if (!$comment) {
            $_SESSION['error'] = "Reactie niet gevonden";
            header("Location: index.php");
            exit;
        }
        
        // Controleer of de huidige gebruiker de auteur is of een admin
        $currentUser = $authController->getCurrentUser();
        if ($comment['user_id'] != $currentUser['id'] && !$authController->isAdmin()) {
            $_SESSION['error'] = "Je hebt geen toestemming om deze reactie te bewerken";
            header("Location: index.php");
            exit;
        }
        
        // Haal de bijbehorende post op
        $post = $this->postModel->getPostById($comment['post_id']);
        
        // Laad het edit reactie formulier
        include_once 'views/edit_comment.php';
    }
    
    /**
     * Verwerkt het bewerken van een reactie
     */
    public function updateComment($id, $authController) {
        // Controleer of gebruiker is ingelogd
        $authController->requireLogin();
        
        // Haal de reactie op
        $comment = $this->commentModel->getCommentById($id);
        
        if (!$comment) {
            $_SESSION['error'] = "Reactie niet gevonden";
            header("Location: index.php");
            exit;
        }
        
        // Controleer of de huidige gebruiker de auteur is of een admin
        $currentUser = $authController->getCurrentUser();
        if ($comment['user_id'] != $currentUser['id'] && !$authController->isAdmin()) {
            $_SESSION['error'] = "Je hebt geen toestemming om deze reactie te bewerken";
            header("Location: index.php");
            exit;
        }
        
        $content = isset($_POST['content']) ? trim($_POST['content']) : '';
        
        // Validatie
        $errors = [];
        
        if (empty($content)) {
            $errors[] = "Reactie mag niet leeg zijn";
        }
        
        // Als er geen errors zijn, update de reactie
        if (empty($errors)) {
            if ($this->commentModel->updateComment($id, $content)) {
                $_SESSION['success'] = "Reactie succesvol bijgewerkt";
                header("Location: post.php?id={$comment['post_id']}");
                exit;
            } else {
                $errors[] = "Er is een fout opgetreden bij het bijwerken van je reactie";
            }
        }
        
        // Als er errors zijn, toon het formulier opnieuw met de errors
        $_SESSION['errors'] = $errors;
        
        // Haal de bijbehorende post op
        $post = $this->postModel->getPostById($comment['post_id']);
        
        // Laad het edit reactie formulier opnieuw
        include_once 'views/edit_comment.php';
    }
    
    /**
     * Verwijdert een reactie
     */
    public function deleteComment($id, $authController) {
        // Controleer of gebruiker is ingelogd
        $authController->requireLogin();
        
        // Haal de reactie op
        $comment = $this->commentModel->getCommentById($id);
        
        if (!$comment) {
            $_SESSION['error'] = "Reactie niet gevonden";
            header("Location: index.php");
            exit;
        }
        
        // Controleer of de huidige gebruiker de auteur is of een admin
        $currentUser = $authController->getCurrentUser();
        if ($comment['user_id'] != $currentUser['id'] && !$authController->isAdmin()) {
            $_SESSION['error'] = "Je hebt geen toestemming om deze reactie te verwijderen";
            header("Location: index.php");
            exit;
        }
        
        // Bewaar post_id voor redirect
        $postId = $comment['post_id'];
        
        // Verwijder de reactie
        if ($this->commentModel->deleteComment($id)) {
            $_SESSION['success'] = "Reactie succesvol verwijderd";
        } else {
            $_SESSION['error'] = "Er is een fout opgetreden bij het verwijderen van de reactie";
        }
        
        // Redirect terug naar de post
        header("Location: post.php?id=$postId");
        exit;
    }
} 