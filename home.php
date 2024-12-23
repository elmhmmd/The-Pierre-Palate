<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Pierre Palate - Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-bg': '#1a1a1a',
                        'gold': '#ffd700',
                        'gold-hover': '#e6bc00',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-dark-bg text-white min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-dark-bg/50 backdrop-blur-sm border-b border-white/10 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-gold text-xl font-bold">The Pierre Palate</h1>
            <div class="flex items-center gap-4">
                <a href="login.php" class="px-4 py-2 text-white hover:text-gold transition-colors duration-300">
                    Connexion
                </a>
                <a href="signup.php" class="px-4 py-2 bg-gold text-dark-bg font-bold rounded hover:bg-gold-hover transition-all duration-300">
                    Inscription
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative h-[80vh] flex items-center justify-center bg-[url('images/restaurant.jpg')] bg-cover bg-center">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Bienvenue à <span class="text-gold">The Pierre Palate</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto">
                Une expérience gastronomique unique au cœur de la ville
            </p>
            <a href="login.php" 
               class="inline-block px-8 py-3 bg-gold text-dark-bg font-bold rounded-lg hover:bg-gold-hover transition-all duration-300 transform hover:-translate-y-0.5">
                Réserver une table
            </a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6 bg-white/5 rounded-lg">
                <h3 class="text-gold text-xl font-bold mb-4">Menu Gastronomique</h3>
                <p class="text-gray-300">Des plats raffinés préparés avec les meilleurs ingrédients</p>
            </div>
            <div class="text-center p-6 bg-white/5 rounded-lg">
                <h3 class="text-gold text-xl font-bold mb-4">Chef Expérimenté</h3>
                <p class="text-gray-300">Une cuisine d'exception par notre chef étoilé</p>
            </div>
            <div class="text-center p-6 bg-white/5 rounded-lg">
                <h3 class="text-gold text-xl font-bold mb-4">Ambiance Unique</h3>
                <p class="text-gray-300">Un cadre élégant pour une expérience inoubliable</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark-bg/50 border-t border-white/10 py-8">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-gray-400">© 2024 The Pierre Palate. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>