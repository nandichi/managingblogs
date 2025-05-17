<?php
// Inclusief header met navigatie
require_once 'includes/header.php';
// Inclusief helper functies als die nog niet zijn geladen
require_once 'includes/functions.php';
?>

<!-- Hero sectie met professionele styling en verbeterd ontwerp -->
<div class="relative bg-gradient-to-r from-gray-900 to-primary py-20 mb-12 rounded-xl overflow-hidden shadow-2xl">
    <!-- Decoratieve elementen -->
    <div class="absolute inset-0 overflow-hidden opacity-20">
        <div class="absolute left-0 top-0 w-full h-full bg-repeat opacity-10" style="background-image: url('assets/images/pattern.png');"></div>
        <div class="absolute -right-24 -top-24 w-96 h-96 bg-gold rounded-full mix-blend-overlay blur-3xl opacity-20"></div>
        <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-primary rounded-full mix-blend-overlay blur-3xl opacity-30"></div>
    </div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-3xl">
            <span class="inline-block text-gold text-sm md:text-base font-semibold mb-3 bg-gray-900 bg-opacity-50 py-1 px-3 rounded-full backdrop-blur-sm">Het beste voetbalplatform van Nederland</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                Welkom bij Voetbal<span class="text-gold relative">Visie
                    <span class="absolute -bottom-1.5 left-0 h-1 bg-gold w-full rounded-full opacity-70"></span>
                </span>
            </h1>
            <p class="text-xl text-gray-200 mb-8 max-w-2xl leading-relaxed">
                Het ultieme platform voor het laatste nieuws, diepgaande analyses en exclusieve verhalen uit de voetbalwereld.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="blog.php" class="group bg-gold text-gray-900 py-3 px-8 rounded-lg hover:bg-yellow-500 hover:scale-105 shadow-lg transition-all duration-300 flex items-center font-semibold">
                    Ontdek onze artikelen
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
                <a href="register.php" class="bg-transparent text-white py-3 px-8 rounded-lg border border-white hover:bg-white hover:bg-opacity-10 hover:scale-105 shadow-lg transition-all duration-300 flex items-center font-semibold backdrop-blur-sm">
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
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 70" fill="none" preserveAspectRatio="none" class="w-full h-10 text-white/10">
            <path fill="currentColor" d="M0,224L80,213.3C160,203,320,181,480,181.3C640,181,800,203,960,197.3C1120,192,1280,160,1360,144L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
        </svg>
    </div>
</div>

