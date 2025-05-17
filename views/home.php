<?php
// Inclusief header met navigatie
require_once 'includes/header.php';
// Inclusief helper functies als die nog niet zijn geladen
require_once 'includes/functions.php';
?>

<div class="mb-8">
    <h1 class="text-3xl font-bold text-primary mb-2">Welkom bij Managing<span class="gold-accent">Blogs</span></h1>
    <p class="text-gray-600">Het laatste nieuws, analyses en verhalen over Real Madrid.</p>
</div>

<?php if (isset($featuredPost) && $featuredPost): ?>
<!-- Featured post -->
<div class="relative mb-8 featured-post rounded-lg overflow-hidden shadow-xl">
    <img src="<?php echo getThumbnailUrl($featuredPost['featured_image']); ?>" alt="<?php echo e($featuredPost['title']); ?>" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
    <div class="absolute bottom-0 left-0 p-6 text-white">
        <span class="text-xs font-medium bg-primary py-1 px-2 rounded-full mb-2 inline-block">
            <?php echo e($featuredPost['category_name']); ?>
        </span>
        <h2 class="text-2xl md:text-3xl font-bold mb-2">
            <a href="post.php?id=<?php echo $featuredPost['id']; ?>" class="hover:text-gold-accent">
                <?php echo e($featuredPost['title']); ?>
            </a>
        </h2>
        <p class="text-gray-200 mb-4 hidden md:block"><?php echo createExcerpt($featuredPost['content'], 150); ?></p>
        <div class="flex items-center text-sm">
            <span>Door <?php echo e($featuredPost['author_name']); ?></span>
            <span class="mx-2">•</span>
            <span><?php echo formatDate($featuredPost['created_at']); ?></span>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Content Grid -->
<div class="flex flex-col md:flex-row md:space-x-8">
    <!-- Main Content -->
    <div class="flex-1">
        <h2 class="text-2xl font-bold text-primary mb-6">Recente posts</h2>
        
        <?php if (isset($recentPosts) && !empty($recentPosts)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($recentPosts as $post): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden post-card">
                        <a href="post.php?id=<?php echo $post['id']; ?>">
                            <img src="<?php echo getThumbnailUrl($post['featured_image']); ?>" alt="<?php echo e($post['title']); ?>" class="w-full">
                        </a>
                        <div class="p-4">
                            <span class="text-xs font-medium bg-gray-100 text-gray-800 py-1 px-2 rounded-full inline-block">
                                <?php echo e($post['category_name']); ?>
                            </span>
                            <h3 class="text-xl font-bold mt-2 mb-2">
                                <a href="post.php?id=<?php echo $post['id']; ?>" class="text-gray-800 hover:text-primary">
                                    <?php echo e($post['title']); ?>
                                </a>
                            </h3>
                            <p class="text-gray-600 mb-4"><?php echo createExcerpt($post['content'], 100); ?></p>
                            <div class="flex justify-between items-center text-sm text-gray-500">
                                <span>Door <?php echo e($post['author_name']); ?></span>
                                <span><?php echo formatDate($post['created_at']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-8 text-center">
                <a href="blog.php" class="inline-block bg-primary text-white py-2 px-6 rounded-md hover:bg-opacity-90 transition">
                    Alle posts bekijken
                </a>
            </div>
        <?php else: ?>
            <div class="bg-gray-100 p-6 rounded-lg">
                <p class="text-gray-600">Geen recente posts gevonden.</p>
            </div>
        <?php endif; ?>
        
        <!-- Real Madrid nieuws en updates sectie -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-primary mb-6">Real Madrid nieuws en updates</h2>
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-gray-700 mb-4">
                    Managing<span class="gold-accent">Blogs</span> is de beste plek voor Real Madrid fans om op de hoogte te blijven van het laatste nieuws, wedstrijdverslagen, analyses en meer. Registreer nu om deel te nemen aan discussies, je mening te delen en geen enkel verhaal te missen!
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="register.php" class="bg-primary text-white py-2 px-6 rounded-md text-center hover:bg-opacity-90 transition">
                        Registreren
                    </a>
                    <a href="blog.php" class="border border-primary text-primary py-2 px-6 rounded-md text-center hover:bg-primary hover:text-white transition">
                        Blog bekijken
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <?php include 'includes/sidebar.php'; ?>
</div>

<?php
// Inclusief footer
require_once 'includes/footer.php';
?> 