<?php
// Inclusief header met navigatie
require_once 'includes/header.php';
// Inclusief helper functies als die nog niet zijn geladen
require_once 'includes/functions.php';
?>

<!-- Hero sectie met professionele styling en verbeterd ontwerp -->
<div class="relative bg-gradient-to-r from-gray-900 to-primary py-12 sm:py-16 md:py-20 mb-8 sm:mb-12 rounded-xl overflow-hidden shadow-2xl">
    <!-- Decoratieve elementen -->
    <div class="absolute inset-0 overflow-hidden opacity-20">
        <div class="absolute left-0 top-0 w-full h-full bg-repeat opacity-10" style="background-image: url('assets/images/pattern.png');"></div>
        <div class="absolute -right-24 -top-24 w-96 h-96 bg-gold rounded-full mix-blend-overlay blur-3xl opacity-20"></div>
        <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-primary rounded-full mix-blend-overlay blur-3xl opacity-30"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 relative z-10">
        <div class="max-w-3xl">
            <span class="inline-block text-gold text-sm md:text-base font-semibold mb-3 bg-gray-900 bg-opacity-50 py-1 px-3 rounded-full backdrop-blur-sm">Het beste platform voor vlaggenliefhebbers van Nederland</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-3 sm:mb-4 leading-tight">
                Welkom bij Vlag<span class="text-gold relative">lijn
                    <span class="absolute -bottom-1.5 left-0 h-1 bg-gold w-full rounded-full opacity-70"></span>
                </span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-200 mb-6 sm:mb-8 max-w-2xl leading-relaxed">
                Het ultieme platform voor het laatste nieuws, diepgaande analyses en exclusieve verhalen over vlaggen.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="blog.php" class="group bg-gold text-gray-900 py-2.5 sm:py-3 px-6 sm:px-8 rounded-lg hover:bg-yellow-500 hover:scale-105 shadow-lg transition-all duration-300 flex items-center justify-center sm:justify-start font-semibold">
                    Ontdek onze artikelen
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
                <a href="register.php" class="bg-transparent text-white py-2.5 sm:py-3 px-6 sm:px-8 rounded-lg border border-white hover:bg-white hover:bg-opacity-10 hover:scale-105 shadow-lg transition-all duration-300 flex items-center justify-center sm:justify-start font-semibold backdrop-blur-sm">
                    Word lid
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Decoratieve golven onderaan -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 70" fill="none" preserveAspectRatio="none" class="w-full h-8 sm:h-10 text-white/10">
            <path fill="currentColor" d="M0,224L80,213.3C160,203,320,181,480,181.3C640,181,800,203,960,197.3C1120,192,1280,160,1360,144L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
        </svg>
    </div>
</div>

