<?php
/**
 * PostController - Beheert blogposts en gerelateerde functionaliteit
 */
class PostController {
    private $db;
    private $postModel;
    private $categoryModel;
    private $commentModel;
    
    public function __construct($db) {
        $this->db = $db;
        $this->postModel = new Post($db);
        $this->categoryModel = new Category($db);
        $this->commentModel = new Comment($db);
    }
    
    /**
     * Toont de homepagina met featured en recente posts
     */
    public function showHomePage() {
        // Haal featured post op (hier nemen we gewoon de nieuwste post)
        $featuredPosts = $this->postModel->getRecentPosts(1);
        $featuredPost = !empty($featuredPosts) ? $featuredPosts[0] : null;
        
        // Haal recente posts op (exclusief de featured post)
        $recentPosts = $this->postModel->getRecentPosts(6);
        
        // Als er een featured post is, verwijder deze uit de recente posts
        if ($featuredPost) {
            foreach ($recentPosts as $key => $post) {
                if ($post['id'] == $featuredPost['id']) {
                    unset($recentPosts[$key]);
                    break;
                }
            }
        }
        
        // Haal categorieën op voor de sidebar
        $categories = $this->categoryModel->getCategoriesWithPostCount();
        
        // Laad de homepagina view
        include_once 'views/home.php';
    }
    
    /**
     * Toont een lijst van alle posts, met paginering
     */
    public function showAllPosts() {
        // Haal de huidige pagina op uit de URL
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page); // Zorg ervoor dat de pagina minimaal 1 is
        $perPage = 10;
        
        // Haal posts op voor de huidige pagina
        $posts = $this->postModel->getAllPosts($page, $perPage);
        
        // Bereken totaal aantal pagina's voor de paginering
        $totalPosts = $this->postModel->countPosts();
        $totalPages = ceil($totalPosts / $perPage);
        
        // Haal categorieën op voor de sidebar
        $categories = $this->categoryModel->getCategoriesWithPostCount();
        
