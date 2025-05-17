<?php
// Inclusief header met navigatie
require_once 'includes/header.php';
// Inclusief helper functies als die nog niet zijn geladen
require_once 'includes/functions.php';
?>

<div class="mb-8">
    <h1 class="text-3xl font-bold text-primary mb-2">Nieuwe Blog Post</h1>
    <p class="text-gray-600">Deel je kennis en inzichten over Real Madrid.</p>
</div>

<!-- Content -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form action="create_post.php" method="POST" enctype="multipart/form-data" class="space-y-6">
        <!-- Titel -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titel</label>
            <input type="text" id="title" name="title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
        </div>
        
        <!-- Categorie -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categorie</label>
            <select id="category_id" name="category_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                <option value="">Selecteer een categorie</option>
                <?php if (isset($categories) && !empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo (isset($_POST['category_id']) && $_POST['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                            <?php echo e($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        
        <!-- Content -->
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
            <textarea id="content" name="content" rows="12" class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
        </div>
        
        <!-- Featured Image -->
        <div>
            <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">Header afbeelding</label>
            <input type="file" id="featured_image" name="featured_image" class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3">
            <p class="text-xs text-gray-500 mt-1">Aanbevolen formaat: 1200 x 600 pixels (JPG, PNG of GIF)</p>
        </div>
        
        <!-- Submit button -->
        <div class="flex justify-end">
            <a href="blog.php" class="mr-4 px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Annuleren
            </a>
            <button type="submit" class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-opacity-90">
                Publiceren
            </button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?> 