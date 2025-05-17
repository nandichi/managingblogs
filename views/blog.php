<?php
// Inclusief header met navigatie
require_once 'includes/header.php';
// Inclusief helper functies als die nog niet zijn geladen
require_once 'includes/functions.php';
?>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-primary mb-2">Blog</h1>
        <p class="text-gray-600">Ontdek de laatste artikelen en nieuws over Real Madrid.</p>
    </div>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="create_post.php" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Nieuwe Post
        </a>
    <?php endif; ?>
</div>

<!-- Content Grid -->
<div class="flex flex-col md:flex-row md:space-x-8">
    <!-- Main Content -->
    <div class="flex-1">
        <?php if (isset($posts) && !empty($posts)): ?>
            <div class="space-y-6">
                <?php foreach ($posts as $post): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col md:flex-row">
                        <a href="post.php?id=<?php echo $post['id']; ?>" class="md:w-1/3 flex-shrink-0">
                            <img src="<?php echo getThumbnailUrl($post['featured_image']); ?>" alt="<?php echo e($post['title']); ?>" class="w-full h-full object-cover">
                        </a>
                        <div class="p-6 md:w-2/3">
                            <div class="flex flex-wrap gap-2 mb-2">
                                <span class="text-xs font-medium bg-gray-100 text-gray-800 py-1 px-2 rounded-full">
                                    <?php echo e($post['category_name']); ?>
                                </span>
                                <span class="text-xs font-medium bg-gray-100 text-gray-500 py-1 px-2 rounded-full">
                                    <?php echo formatDate($post['created_at']); ?>
                                </span>
                            </div>
                            <h3 class="text-xl font-bold mb-3">
                                <a href="post.php?id=<?php echo $post['id']; ?>" class="text-gray-800 hover:text-primary">
                                    <?php echo e($post['title']); ?>
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-4"><?php echo createExcerpt($post['content'], 200); ?></p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Door <?php echo e($post['author_name']); ?></span>
                                <a href="post.php?id=<?php echo $post['id']; ?>" class="text-primary hover:text-opacity-80 font-medium flex items-center">
                                    Lees meer
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Paginering -->
            <?php 
            if (isset($totalPages) && $totalPages > 1) {
                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                echo generatePagination($currentPage, $totalPages, 'blog.php?page=%d');
            }
            ?>
            
        <?php else: ?>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="text-gray-600">Geen blog posts gevonden.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>
</div>

<?php
// Inclusief footer
require_once 'includes/footer.php';
?> 