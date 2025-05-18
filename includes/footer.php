</main><!-- Sluit de main tag die in header.php is geopend -->

    <!-- Footer -->
    <footer class="bg-primary text-white mt-12 py-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Logo en korte info -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">Vlag<span class="gold-accent">lijn</span></h2>
                    <p class="text-gray-300 mb-4">
                        Het laatste nieuws, analyses en verhalen over vlaggen. 
                        Een gemeenschap voor vlagliefhebbers.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-white hover:text-gray-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-white hover:text-gray-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-white hover:text-gray-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Snelle links -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Snelle links</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-300 hover:text-white">Home</a></li>
                        <li><a href="blog.php" class="text-gray-300 hover:text-white">Blog</a></li>
                        <li><a href="about.php" class="text-gray-300 hover:text-white">Over ons</a></li>
                        <li><a href="register.php" class="text-gray-300 hover:text-white">Registreren</a></li>
                        <li><a href="login.php" class="text-gray-300 hover:text-white">Inloggen</a></li>
                        <li><a href="contact.php" class="text-gray-300 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Nieuwsbrief -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Nieuwsbrief</h3>
                    <p class="text-gray-300 mb-4">
                        Schrijf je in voor onze nieuwsbrief om op de hoogte te blijven van het laatste nieuws en speciale artikelen.
                    </p>
                    <form action="#" method="POST" class="space-y-2">
                        <div>
                            <input type="email" name="email" placeholder="Je e-mailadres" required 
                                class="w-full px-4 py-2 rounded-md bg-white bg-opacity-20 text-white placeholder-gray-300 border border-transparent focus:outline-none focus:border-gray-300">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-gold-accent text-primary font-medium rounded-md hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold-accent" style="background-color: #cdad00;">
                            Inschrijven
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-10 pt-6 text-center text-gray-400">
                <p>&copy; <?php echo date('Y'); ?> Vlaglijn. Alle rechten voorbehouden.</p>
                <p class="mt-2">
                    <a href="privacy.php" class="hover:text-white">Privacybeleid</a> | 
                    <a href="terms.php" class="hover:text-white">Gebruiksvoorwaarden</a>
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Alpine.js voor interactie -->
    <script>
        // Voor het geval Alpine.js vanuit CDN niet geladen is, een fallback
        if (typeof Alpine === 'undefined') {
            document.write('<script src="https://unpkg.com/alpinejs@3.9.0/dist/cdn.min.js"><\/script>');
        }
    </script>
</body>
</html> 