        // Laad de blog overzichtspagina
        include_once 'views/blog.php';
    }
    
    /**
     * Toont een specifieke blogpost met reacties
     */
    public function showPost($id) {
        // Haal de post op
        $post = $this->postModel->getPostById($id);
        
        if (!$post) {
            $_SESSION['error'] = "Post niet gevonden";
            header("Location: index.php");
            exit;
        }
        
        // Haal reacties op voor deze post
        $comments = $this->commentModel->getCommentsByPostId($id);
        
        // Haal aanverwante posts op (hier: posts uit dezelfde categorie)
        $relatedPosts = $this->postModel->getPostsByCategory($post['category_id'], 1, 4);
        
        // Verwijder de huidige post uit de aanverwante posts
        foreach ($relatedPosts as $key => $relatedPost) {
            if ($relatedPost['id'] == $post['id']) {
                unset($relatedPosts[$key]);
                break;
            }
        }
        
        // Haal categorieën op voor de sidebar
        $categories = $this->categoryModel->getCategoriesWithPostCount();
        
        // Laad de post view
        include_once 'views/post.php';
    }
    
    /**
     * Toont posts uit een specifieke categorie
     */
    public function showCategoryPosts($categoryId) {
        // Haal de categorie op
        $category = $this->categoryModel->getCategoryById($categoryId);
        
        if (!$category) {
            $_SESSION['error'] = "Categorie niet gevonden";
            header("Location: index.php");
            exit;
        }
        
        // Haal de huidige pagina op uit de URL
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page); // Zorg ervoor dat de pagina minimaal 1 is
        $perPage = 10;
        
        // Haal posts op voor deze categorie
        $posts = $this->postModel->getPostsByCategory($categoryId, $page, $perPage);
        
        // Bereken paginering
        $totalPosts = count($posts); // Dit is niet optimaal, maar werkt voor nu
        $totalPages = ceil($totalPosts / $perPage);
        
        // Haal categorieën op voor de sidebar
        $categories = $this->categoryModel->getCategoriesWithPostCount();
        
        // Laad de categorie view
        include_once 'views/category.php';
    }
    
    /**
     * Toont het zoekresultatenoverzicht
     */
    public function showSearchResults() {
        $searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        if (empty($searchTerm)) {
            header("Location: index.php");
            exit;
        }
        
        // Haal de huidige pagina op uit de URL
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page); // Zorg ervoor dat de pagina minimaal 1 is
        $perPage = 10;
        
        // Haal zoekresultaten op
        $posts = $this->postModel->searchPosts($searchTerm, $page, $perPage);
        
        // Bereken paginering
        $totalPosts = count($posts); // Dit is niet optimaal, maar werkt voor nu
        $totalPages = ceil($totalPosts / $perPage);
        
        // Haal categorieën op voor de sidebar
        $categories = $this->categoryModel->getCategoriesWithPostCount();
        
        // Laad de zoekresultaten view
        include_once 'views/search.php';
    }
    
    /**
     * Toont het formulier voor het aanmaken van een nieuwe post (alleen voor ingelogde gebruikers)
     */
    public function showCreatePostForm($authController) {
        // Controleer of gebruiker is ingelogd
        $authController->requireLogin();
        
        // Haal categorieën op voor het dropdown menu
        $categories = $this->categoryModel->getAllCategories();
        
        // Laad het create post formulier
        include_once 'views/create_post.php';
    }
    
    /**
     * Verwerkt het aanmaken van een nieuwe post
     */
    public function createPost($authController) {
        // Controleer of gebruiker is ingelogd
        $authController->requireLogin();
        
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $content = isset($_POST['content']) ? trim($_POST['content']) : '';
        $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
        $featuredImage = null;
        
        // Validatie
        $errors = [];
        
        if (empty($title)) {
            $errors[] = "Titel is verplicht";
        }
        
        if (empty($content)) {
            $errors[] = "Content is verplicht";
        }
        
        if ($categoryId <= 0 || !$this->categoryModel->getCategoryById($categoryId)) {
            $errors[] = "Selecteer een geldige categorie";
        }
        
        // Verwerk featured image upload
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            
            // Zorg ervoor dat de upload map bestaat
            if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Genereer unieke bestandsnaam
            $fileName = uniqid() . '_' . basename($_FILES['featured_image']['name']);
            $targetFile = $uploadDir . $fileName;
            
            // Controleer bestandstype
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $errors[] = "Alleen JPG, JPEG, PNG en GIF bestanden zijn toegestaan";
            } else {
                // Upload het bestand
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $targetFile)) {
                    $featuredImage = $targetFile;
                } else {
                    $errors[] = "Er is een fout opgetreden bij het uploaden van het bestand";
                }
            }
        }
        
        // Als er geen errors zijn, maak de post aan
        if (empty($errors)) {
            $currentUser = $authController->getCurrentUser();
            
            if ($this->postModel->createPost($title, $content, $currentUser['id'], $categoryId, $featuredImage)) {
                $_SESSION['success'] = "Post succesvol aangemaakt";
                header("Location: index.php");
                exit;
            } else {
                $errors[] = "Er is een fout opgetreden bij het aanmaken van de post";
            }
        }
        
        // Als er errors zijn, toon het formulier opnieuw met de errors
        $_SESSION['errors'] = $errors;
        
        // Haal categorieën op voor het dropdown menu
        $categories = $this->categoryModel->getAllCategories();
        
        // Laad het create post formulier opnieuw
        include_once 'views/create_post.php';
    }
    
    /**
     * Toont het formulier voor het bewerken van een post
     */
    public function showEditPostForm($id, $authController) {
        // Controleer of gebruiker is ingelogd
        $authController->requireLogin();
        
        // Haal de post op
        $post = $this->postModel->getPostById($id);
        
        if (!$post) {
            $_SESSION['error'] = "Post niet gevonden";
            header("Location: index.php");
            exit;
        }
        
        // Controleer of de huidige gebruiker de auteur is of een admin
        $currentUser = $authController->getCurrentUser();
        if ($post['author_id'] != $currentUser['id'] && !$authController->isAdmin()) {
            $_SESSION['error'] = "Je hebt geen toestemming om deze post te bewerken";
            header("Location: index.php");
            exit;
        }
        
        // Haal categorieën op voor het dropdown menu
        $categories = $this->categoryModel->getAllCategories();
        
        // Laad het edit post formulier
        include_once 'views/edit_post.php';
    }
    
    /**
     * Verwerkt het bewerken van een post
     */
    public function updatePost($id, $authController) {
        // Controleer of gebruiker is ingelogd
        $authController->requireLogin();
        
        // Haal de post op
        $post = $this->postModel->getPostById($id);
        
        if (!$post) {
            $_SESSION['error'] = "Post niet gevonden";
            header("Location: index.php");
            exit;
        }
        
        // Controleer of de huidige gebruiker de auteur is of een admin
        $currentUser = $authController->getCurrentUser();
        if ($post['author_id'] != $currentUser['id'] && !$authController->isAdmin()) {
            $_SESSION['error'] = "Je hebt geen toestemming om deze post te bewerken";
            header("Location: index.php");
            exit;
        }
        
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $content = isset($_POST['content']) ? trim($_POST['content']) : '';
        $categoryId = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
        $featuredImage = $post['featured_image']; // Behoud de huidige afbeelding standaard
        
        // Validatie
        $errors = [];
        
        if (empty($title)) {
            $errors[] = "Titel is verplicht";
        }
        
        if (empty($content)) {
            $errors[] = "Content is verplicht";
        }
        
        if ($categoryId <= 0 || !$this->categoryModel->getCategoryById($categoryId)) {
            $errors[] = "Selecteer een geldige categorie";
        }
        
        // Verwerk featured image upload als een nieuwe is geüpload
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            
            // Zorg ervoor dat de upload map bestaat
            if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Genereer unieke bestandsnaam
            $fileName = uniqid() . '_' . basename($_FILES['featured_image']['name']);
            $targetFile = $uploadDir . $fileName;
            
            // Controleer bestandstype
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $errors[] = "Alleen JPG, JPEG, PNG en GIF bestanden zijn toegestaan";
            } else {
                // Upload het bestand
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $targetFile)) {
                    // Verwijder de oude afbeelding als deze bestaat
                    if ($post['featured_image'] && file_exists($post['featured_image'])) {
                        @unlink($post['featured_image']);
                    }
                    $featuredImage = $targetFile;
                } else {
                    $errors[] = "Er is een fout opgetreden bij het uploaden van het bestand";
                }
            }
        }
        
        // Als er geen errors zijn, update de post
        if (empty($errors)) {
            if ($this->postModel->updatePost($id, $title, $content, $categoryId, $featuredImage)) {
                $_SESSION['success'] = "Post succesvol bijgewerkt";
                header("Location: post.php?id=$id");
                exit;
            } else {
                $errors[] = "Er is een fout opgetreden bij het bijwerken van de post";
            }
        }
        
        // Als er errors zijn, toon het formulier opnieuw met de errors
        $_SESSION['errors'] = $errors;
        
        // Haal categorieën op voor het dropdown menu
        $categories = $this->categoryModel->getAllCategories();
        
        // Laad het edit post formulier opnieuw
        include_once 'views/edit_post.php';
    }
    
    /**
     * Verwijdert een post (alleen voor auteur of admin)
     */
    public function deletePost($id, $authController) {
        // Controleer of gebruiker is ingelogd
        $authController->requireLogin();
        
        // Haal de post op
        $post = $this->postModel->getPostById($id);
        
        if (!$post) {
            $_SESSION['error'] = "Post niet gevonden";
            header("Location: index.php");
            exit;
        }
        
        // Controleer of de huidige gebruiker de auteur is of een admin
        $currentUser = $authController->getCurrentUser();
        if ($post['author_id'] != $currentUser['id'] && !$authController->isAdmin()) {
            $_SESSION['error'] = "Je hebt geen toestemming om deze post te verwijderen";
            header("Location: index.php");
            exit;
        }
        
        // Verwijder de afbeelding als deze bestaat
        if ($post['featured_image'] && file_exists($post['featured_image'])) {
            @unlink($post['featured_image']);
        }
        
        // Verwijder de post
        if ($this->postModel->deletePost($id)) {
            $_SESSION['success'] = "Post succesvol verwijderd";
        } else {
            $_SESSION['error'] = "Er is een fout opgetreden bij het verwijderen van de post";
        }
        
        header("Location: index.php");
        exit;
    }
} 