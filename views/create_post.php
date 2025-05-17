<?php
// Inclusief header met navigatie
require_once 'includes/header.php';
// Inclusief helper functies als die nog niet zijn geladen
require_once 'includes/functions.php';
?>

<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary mb-2">Nieuwe Blog Post</h1>
        <p class="text-gray-600">Deel je kennis en inzichten over Real Madrid.</p>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
        <!-- Tabs voor schrijven en preview -->
        <div class="flex border-b border-gray-200" x-data="{ activeTab: 'write' }">
            <button 
                @click="activeTab = 'write'" 
                :class="{ 'text-primary border-primary': activeTab === 'write', 'text-gray-500 hover:text-gray-700 border-transparent hover:border-gray-300': activeTab !== 'write' }"
                class="flex-1 py-4 px-6 text-center font-medium border-b-2 text-sm focus:outline-none transition duration-150 ease-in-out"
            >
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Schrijven
            </button>
            <button 
                @click="activeTab = 'guide'" 
                :class="{ 'text-primary border-primary': activeTab === 'guide', 'text-gray-500 hover:text-gray-700 border-transparent hover:border-gray-300': activeTab !== 'guide' }"
                class="flex-1 py-4 px-6 text-center font-medium border-b-2 text-sm focus:outline-none transition duration-150 ease-in-out"
            >
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Markdown Gids
            </button>
            <button 
                @click="activeTab = 'preview'" 
                :class="{ 'text-primary border-primary': activeTab === 'preview', 'text-gray-500 hover:text-gray-700 border-transparent hover:border-gray-300': activeTab !== 'preview' }"
                class="flex-1 py-4 px-6 text-center font-medium border-b-2 text-sm focus:outline-none transition duration-150 ease-in-out"
            >
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Voorbeeld
            </button>
        </div>

        <!-- Tab content -->
        <div x-data="{ content: '', title: '', previewTitle: '', previewContent: '', activeTab: 'write' }" x-init="$watch('content', value => previewContent = value); $watch('title', value => previewTitle = value);">
            <!-- Write tab -->
            <div x-show="activeTab === 'write'" class="p-6">
                <form action="create_post.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <!-- Titel -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titel</label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            x-model="title"
                            class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-primary focus:border-primary" 
                            required 
                            value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>"
                        >
                    </div>
                    
                    <!-- Categorie -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categorie</label>
                        <select id="category_id" name="category_id" class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-primary focus:border-primary" required>
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
                    
                    <!-- Toolbar -->
                    <div class="border border-gray-300 rounded-t-md bg-gray-50 p-2 flex flex-wrap gap-2">
                        <button type="button" @click="content += '# '" class="px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Kop 1">H1</button>
                        <button type="button" @click="content += '## '" class="px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Kop 2">H2</button>
                        <button type="button" @click="content += '### '" class="px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Kop 3">H3</button>
                        <button type="button" @click="content += '**Dikgedrukte tekst**'" class="px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Dikgedrukt">
                            <strong>B</strong>
                        </button>
                        <button type="button" @click="content += '*Cursieve tekst*'" class="px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Cursief">
                            <em>I</em>
                        </button>
                        <button type="button" @click="content += '\n\n> Blockquote tekst\n\n'" class="px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Citaat">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                        </button>
                        <button type="button" @click="content += '\n\n- Lijstitem 1\n- Lijstitem 2\n- Lijstitem 3\n\n'" class="px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Lijst">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                        </button>
                        <button type="button" @click="content += '\n\n1. Eerste item\n2. Tweede item\n3. Derde item\n\n'" class="px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Genummerde lijst">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </button>
                        <button type="button" @click="content += '[Link titel](https://www.url.com)'" class="px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Link">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </button>
                        <button type="button" @click="content += '![Afbeelding beschrijving](url-naar-afbeelding.jpg)'" class="px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Afbeelding">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                        <button type="button" @click="content += '\n\n```\ncode hier\n```\n\n'" class="px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" title="Code">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                        <textarea 
                            id="content" 
                            name="content" 
                            rows="16" 
                            x-model="content"
                            class="w-full border border-gray-300 rounded-b-md shadow-sm p-3 focus:ring-primary focus:border-primary font-mono"
                            required
                        ><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
                        <p class="text-xs text-gray-500 mt-1">Gebruik Markdown voor opmaak. Bekijk de Markdown Gids tab voor meer informatie.</p>
                    </div>
                    
                    <!-- Featured Image -->
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">Header afbeelding</label>
                        <div class="border border-gray-300 rounded-md p-4 bg-gray-50">
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col w-full h-32 border-2 border-dashed border-gray-300 rounded-lg hover:bg-gray-50 hover:border-primary-300 cursor-pointer">
                                    <div class="flex flex-col items-center justify-center pt-7">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="pt-1 text-sm text-gray-500">Sleep een afbeelding of klik om te bladeren</p>
                                    </div>
                                    <input type="file" id="featured_image" name="featured_image" class="opacity-0">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 text-center">Aanbevolen formaat: 1200 x 600 pixels (JPG, PNG of GIF)</p>
                        </div>
                    </div>
                    
                    <!-- Submit button -->
                    <div class="flex justify-end pt-4">
                        <a href="blog.php" class="mr-4 px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                            Annuleren
                        </a>
                        <button type="submit" class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-opacity-90 transition duration-150">
                            Publiceren
                        </button>
                    </div>
                </form>
            </div>

            <!-- Markdown Guide Tab -->
            <div x-show="activeTab === 'guide'" class="p-6">
                <div class="prose max-w-none">
                    <h2>Markdown Handleiding</h2>
                    <p>Markdown is een eenvoudige manier om je tekst op te maken. Hier zijn enkele basiselementen:</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3>Koppen</h3>
                            <pre><code># Kop niveau 1
