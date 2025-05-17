<?php
// Start een sessie als die nog niet bestaat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Bepaal de huidige pagina
$currentPage = basename($_SERVER['PHP_SELF']);

// Bepaal de site titel
$pageTitle = 'Managing Blogs';
switch ($currentPage) {
    case 'login.php':
        $pageTitle = 'Inloggen | Managing Blogs';
        break;
    case 'register.php':
        $pageTitle = 'Registreren | Managing Blogs';
        break;
    case 'blog.php':
        $pageTitle = 'Blog | Managing Blogs';
        break;
    case 'post.php':
        if (isset($post['title'])) {
            $pageTitle = $post['title'] . ' | Managing Blogs';
        } else {
            $pageTitle = 'Post | Managing Blogs';
        }
        break;
    case 'category.php':
        if (isset($category['name'])) {
            $pageTitle = $category['name'] . ' | Managing Blogs';
        } else {
            $pageTitle = 'Categorie | Managing Blogs';
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Alpine.js via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .logo {
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
            border-left: 4px solid #1a365d;
        }
        /* Real Madrid kleuren */
        .btn-primary {
            background-color: #1a365d;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0f2240;
        }
        .text-primary {
            color: #1a365d;
        }
        .border-primary {
            border-color: #1a365d;
        }
        .bg-primary {
            background-color: #1a365d;
        }
        .gold-accent {
            color: #cdad00;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header met logo en navigatie -->
    <header class="bg-white shadow-md" x-data="{ mobileMenuOpen: false }">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="index.php" class="logo text-2xl text-primary">
                    Managing<span class="gold-accent">Blogs</span>
                </a>
                
                <!-- Mobiele menu knop -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden flex items-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <!-- Desktop navigatie -->
                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="index.php" class="<?php echo $currentPage == 'index.php' ? 'font-bold text-primary' : 'text-gray-600 hover:text-primary'; ?>">Home</a>
                    <a href="blog.php" class="<?php echo $currentPage == 'blog.php' ? 'font-bold text-primary' : 'text-gray-600 hover:text-primary'; ?>">Blog</a>
                    <div class="relative" x-data="{ categoriesOpen: false }">
                        <button @click="categoriesOpen = !categoriesOpen" class="text-gray-600 hover:text-primary flex items-center">
                            Categorieën
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="categoriesOpen" @click.away="categoriesOpen = false" class="absolute z-10 bg-white shadow-lg rounded-md py-2 mt-2 w-48">
                            <?php if (isset($categories) && !empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <a href="category.php?id=<?php echo $cat['id']; ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <?php echo e($cat['name']); ?> (<?php echo $cat['post_count'] ?? 0; ?>)
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="block px-4 py-2 text-gray-700">Geen categorieën gevonden</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="about.php" class="<?php echo $currentPage == 'about.php' ? 'font-bold text-primary' : 'text-gray-600 hover:text-primary'; ?>">Over ons</a>
                    
                    <!-- Zoekbalk -->
                    <form action="search.php" method="GET" class="relative">
                        <input type="text" name="q" placeholder="Zoeken..." class="border rounded-full pl-4 pr-10 py-1 focus:outline-none focus:border-primary text-sm">
                        <button type="submit" class="absolute right-0 top-0 h-full w-10 flex items-center justify-center text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                    
                    <!-- Authenticatie links -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="relative" x-data="{ userMenuOpen: false }">
                            <button @click="userMenuOpen = !userMenuOpen" class="flex items-center focus:outline-none">
                                <span class="mr-2 text-gray-700"><?php echo $_SESSION['username']; ?></span>
                                <img src="<?php echo getGravatarUrl($_SESSION['email'] ?? 'default@example.com'); ?>" alt="Profile" class="w-8 h-8 rounded-full">
                            </button>
                            <div x-show="userMenuOpen" @click.away="userMenuOpen = false" class="absolute right-0 z-10 mt-2 bg-white shadow-lg rounded-md overflow-hidden w-48">
                                <a href="profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Mijn profiel</a>
                                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                                    <a href="admin/index.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Admin dashboard</a>
                                <?php endif; ?>
                                <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Uitloggen</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="<?php echo $currentPage == 'login.php' ? 'font-bold text-primary' : 'text-gray-600 hover:text-primary'; ?>">Inloggen</a>
                        <a href="register.php" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-opacity-90 transition">Registreren</a>
                    <?php endif; ?>
                </nav>
            </div>
            
            <!-- Mobiel menu -->
            <nav x-show="mobileMenuOpen" class="md:hidden mt-4 pb-4">
                <a href="index.php" class="block py-2 <?php echo $currentPage == 'index.php' ? 'font-bold text-primary' : 'text-gray-600'; ?>">Home</a>
                <a href="blog.php" class="block py-2 <?php echo $currentPage == 'blog.php' ? 'font-bold text-primary' : 'text-gray-600'; ?>">Blog</a>
                <div x-data="{ mobileCategoriesOpen: false }">
                    <button @click="mobileCategoriesOpen = !mobileCategoriesOpen" class="w-full flex justify-between items-center py-2 text-gray-600">
                        <span>Categorieën</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="mobileCategoriesOpen" class="pl-4">
                        <?php if (isset($categories) && !empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <a href="category.php?id=<?php echo $cat['id']; ?>" class="block py-2 text-gray-600">
                                    <?php echo e($cat['name']); ?> (<?php echo $cat['post_count'] ?? 0; ?>)
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="block py-2 text-gray-600">Geen categorieën gevonden</span>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="about.php" class="block py-2 <?php echo $currentPage == 'about.php' ? 'font-bold text-primary' : 'text-gray-600'; ?>">Over ons</a>
                
                <!-- Mobiele zoekbalk -->
                <form action="search.php" method="GET" class="mt-2">
                    <div class="relative">
                        <input type="text" name="q" placeholder="Zoeken..." class="w-full border rounded-md pl-4 pr-10 py-2 focus:outline-none focus:border-primary">
                        <button type="submit" class="absolute right-0 top-0 h-full w-10 flex items-center justify-center text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
                
                <!-- Mobiele authenticatie links -->
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span class="block font-medium text-gray-700 mb-2">Ingelogd als <?php echo $_SESSION['username']; ?></span>
                        <a href="profile.php" class="block py-2 text-gray-600">Mijn profiel</a>
                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                            <a href="admin/index.php" class="block py-2 text-gray-600">Admin dashboard</a>
                        <?php endif; ?>
                        <a href="logout.php" class="block py-2 text-gray-600">Uitloggen</a>
                    <?php else: ?>
                        <a href="login.php" class="block py-2 <?php echo $currentPage == 'login.php' ? 'font-bold text-primary' : 'text-gray-600'; ?>">Inloggen</a>
                        <a href="register.php" class="block py-2 font-medium text-primary">Registreren</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>
    
    <!-- Flash berichten -->
    <div class="container mx-auto px-4 mt-6">
        <?php showFlashMessage(); ?>
    </div>
    
    <!-- Main content container -->
    <main class="container mx-auto px-4 py-6"><?php // Main content komt hier, sluit deze tag in footer.php ?> 