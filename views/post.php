<?php
// Inclusief header met navigatie
require_once 'includes/header.php';
// Inclusief helper functies als die nog niet zijn geladen
require_once 'includes/functions.php';
?>

<!-- Content Grid -->
<div class="flex flex-col md:flex-row md:space-x-8">
    <!-- Main Content -->
    <div class="flex-1">
        <?php if (isset($post) && $post): ?>
            <!-- Post header -->
            <div class="mb-6">
                <div class="flex flex-wrap gap-2 mb-4">
                    <a href="category.php?id=<?php echo $post['category_id']; ?>" class="text-xs font-medium bg-primary text-white py-1 px-3 rounded-full">
                        <?php echo e($post['category_name']); ?>
                    </a>
                    <span class="text-xs font-medium bg-gray-100 text-gray-600 py-1 px-3 rounded-full">
                        <?php echo formatDate($post['created_at']); ?>
                    </span>
                </div>
                <div class="flex justify-between items-start">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4"><?php echo e($post['title']); ?></h1>
                    <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $post['author_id'] || (isset($_SESSION['is_admin']) && $_SESSION['is_admin']))): ?>
                        <div class="flex space-x-2">
                            <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-1 px-3 rounded-md flex items-center text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Bewerken
                            </a>
                            <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="bg-red-100 hover:bg-red-200 text-red-700 py-1 px-3 rounded-md flex items-center text-sm" onclick="return confirm('Weet je zeker dat je deze post wilt verwijderen?')">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Verwijderen
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="flex items-center text-gray-600">
                    <img src="<?php echo getProfileImageUrl($post['author_profile_image'], $post['author_email']); ?>" alt="<?php echo e($post['author_name']); ?>" class="w-10 h-10 rounded-full mr-3 object-cover">
                    <div>
                        <span class="font-medium"><?php echo e($post['author_name']); ?></span>
                        <span class="text-gray-500 text-sm block">Auteur</span>
                    </div>
                </div>
            </div>
            
            <!-- Featured image -->
            <?php if (isset($post['featured_image']) && $post['featured_image']): ?>
                <div class="mb-8">
                    <img src="<?php echo getThumbnailUrl($post['featured_image']); ?>" alt="<?php echo e($post['title']); ?>" class="w-full h-auto rounded-lg">
                </div>
            <?php endif; ?>
            
            <!-- Post content -->
            <div class="bg-white rounded-lg shadow-md p-6 md:p-8 mb-8">
                <div class="prose prose-lg max-w-none">
                    <?php echo parseMarkdown($post['content']); ?>
                </div>
            </div>
            
            <!-- Commentaarsectie -->
            <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
                <h3 class="text-xl font-bold text-primary mb-6">Reacties (<?php echo count($comments ?? []); ?>)</h3>
                
                <!-- Commentaarformulier voor ingelogde gebruikers -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="mb-8" x-data="{ commentText: '' }">
                        <form action="add_comment.php" method="POST" @submit="if(commentText.trim() === '') { $event.preventDefault(); alert('Je reactie mag niet leeg zijn'); }">
                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                            <input type="hidden" name="ajax" value="0">
                            <div class="mb-4">
                                <textarea name="content" x-model="commentText" class="w-full rounded-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 p-4" rows="4" placeholder="Plaats een reactie..."></textarea>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-md hover:bg-opacity-90 transition">
                                    Reactie plaatsen
                                </button>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="bg-gray-100 p-4 rounded-md mb-8">
                        <p class="text-gray-700">
                            <a href="login.php" class="text-primary font-medium">Log in</a> of 
                            <a href="register.php" class="text-primary font-medium">registreer</a> 
                            om een reactie te plaatsen.
                        </p>
                    </div>
                <?php endif; ?>
                
                <!-- Commentarenlijst -->
                <?php if (isset($comments) && !empty($comments)): ?>
                    <div class="space-y-6">
                        <?php foreach ($comments as $comment): ?>
                            <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0">
                                <div class="flex items-start mb-2">
                                    <img src="<?php echo getProfileImageUrl($comment['profile_image'], $comment['email']); ?>" alt="<?php echo e($comment['username']); ?>" class="w-10 h-10 rounded-full mr-3 object-cover">
                                    <div>
                                        <div class="flex items-center">
                                            <span class="font-medium"><?php echo e($comment['username']); ?></span>
                                            <span class="text-gray-500 text-sm ml-3"><?php echo formatDate($comment['created_at']); ?></span>
                                        </div>
                                        <p class="text-gray-700 mt-2"><?php echo nl2br(e($comment['content'])); ?></p>
                                        
                                        <!-- Bewerk/verwijder knoppen -->
                                        <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $comment['user_id'] || (isset($_SESSION['is_admin']) && $_SESSION['is_admin']))): ?>
                                            <div class="mt-2 space-x-2">
                                                <a href="edit_comment.php?id=<?php echo $comment['id']; ?>" class="text-sm text-primary hover:underline">Bewerken</a>
                                                <a href="delete_comment.php?id=<?php echo $comment['id']; ?>" class="text-sm text-red-600 hover:underline" onclick="return confirm('Weet je zeker dat je deze reactie wilt verwijderen?')">Verwijderen</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-gray-600">
                        <p>Er zijn nog geen reacties op dit artikel. Wees de eerste om te reageren!</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Related posts -->
            <?php if (isset($relatedPosts) && !empty($relatedPosts)): ?>
                <div class="mt-8">
                    <h3 class="text-xl font-bold text-primary mb-6">Gerelateerde artikelen</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($relatedPosts as $relPost): ?>
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                <a href="post.php?id=<?php echo $relPost['id']; ?>">
                                    <img src="<?php echo getThumbnailUrl($relPost['featured_image']); ?>" alt="<?php echo e($relPost['title']); ?>" class="w-full h-40 object-cover">
                                </a>
                                <div class="p-4">
                                    <h4 class="font-bold">
                                        <a href="post.php?id=<?php echo $relPost['id']; ?>" class="text-gray-800 hover:text-primary"><?php echo e($relPost['title']); ?></a>
                                    </h4>
                                    <div class="flex justify-between items-center mt-2 text-xs text-gray-500">
                                        <span><?php echo e($relPost['author_name']); ?></span>
                                        <span><?php echo formatDate($relPost['created_at']); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="text-gray-600">Post niet gevonden. <a href="blog.php" class="text-primary hover:underline">Terug naar het blog</a></p>
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