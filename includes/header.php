<?php
// Start een sessie als die nog niet bestaat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Controleer of we het User model moeten laden voor profielfoto's
if (isset($_SESSION['user_id']) && file_exists('models/User.php') && !class_exists('User')) {
    require_once 'models/User.php';
}

// Bepaal de huidige pagina
$currentPage = basename($_SERVER['PHP_SELF']);

// Bepaal de site titel
$pageTitle = 'VoetbalVisie';
switch ($currentPage) {
    case 'login.php':
        $pageTitle = 'Inloggen | VoetbalVisie';
        break;
    case 'register.php':
        $pageTitle = 'Registreren | VoetbalVisie';
        break;
    case 'blog.php':
        $pageTitle = 'Blog | VoetbalVisie';
        break;
    case 'post.php':
        if (isset($post['title'])) {
            $pageTitle = $post['title'] . ' | VoetbalVisie';
        } else {
            $pageTitle = 'Post | VoetbalVisie';
        }
        break;
    case 'category.php':
        if (isset($category['name'])) {
            $pageTitle = $category['name'] . ' | VoetbalVisie';
        } else {
            $pageTitle = 'Categorie | VoetbalVisie';
        }
        break;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <!-- Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <!-- Alpine.js via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        .logo {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .featured-post {
            height: 500px;
        }
        .post-card img {
            height: 200px;
            object-fit: cover;
        }
        .sidebar-card {
            border-left: 4px solid #132b52;
        }
        /* Verbeterde kleurenpalet gebaseerd op Real Madrid */
        :root {
            --primary: #132b52;
            --primary-dark: #0a1a33;
            --primary-light: #1d3e74;
            --gold: #e0b83d;
            --gold-light: #f7d36f;
            --gray-dark: #333333;
            --gray-light: #f8f9fa;
        }
        .btn-primary {
            background-color: var(--primary);
            color: white;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .text-primary {
            color: var(--primary);
        }
        .border-primary {
            border-color: var(--primary);
        }
        .bg-primary {
            background-color: var(--primary);
        }
        .gold-accent {
            color: var(--gold);
        }
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        .nav-link.active {
            font-weight: 600;
            color: var(--primary);
        }
        .search-input {
            transition: all 0.3s ease;
        }
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(19, 43, 82, 0.2);
            border-color: var(--primary);
        }
        .user-dropdown {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-radius: 0.5rem;
            border: 1px solid rgba(229, 231, 235, 1);
            overflow: hidden;
        }
        .user-dropdown a {
            transition: all 0.2s ease;
        }
        .user-dropdown a:hover {
            background-color: var(--gray-light);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header met logo en navigatie -->
    <header class="bg-white border-b border-gray-200" x-data="{ mobileMenuOpen: false }">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="index.php" class="logo text-3xl text-primary flex items-center">
                    <span class="mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 7a.5.5 0 110-1 .5.5 0 010 1zm0 11a.5.5 0 110-1 .5.5 0 010 1zm0-4.5a4 4 0 100-8 4 4 0 000 8z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.34 17A9 9 0 0121 9.36M14.74 19.5a9 9 0 01-11.16-9.64" />
                        </svg>
                    </span>
                    Voetbal<span class="gold-accent">Visie</span>
                </a>
                
                <!-- Mobiele menu knop -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden flex items-center focus:outline-none">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <!-- Desktop navigatie -->
                <nav class="hidden md:flex space-x-6 items-center">
                    <a href="index.php" class="nav-link py-2 text-gray-700 hover:text-primary <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>">Home</a>
                    <a href="blog.php" class="nav-link py-2 text-gray-700 hover:text-primary <?php echo $currentPage == 'blog.php' ? 'active' : ''; ?>">Blog</a>
                    <div class="relative" x-data="{ categoriesOpen: false }">
                        <button @click="categoriesOpen = !categoriesOpen" class="nav-link py-2 text-gray-700 hover:text-primary flex items-center">
                            Categorieën
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="categoriesOpen" @click.away="categoriesOpen = false" class="absolute z-10 bg-white shadow-lg rounded-md py-2 mt-2 w-48 user-dropdown">
                            <?php if (isset($categories) && !empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <a href="category.php?id=<?php echo $cat['id']; ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-primary">
                                        <?php echo e($cat['name']); ?> <span class="text-xs text-gray-500">(<?php echo $cat['post_count'] ?? 0; ?>)</span>
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="block px-4 py-2 text-gray-500 italic">Geen categorieën gevonden</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="about.php" class="nav-link py-2 text-gray-700 hover:text-primary <?php echo $currentPage == 'about.php' ? 'active' : ''; ?>">Over ons</a>
                    
                    <!-- Zoekbalk -->
                    <form action="search.php" method="GET" class="relative">
                        <input type="text" name="q" placeholder="Zoeken..." class="search-input border border-gray-300 rounded-full pl-4 pr-10 py-1.5 focus:outline-none text-sm">
                        <button type="submit" class="absolute right-0 top-0 h-full w-10 flex items-center justify-center text-gray-500 hover:text-primary transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                    
                    <!-- Authenticatie links -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="relative" x-data="{ userMenuOpen: false }">
                            <button @click="userMenuOpen = !userMenuOpen" class="flex items-center focus:outline-none group">
                                <span class="mr-2 text-gray-700 group-hover:text-primary transition"><?php echo $_SESSION['username']; ?></span>
                                <div class="w-9 h-9 rounded-full overflow-hidden border-2 border-gray-200 group-hover:border-primary transition">
                                    <?php 
                                    // Check voor profielfoto in sessie eerst (directe update)
                                    if(isset($_SESSION['profile_image']) && file_exists($_SESSION['profile_image'])): 
                                    ?>
                                        <img src="<?php echo $_SESSION['profile_image']; ?>?v=<?php echo time(); ?>" alt="Profile" class="w-full h-full object-cover">
                                    <?php 
                                    // Als niet in sessie, haal op uit database
                                    elseif(isset($db)):
                                        $currentUserId = $_SESSION['user_id'];
                                        $userModel = new User($db);
                                        $currentUserDetails = $userModel->getUserById($currentUserId);
                                        if(!empty($currentUserDetails['profile_image']) && file_exists($currentUserDetails['profile_image'])): 
                                            // Sla ook op in sessie voor toekomstig gebruik
                                            $_SESSION['profile_image'] = $currentUserDetails['profile_image'];
                                    ?>
                                        <img src="<?php echo $currentUserDetails['profile_image']; ?>?v=<?php echo time(); ?>" alt="Profile" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <img src="<?php echo getGravatarUrl($_SESSION['email'] ?? 'default@example.com'); ?>" alt="Profile" class="w-full h-full object-cover">
                                    <?php endif; else: ?>
                                        <img src="<?php echo getGravatarUrl($_SESSION['email'] ?? 'default@example.com'); ?>" alt="Profile" class="w-full h-full object-cover">
                                    <?php endif; ?>
                                </div>
                            </button>
                            <div x-show="userMenuOpen" @click.away="userMenuOpen = false" class="absolute right-0 z-10 mt-2 user-dropdown w-48">
                                <div class="py-2 px-4 bg-gray-50 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-primary truncate"><?php echo $_SESSION['username']; ?></p>
                                    <p class="text-xs text-gray-500 truncate"><?php echo $_SESSION['email'] ?? ''; ?></p>
                                </div>
                                <div class="py-1">
                                    <a href="profile.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Mijn profiel
                                    </a>
                                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                                        <a href="admin/index.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            Admin dashboard
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="border-t border-gray-100">
                                    <a href="logout.php" class="flex items-center px-4 py-2 text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Uitloggen
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center space-x-3">
                            <a href="login.php" class="nav-link py-2 text-gray-700 hover:text-primary <?php echo $currentPage == 'login.php' ? 'active' : ''; ?>">Inloggen</a>
                            <a href="register.php" class="btn-primary px-5 py-2 rounded-full text-sm font-medium hover:shadow-md transition-all">Registreren</a>
                        </div>
                    <?php endif; ?>
                </nav>
            </div>
            
            <!-- Mobiel menu -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-4"
                 class="md:hidden mt-4 pb-4">
                <nav class="border-t border-gray-100 pt-4">
                    <a href="index.php" class="block py-2.5 px-1 <?php echo $currentPage == 'index.php' ? 'font-semibold text-primary' : 'text-gray-600 hover:text-primary'; ?>">Home</a>
                    <a href="blog.php" class="block py-2.5 px-1 <?php echo $currentPage == 'blog.php' ? 'font-semibold text-primary' : 'text-gray-600 hover:text-primary'; ?>">Blog</a>
                    <div x-data="{ mobileCategoriesOpen: false }">
                        <button @click="mobileCategoriesOpen = !mobileCategoriesOpen" class="w-full flex justify-between items-center py-2.5 px-1 text-left text-gray-600 hover:text-primary">
                            <span>Categorieën</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobileCategoriesOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="pl-4 bg-gray-50 rounded-md py-2">
                            <?php if (isset($categories) && !empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <a href="category.php?id=<?php echo $cat['id']; ?>" class="block py-2 text-gray-600 hover:text-primary">
                                        <?php echo e($cat['name']); ?> <span class="text-xs text-gray-500">(<?php echo $cat['post_count'] ?? 0; ?>)</span>
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="block py-2 text-gray-500 italic">Geen categorieën gevonden</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="about.php" class="block py-2.5 px-1 <?php echo $currentPage == 'about.php' ? 'font-semibold text-primary' : 'text-gray-600 hover:text-primary'; ?>">Over ons</a>
                    
                    <!-- Mobiele zoekbalk -->
                    <form action="search.php" method="GET" class="mt-4">
                        <div class="relative">
                            <input type="text" name="q" placeholder="Zoeken..." class="search-input w-full border border-gray-300 rounded-lg pl-4 pr-10 py-2.5 focus:outline-none">
                            <button type="submit" class="absolute right-0 top-0 h-full w-12 flex items-center justify-center text-gray-500 hover:text-primary transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Mobiele authenticatie links -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <div class="flex items-center py-2">
                                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-200 mr-3">
                                    <?php 
                                    // Check voor profielfoto in sessie eerst (mobiele versie)
                                    if(isset($_SESSION['profile_image']) && file_exists($_SESSION['profile_image'])): 
                                    ?>
                                        <img src="<?php echo $_SESSION['profile_image']; ?>?v=<?php echo time(); ?>" alt="Profile" class="w-full h-full object-cover">
                                    <?php 
                                    // Als niet in sessie, haal op uit database
                                    elseif(isset($db)):
                                        $currentUserId = $_SESSION['user_id'];
                                        if(!isset($currentUserDetails)):
                                            $userModel = new User($db);
                                            $currentUserDetails = $userModel->getUserById($currentUserId);
                                        endif;
                                        
                                        if(isset($currentUserDetails) && !empty($currentUserDetails['profile_image']) && file_exists($currentUserDetails['profile_image'])): 
                                            // Sla ook op in sessie voor toekomstig gebruik
                                            $_SESSION['profile_image'] = $currentUserDetails['profile_image'];
                                    ?>
                                        <img src="<?php echo $currentUserDetails['profile_image']; ?>?v=<?php echo time(); ?>" alt="Profile" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <img src="<?php echo getGravatarUrl($_SESSION['email'] ?? 'default@example.com'); ?>" alt="Profile" class="w-full h-full object-cover">
                                    <?php endif; else: ?>
                                        <img src="<?php echo getGravatarUrl($_SESSION['email'] ?? 'default@example.com'); ?>" alt="Profile" class="w-full h-full object-cover">
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800"><?php echo $_SESSION['username']; ?></p>
                                    <p class="text-xs text-gray-500"><?php echo $_SESSION['email'] ?? ''; ?></p>
                                </div>
                            </div>
                            <a href="profile.php" class="flex items-center py-2.5 px-1 text-gray-600 hover:text-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Mijn profiel
                            </a>
                            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                                <a href="admin/index.php" class="flex items-center py-2.5 px-1 text-gray-600 hover:text-primary">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Admin dashboard
                                </a>
                            <?php endif; ?>
                            <a href="logout.php" class="flex items-center py-2.5 px-1 text-red-600 hover:text-red-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Uitloggen
                            </a>
                        <?php else: ?>
                            <div class="space-y-3 py-2">
                                <a href="login.php" class="block py-2.5 px-4 rounded-lg border border-gray-300 text-center text-gray-700 hover:text-primary hover:border-primary transition">
                                    Inloggen
                                </a>
                                <a href="register.php" class="block py-2.5 px-4 rounded-lg text-center btn-primary">
                                    Registreren
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    
    <!-- Flash berichten -->
    <div class="container mx-auto px-4 mt-6">
        <?php showFlashMessage(); ?>
    </div>
    
    <!-- Main content container -->
    <main class="container mx-auto px-4 py-6"><?php // Main content komt hier, sluit deze tag in footer.php ?> 