<!-- Uitgelicht artikel sectie - volledig responsief -->
<?php if (isset($featuredPost) && $featuredPost): ?>
<div class="mb-8 sm:mb-12 md:mb-16">
    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6 border-b-2 border-gold pb-2 inline-block">
        Uitgelicht artikel<span class="text-gold">.</span>
    </h2>
    
    <!-- Mobiele weergave (tot md) -->
    <div class="md:hidden bg-white rounded-xl overflow-hidden shadow-lg">
        <!-- Categorie badge -->
        <div class="relative">
            <div class="absolute top-3 left-3 z-10">
                <span class="bg-gold text-white px-3 py-1 rounded-full text-xs font-medium shadow-md">
                    <?php echo e($featuredPost['category_name']); ?>
                </span>
            </div>
            
            <!-- Afbeelding -->
            <div class="w-full h-48 sm:h-64">
                <img src="<?php echo getThumbnailUrl($featuredPost['featured_image']); ?>" 
                     alt="<?php echo e($featuredPost['title']); ?>" 
                     class="w-full h-full object-cover">
            </div>
        </div>
        
        <!-- Content -->
        <div class="p-4">
            <h3 class="text-lg sm:text-xl font-bold mb-2 leading-tight">
                <?php echo e($featuredPost['title']); ?>
            </h3>
            
            <p class="text-gray-600 mb-4 text-sm sm:text-base line-clamp-4">
                <?php echo createExcerpt(filterMarkdown($featuredPost['content']), 220); ?>
            </p>
            
            <!-- Auteur info -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-100 border border-gray-200">
                        <img src="<?php echo getProfileImageUrl($featuredPost['author_profile_image'], $featuredPost['author_email']); ?>" 
                             alt="<?php echo e($featuredPost['author_name']); ?>" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="ml-2">
                        <span class="block font-medium text-xs sm:text-sm"><?php echo e($featuredPost['author_name']); ?></span>
                        <span class="text-xs text-gray-500"><?php echo formatDate($featuredPost['created_at']); ?></span>
                    </div>
                </div>
                
                <span class="flex items-center text-xs text-gray-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <?php echo formatReadingTime($featuredPost['content']); ?> min
                </span>
            </div>
            
            <!-- Lees meer knop -->
            <a href="post.php?id=<?php echo $featuredPost['id']; ?>" 
               class="block w-full bg-gold hover:bg-yellow-600 text-white text-center py-2 rounded-lg text-sm font-medium transition-colors">
                Lees meer
            </a>
        </div>
    </div>
    
    <!-- Desktop weergave (md en groter) -->
    <div class="hidden md:block">
        <div class="bg-white rounded-xl overflow-hidden shadow-lg">
            <div class="md:flex">
                <!-- Afbeelding links -->
                <div class="md:w-1/2 lg:w-3/5 relative">
                    <!-- Categorie badge -->
                    <div class="absolute top-4 left-4 z-10">
                        <span class="bg-gold text-white px-4 py-1.5 rounded-full text-sm font-medium shadow-md">
                            <?php echo e($featuredPost['category_name']); ?>
                        </span>
                    </div>
                    
                    <div class="h-full">
                        <img src="<?php echo getThumbnailUrl($featuredPost['featured_image']); ?>" 
                             alt="<?php echo e($featuredPost['title']); ?>" 
                             class="w-full h-full object-cover" style="min-height: 400px;">
                    </div>
                </div>
                
                <!-- Content rechts -->
                <div class="md:w-1/2 lg:w-2/5 p-6 lg:p-8 flex flex-col justify-between">
                    <div>
                        <h3 class="text-2xl lg:text-3xl font-bold mb-4 leading-tight text-gray-800">
                            <?php echo e($featuredPost['title']); ?>
                        </h3>
                        
                        <p class="text-gray-600 mb-6 text-base lg:text-lg line-clamp-6">
                            <?php echo createExcerpt(filterMarkdown($featuredPost['content']), 350); ?>
                        </p>
                    </div>
                    
                    <div class="mt-auto">
                        <!-- Metadata -->
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                            <span class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <?php echo formatReadingTime($featuredPost['content']); ?> min leestijd
                            </span>
                            
                            <span class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <?php echo formatDate($featuredPost['created_at']); ?>
                            </span>
                        </div>
                        
                        <!-- Auteur info -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 border-2 border-gold shadow-md">
                                    <img src="<?php echo getProfileImageUrl($featuredPost['author_profile_image'], $featuredPost['author_email']); ?>" 
                                         alt="<?php echo e($featuredPost['author_name']); ?>" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="ml-3">
                                    <span class="block font-medium text-sm"><?php echo e($featuredPost['author_name']); ?></span>
                                    <span class="text-xs text-gray-500">Auteur</span>
                                </div>
                            </div>
                            
                            <!-- Lees meer knop -->
                            <a href="post.php?id=<?php echo $featuredPost['id']; ?>" 
                               class="bg-gold hover:bg-yellow-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition-colors flex items-center group">
                                Lees meer
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Content Grid met verbeterde layout -->
<div class="flex flex-col lg:flex-row lg:space-x-8">
    <!-- Main Content -->
    <div class="flex-1">
        <div class="mb-8 sm:mb-12">
            <div class="flex items-center justify-between mb-4 sm:mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 border-b-2 border-gold pb-2 inline-block">
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
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <?php foreach ($recentPosts as $post): ?>
                        <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                            <a href="post.php?id=<?php echo $post['id']; ?>">
                                <img src="<?php echo getThumbnailUrl($post['featured_image']); ?>" alt="<?php echo e($post['title']); ?>" class="w-full h-40 sm:h-48 object-cover">
                            </a>
                            <div class="p-3 sm:p-4">
                                <span class="text-xs font-medium bg-gray-100 text-gray-800 py-1 px-2 rounded-full inline-block">
                                    <?php echo e($post['category_name']); ?>
                                </span>
                                <h3 class="text-lg sm:text-xl font-bold mt-2 mb-2">
                                    <a href="post.php?id=<?php echo $post['id']; ?>" class="text-gray-800 hover:text-primary transition-colors">
                                        <?php echo e($post['title']); ?>
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-4 text-sm sm:text-base"><?php echo createExcerpt(filterMarkdown($post['content']), 100); ?></p>
                                <div class="flex items-center text-xs sm:text-sm text-gray-500">
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
                <div class="bg-gray-50 p-4 sm:p-6 rounded-lg text-center border border-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 sm:h-12 w-10 sm:w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-gray-600 mb-1 text-sm sm:text-base">Geen recente artikelen gevonden.</p>
                    <p class="text-gray-500 text-xs sm:text-sm">Er worden binnenkort nieuwe artikelen gepubliceerd.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Vlaggen nieuws en updates sectie -->
        <div class="mb-8 sm:mb-12 md:mb-16">
            <div class="flex items-center mb-6 sm:mb-8">
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 border-b-2 border-gold pb-2">
                    Vlaggen nieuws en updates
                </h2>
                <div class="ml-4 w-2 h-2 rounded-full bg-gold"></div>
                <div class="h-px flex-grow bg-gradient-to-r from-gold to-transparent ml-2"></div>
            </div>
            
            <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl overflow-hidden shadow-xl border border-gray-100 relative">
                <div class="flex flex-col md:flex-row relative z-10 p-4 sm:p-6 md:p-8">
                    <div class="md:w-full">
                        <span class="inline-block bg-gold bg-opacity-10 text-primary text-xs sm:text-sm font-semibold px-3 sm:px-4 py-1 sm:py-1.5 rounded-full mb-4">Blijf op de hoogte</span>
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 mb-3 sm:mb-4 leading-tight">Volg het laatste vlaggennieuws</h3>
                        <p class="text-gray-600 mb-6 sm:mb-8 leading-relaxed text-sm sm:text-base">
                            Vlaglijn is dé plek voor vlagliefhebbers om up-to-date te blijven met het laatste nieuws, 
                            diepgaande analyses, exclusieve interviews en wedstrijdverslagen uit binnen- en buitenland. 
                            Word lid van onze community om deel te nemen aan discussies, je mening te delen en geen enkel 
                            verhaal te missen over jouw favoriete clubs, spelers en competities!
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="register.php" class="group bg-primary text-white py-2.5 sm:py-3 px-6 sm:px-8 rounded-lg hover:bg-opacity-90 hover:scale-105 shadow-lg transition-all duration-300 flex items-center justify-center sm:justify-start font-semibold">
                                <span>Registreer nu</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </a>
                            <a href="blog.php" class="group bg-transparent border-2 border-primary text-primary py-2.5 sm:py-3 px-6 sm:px-8 rounded-lg hover:bg-primary hover:text-white hover:scale-105 shadow-lg transition-all duration-300 flex items-center justify-center sm:justify-start font-semibold">
                                <span>Bekijk alle artikelen</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Nieuwsbrief sectie -->
        <div class="mb-8 sm:mb-12">
            <div class="bg-primary rounded-lg shadow-md p-4 sm:p-6 text-white">
                <h3 class="text-lg sm:text-xl font-bold mb-3 sm:mb-4">Schrijf je in voor de nieuwsbrief</h3>
                <p class="text-gray-100 mb-4 text-sm sm:text-base">Ontvang het laatste vlaggennieuws, speciale aanbiedingen en exclusieve content direct in je inbox.</p>
                <form action="#" method="post" class="flex flex-col sm:flex-row gap-3">
                    <input type="email" name="email" placeholder="Je e-mailadres" required 
                           class="flex-1 px-4 py-2 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-gold text-sm sm:text-base">
                    <button type="submit" class="bg-gold hover:bg-opacity-90 text-white font-bold px-6 py-2 rounded-lg transition-colors text-sm sm:text-base">
                        Inschrijven
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="lg:w-1/3 mt-8 lg:mt-0">
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
?> 