<!-- Uitgelicht artikel sectie -->
<?php if (isset($featuredPost) && $featuredPost): ?>
<div class="mb-16">
    <div class="flex items-center mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 border-b-2 border-gold pb-2">
            Uitgelicht artikel
        </h2>
        <div class="ml-4 w-2 h-2 rounded-full bg-gold"></div>
        <div class="h-px flex-grow bg-gradient-to-r from-gold to-transparent ml-2"></div>
    </div>
    
    <div class="bg-white rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-100">
        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-2/3 relative group overflow-hidden">
                <img src="<?php echo getThumbnailUrl($featuredPost['featured_image']); ?>" alt="<?php echo e($featuredPost['title']); ?>" 
                     class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105" style="min-height: 350px;">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent opacity-60"></div>
                <div class="absolute top-0 left-0 m-6">
                    <span class="bg-gold text-gray-900 py-1.5 px-4 rounded-full text-sm font-semibold shadow-md">
                        <?php echo e($featuredPost['category_name']); ?>
                    </span>
                </div>
                <div class="absolute bottom-0 left-0 p-6 lg:hidden">
                    <h3 class="text-2xl font-bold text-white mb-2">
                        <?php echo e($featuredPost['title']); ?>
                    </h3>
                    <div class="flex items-center text-gray-200 mb-2">
                        <div class="w-8 h-8 bg-gray-200 rounded-full mr-2 overflow-hidden border-2 border-white">
                            <img src="<?php echo getProfileImageUrl($featuredPost['author_profile_image'], $featuredPost['author_email']); ?>" alt="<?php echo e($featuredPost['author_name']); ?>" class="w-full h-full object-cover">
                        </div>
                        <span class="text-sm mr-2"><?php echo e($featuredPost['author_name']); ?></span>
                        <span class="mx-2 text-gray-400">•</span>
                        <span class="text-sm"><?php echo formatDate($featuredPost['created_at']); ?></span>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/3 p-8 flex flex-col justify-between">
                <div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 leading-tight hidden lg:block">
                        <a href="post.php?id=<?php echo $featuredPost['id']; ?>" class="hover:text-primary transition-colors">
                            <?php echo e($featuredPost['title']); ?>
                        </a>
                    </h3>
                    <div class="flex items-center mb-4 hidden lg:flex">
                        <div class="w-10 h-10 bg-gray-200 rounded-full mr-3 overflow-hidden border-2 border-white shadow-sm">
                            <img src="<?php echo getProfileImageUrl($featuredPost['author_profile_image'], $featuredPost['author_email']); ?>" alt="<?php echo e($featuredPost['author_name']); ?>" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <span class="block text-gray-700 font-medium"><?php echo e($featuredPost['author_name']); ?></span>
                            <span class="block text-gray-500 text-sm"><?php echo formatDate($featuredPost['created_at']); ?></span>
                        </div>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-6"><?php echo createExcerpt($featuredPost['content'], 150); ?></p>
                </div>
                
                <a href="post.php?id=<?php echo $featuredPost['id']; ?>" class="group inline-flex items-center gap-2 text-gold font-semibold hover:text-primary transition-colors">
                    <span>Lees verder</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
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
        <div class="mb-16">
            <div class="flex items-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 border-b-2 border-gold pb-2">
                    Voetbal nieuws en updates
                </h2>
                <div class="ml-4 w-2 h-2 rounded-full bg-gold"></div>
                <div class="h-px flex-grow bg-gradient-to-r from-gold to-transparent ml-2"></div>
            </div>
            
            <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl overflow-hidden shadow-xl border border-gray-100 relative">
                <!-- Decoratieve elementen -->
                <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-primary rounded-full mix-blend-multiply opacity-5"></div>
                <div class="absolute -left-16 -top-16 w-64 h-64 bg-gold rounded-full mix-blend-multiply opacity-5"></div>
                
                <div class="flex flex-col md:flex-row relative z-10 p-8">
                    <div class="md:w-2/3 mb-8 md:mb-0 md:pr-10">
                        <span class="inline-block bg-gold bg-opacity-10 text-primary text-sm font-semibold px-4 py-1.5 rounded-full mb-4">Blijf op de hoogte</span>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 leading-tight">Volg het laatste voetbalnieuws</h3>
                        <p class="text-gray-600 mb-8 leading-relaxed">
                            VoetbalVisie is dé plek voor voetbalfans om up-to-date te blijven met het laatste nieuws, 
                            diepgaande analyses, exclusieve interviews en wedstrijdverslagen uit binnen- en buitenland. 
                            Word lid van onze community om deel te nemen aan discussies, je mening te delen en geen enkel 
                            verhaal te missen over jouw favoriete clubs, spelers en competities!
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="register.php" class="group bg-primary text-white py-3 px-8 rounded-lg hover:bg-opacity-90 hover:scale-105 shadow-lg transition-all duration-300 flex items-center font-semibold">
                                <span>Registreer nu</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </a>
                            <a href="blog.php" class="group bg-transparent border-2 border-primary text-primary py-3 px-8 rounded-lg hover:bg-primary hover:text-white hover:scale-105 shadow-lg transition-all duration-300 flex items-center font-semibold">
                                <span>Bekijk alle artikelen</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="md:w-1/3 flex items-center justify-center relative">
                        <div class="w-full h-full max-w-xs relative">
                            <div class="absolute inset-0 bg-gold rounded-full opacity-10 transform -translate-x-4 translate-y-4"></div>
                            <div class="absolute inset-0 bg-primary rounded-full opacity-10 transform translate-x-4 -translate-y-4"></div>
                            <div class="relative z-10 flex items-center justify-center">
                                <img src="assets/images/soccer-ball.png" alt="Voetbal" class="h-48 w-48 object-contain transform transition-transform hover:rotate-12 hover:scale-110 duration-500">
                            </div>
                        </div>
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