## Kop niveau 2
### Kop niveau 3</code></pre>
                        
                            <h3>Tekst opmaak</h3>
                            <pre><code>*Cursieve tekst*
**Dikgedrukte tekst**
~~Doorgestreepte tekst~~</code></pre>
                        
                            <h3>Lijsten</h3>
                            <pre><code>- Item 1
- Item 2
  - Genest item

1. Eerste item
2. Tweede item</code></pre>
                        </div>
                        
                        <div>
                            <h3>Links</h3>
                            <pre><code>[Link tekst](https://www.voorbeeld.nl)
[Link met titel](https://www.voorbeeld.nl "Titel")</code></pre>
                        
                            <h3>Afbeeldingen</h3>
                            <pre><code>![Alt tekst](url-naar-afbeelding.jpg)</code></pre>
                        
                            <h3>Citaten</h3>
                            <pre><code>> Dit is een citaat
> Het kan meerdere regels bevatten</code></pre>
                        
                            <h3>Code</h3>
                            <pre><code>```
function voorbeeld() {
  return "code blok";
}
```

`inline code`</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Tab -->
            <div x-show="activeTab === 'preview'" class="p-6">
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h1 x-text="previewTitle || 'Voorbeeld van je post titel'" class="text-3xl font-bold text-gray-800"></h1>
                </div>
                <div class="prose prose-lg max-w-none" x-html="previewContent ? parseMarkdown(previewContent) : '<p class=\'text-gray-500 italic\'>Typ content in de Schrijven tab om een voorbeeld te zien...</p>'"></div>
            </div>
        </div>
    </div>
</div>

<!-- Voeg JavaScript toe om Markdown naar HTML te converteren -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('preview', () => ({
            async parseMarkdown(markdown) {
                // Stuur de markdown naar de server voor parsing
                try {
                    const response = await fetch('parse_markdown.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'content=' + encodeURIComponent(markdown)
                    });
                    
                    if (response.ok) {
                        return await response.text();
                    } else {
                        console.error('Error parsing markdown');
                        return '<p>Fout bij het verwerken van markdown.</p>';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    return '<p>Fout bij het verwerken van markdown.</p>';
                }
            }
        }));
    });

    // Eenvoudige client-side markdown parser als fallback
    function parseMarkdown(markdown) {
        if (!markdown) return '';
        
        // Eenvoudige parsing regels
        let html = markdown
            // Koppen
            .replace(/^### (.*$)/gim, '<h3>$1</h3>')
            .replace(/^## (.*$)/gim, '<h2>$1</h2>')
            .replace(/^# (.*$)/gim, '<h1>$1</h1>')
            
            // Dikgedrukt
            .replace(/\*\*(.*?)\*\*/gim, '<strong>$1</strong>')
            
            // Cursief
            .replace(/\*(.*?)\*/gim, '<em>$1</em>')
            
            // Links
            .replace(/\[(.*?)\]\((.*?)\)/gim, '<a href="$2">$1</a>')
            
            // Afbeeldingen
            .replace(/!\[(.*?)\]\((.*?)\)/gim, '<img alt="$1" src="$2">')
            
            // Lijstitems
            .replace(/^- (.*$)/gim, '<li>$1</li>')
            
            // Paragrafen
            .replace(/\n\n/gim, '</p><p>');
        
        return '<p>' + html + '</p>';
    }
</script>

<?php require_once 'includes/footer.php'; ?> 