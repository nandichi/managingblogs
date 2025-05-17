<?php 
/**
 * Profielpagina view
 */
require_once 'includes/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-primary mb-8">Mijn profiel</h1>
        
        <?php if (!empty($success)): ?>
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm text-green-700">
                            <?php foreach ($success as $message): ?>
                                <p><?php echo $message; ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm text-red-700">
                            <?php foreach ($errors as $error): ?>
                                <p><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Profiel informatie -->
            <div class="md:col-span-2">
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Profiel informatie</h2>
                    
                    <form action="profile.php" method="POST">
                        <div class="mb-4">
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Gebruikersnaam</label>
                            <input type="text" id="username" name="username" value="<?php echo e($userDetails['username']); ?>" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mailadres</label>
                            <input type="email" id="email" name="email" value="<?php echo e($userDetails['email']); ?>" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lid sinds</label>
                            <div class="text-gray-600"><?php echo date('d-m-Y', strtotime($userDetails['created_at'])); ?></div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" name="update_profile" class="btn-primary px-6 py-2.5 rounded-md">
                                Profiel bijwerken
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Wachtwoord wijzigen</h2>
                    
                    <form action="profile.php" method="POST">
                        <div class="mb-4">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Huidig wachtwoord</label>
                            <input type="password" id="current_password" name="current_password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div class="mb-4">
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Nieuw wachtwoord</label>
                            <input type="password" id="new_password" name="new_password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                            <p class="text-sm text-gray-500 mt-1">Wachtwoord moet minimaal 8 tekens bevatten</p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Bevestig nieuw wachtwoord</label>
                            <input type="password" id="confirm_password" name="confirm_password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" name="change_password" class="btn-primary px-6 py-2.5 rounded-md">
                                Wachtwoord wijzigen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="md:col-span-1">
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-primary mb-4">
                            <?php if (isset($_SESSION['profile_image']) && file_exists($_SESSION['profile_image'])): ?>
                                <img src="<?php echo $_SESSION['profile_image']; ?>?v=<?php echo time(); ?>" alt="Profiel foto" class="w-full h-full object-cover">
                            <?php elseif (!empty($userDetails['profile_image']) && file_exists($userDetails['profile_image'])): ?>
                                <img src="<?php echo $userDetails['profile_image']; ?>?v=<?php echo time(); ?>" alt="Profiel foto" class="w-full h-full object-cover">
                            <?php else: ?>
                                <img src="<?php echo getGravatarUrl($userDetails['email'], 150); ?>" alt="Profiel foto" class="w-full h-full object-cover">
                            <?php endif; ?>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800"><?php echo e($userDetails['username']); ?></h3>
                        <p class="text-sm text-gray-500 mb-4"><?php echo e($userDetails['email']); ?></p>
                        
                        <?php if ($userDetails['is_admin']): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary text-white">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Administrator
                            </span>
                        <?php endif; ?>
                        
                        <form action="profile.php" method="POST" enctype="multipart/form-data" class="mt-4 w-full">
                            <div class="flex flex-col items-center">
                                <label for="profile_image" class="btn-primary px-4 py-2 rounded-md text-sm cursor-pointer mb-2">
                                    Profielfoto wijzigen
                                </label>
                                <input type="file" id="profile_image" name="profile_image" accept="image/*" class="hidden" onchange="showSelectedFile()">
                                <p id="selected_file" class="text-xs text-gray-500 text-center">Klik om een nieuwe foto te uploaden</p>
                                <button type="submit" name="upload_profile_image" class="mt-3 btn-primary px-4 py-1 rounded-md text-xs">
                                    Uploaden
                                </button>
                            </div>
                        </form>
                        <script>
                            function showSelectedFile() {
                                const fileInput = document.getElementById('profile_image');
                                const fileNameDisplay = document.getElementById('selected_file');
                                
                                if (fileInput.files.length > 0) {
                                    fileNameDisplay.textContent = 'Geselecteerd: ' + fileInput.files[0].name;
                                } else {
                                    fileNameDisplay.textContent = 'Klik om een nieuwe foto te uploaden';
                                }
                            }
                        </script>
                    </div>
                </div>
                
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Accountopties</h3>
                    
                    <ul class="space-y-2">
                        <?php if ($userDetails['is_admin']): ?>
                            <li>
                                <a href="admin/index.php" class="flex items-center text-primary hover:underline">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Admin dashboard
                                </a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <a href="create_post.php" class="flex items-center text-primary hover:underline">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Nieuw bericht schrijven
                            </a>
                        </li>
                        <li>
                            <a href="logout.php" class="flex items-center text-red-600 hover:underline">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Uitloggen
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 