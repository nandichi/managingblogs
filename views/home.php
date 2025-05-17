<?php
// Inclusief header met navigatie
require_once 'includes/header.php';
// Inclusief helper functies als die nog niet zijn geladen
require_once 'includes/functions.php';
?>

<!-- Hero sectie met eenvoudigere styling, meer gelijkend op de screenshots -->
<div class="relative bg-gradient-to-r from-gray-900 to-primary py-16 mb-12 rounded-xl overflow-hidden shadow-lg">
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-3xl">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Welkom bij Voetbal<span class="text-gold">Visie</span>
            </h1>
            <p class="text-xl text-gray-200 mb-8">
                Het ultieme platform voor het laatste nieuws, diepgaande analyses en exclusieve verhalen uit de voetbalwereld.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="blog.php" class="bg-primary text-white py-2 px-6 rounded-lg border border-white hover:bg-opacity-90 transition flex items-center">
                    Ontdek onze artikelen
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
                <a href="register.php" class="bg-transparent text-white py-2 px-6 rounded-lg border border-white hover:bg-white hover:bg-opacity-10 transition flex items-center">
                    Word lid
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Uitgelicht artikel sectie -->
<?php if (isset($featuredPost) && $featuredPost): ?>
<div class="mb-12">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-gold pb-2 inline-block">
        Uitgelicht artikel
    </h2>
    
    <div class="bg-white rounded-lg overflow-hidden shadow-md">
        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-2/3 relative">
                <img src="<?php echo getThumbnailUrl($featuredPost['featured_image']); ?>" alt="<?php echo e($featuredPost['title']); ?>" 
                     class="w-full h-auto object-cover">
                <div class="absolute top-0 left-0 bg-primary text-white py-1 px-3 m-4 text-sm">
                    <?php echo e($featuredPost['category_name']); ?>
                </div>
            </div>
            <div class="lg:w-1/3 p-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-3">
                    <a href="post.php?id=<?php echo $featuredPost['id']; ?>" class="hover:text-primary transition-colors">
                        <?php echo e($featuredPost['title']); ?>
                    </a>
                </h3>
                <p class="text-gray-600 mb-4"><?php echo createExcerpt($featuredPost['content'], 100); ?></p>
                
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-gray-200 rounded-full mr-2 overflow-hidden">
                        <img src="<?php echo getProfileImageUrl($featuredPost['author_profile_image'], $featuredPost['author_email']); ?>" alt="<?php echo e($featuredPost['author_name']); ?>" class="w-full h-full object-cover">
                    </div>
                    <span class="text-gray-600 text-sm"><?php echo e($featuredPost['author_name']); ?></span>
                    <span class="mx-2 text-gray-400">•</span>
                    <span class="text-gray-500 text-sm"><?php echo formatDate($featuredPost['created_at']); ?></span>
                </div>
                
                <a href="post.php?id=<?php echo $featuredPost['id']; ?>" class="text-primary hover:underline flex items-center text-sm font-medium">
                    Lees verder
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Content Grid met verbeterde layout -->
<div class="flex flex-col lg:flex-row lg:space-x-8">
    <!-- Main Content -->
    <div class="flex-1">
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800 border-b-2 border-gold pb-2 inline-block">
                    Recente artikelen
                </h2>
                <a href="blog.php" class="text-primary hover:text-gold flex items-center text-sm">
                    Alle artikelen
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            
            <?php if (isset($recentPosts) && !empty($recentPosts)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($recentPosts as $post): ?>
                        <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                            <a href="post.php?id=<?php echo $post['id']; ?>">
                                <img src="<?php echo getThumbnailUrl($post['featured_image']); ?>" alt="<?php echo e($post['title']); ?>" class="w-full h-48 object-cover">
                            </a>
                            <div class="p-4">
                                <span class="text-xs font-medium bg-gray-100 text-gray-800 py-1 px-2 rounded-full inline-block">
                                    <?php echo e($post['category_name']); ?>
                                </span>
                                <h3 class="text-xl font-bold mt-2 mb-2">
                                    <a href="post.php?id=<?php echo $post['id']; ?>" class="text-gray-800 hover:text-primary transition-colors">
                                        <?php echo e($post['title']); ?>
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-4"><?php echo createExcerpt($post['content'], 100); ?></p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <div class="w-6 h-6 bg-gray-200 rounded-full mr-2 overflow-hidden">
                                        <img src="<?php echo getProfileImageUrl($post['author_profile_image'], $post['author_email']); ?>" alt="<?php echo e($post['author_name']); ?>" class="w-full h-full object-cover">
                                    </div>
                                    <span><?php echo e($post['author_name']); ?></span>
                                    <span class="mx-2 text-gray-400">•</span>
                                    <span><?php echo formatDate($post['created_at']); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-gray-50 p-6 rounded-lg text-center border border-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-gray-600 mb-1">Geen recente artikelen gevonden.</p>
                    <p class="text-gray-500 text-sm">Er worden binnenkort nieuwe artikelen gepubliceerd.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Voetbal Nieuws en Updates sectie -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-gold pb-2 inline-block">
                Voetbal nieuws en updates
            </h2>
            
            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-2/3 mb-6 md:mb-0 md:pr-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Blijf op de hoogte van al het voetbalnieuws</h3>
                        <p class="text-gray-600 mb-6">
                            VoetbalVisie is dé plek voor voetbalfans om up-to-date te blijven met het laatste nieuws, 
                            diepgaande analyses, exclusieve interviews en wedstrijdverslagen uit binnen- en buitenland. 
                            Word lid van onze community om deel te nemen aan discussies, je mening te delen en geen enkel 
                            verhaal te missen over jouw favoriete clubs, spelers en competities!
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="register.php" class="bg-primary text-white py-2 px-6 rounded-lg hover:bg-opacity-90 transition">
                                Registreer nu
                            </a>
                            <a href="blog.php" class="border border-primary text-primary py-2 px-6 rounded-lg hover:bg-primary hover:text-white transition">
                                Bekijk alle artikelen
                            </a>
                        </div>
                    </div>
                    <div class="md:w-1/3 flex justify-center">
                        <img src="assets/images/soccer-ball.png" alt="Voetbal" class="h-32 object-contain">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Nieuwsbrief sectie -->
        <div class="mb-12">
            <div class="bg-primary rounded-lg shadow-md p-6 text-white">
                <h3 class="text-xl font-bold mb-4">Schrijf je in voor de nieuwsbrief</h3>
                <p class="text-gray-100 mb-4">Ontvang het laatste voetbalnieuws, speciale aanbiedingen en exclusieve content direct in je inbox.</p>
                <form action="#" method="post" class="flex flex-col sm:flex-row gap-3">
                    <input type="email" name="email" placeholder="Je e-mailadres" required 
                           class="flex-1 px-4 py-2 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-gold">
                    <button type="submit" class="bg-gold hover:bg-opacity-90 text-white font-bold px-6 py-2 rounded-lg transition-colors">
                        Inschrijven
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="lg:w-1/3">
        <?php include 'includes/sidebar.php'; ?>
    </div>
</div>

<style>
    .text-gold {
        color: #D4AF37;
    }
    
    .bg-gold {
        background-color: #D4AF37;
    }
    
    .border-gold {
        border-color: #D4AF37;
    }
</style>

<?php
// Inclusief footer
require_once 'includes/footer.php';
?> 