<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'chef') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Menu - Chef Dashboard</title>
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
    <nav class="bg-dark-bg/50 backdrop-blur-sm border-b border-white/10 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-gold text-xl font-bold">Créer un Nouveau Menu</h1>
            <a href="chef.php" class="px-4 py-2 bg-gold text-dark-bg font-bold rounded hover:bg-gold-hover transition-all duration-300">
                Retour au Dashboard
            </a>
        </div>
    </nav>

    <div class="w-[90%] max-w-3xl mx-auto py-8">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-6">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <div class="bg-white/5 p-6 rounded-lg shadow-xl">
            <form id="menuForm" action="add_menu.php" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gold mb-2">Titre du Menu</label>
                        <input type="text" name="title" required 
                               class="w-full px-4 py-2 bg-dark-bg border border-gold rounded text-white focus:outline-none focus:ring-2 focus:ring-gold/50">
                    </div>
                    <div>
                        <label class="block text-gold mb-2">Prix (€)</label>
                        <input type="number" name="price" step="0.01" required 
                               class="w-full px-4 py-2 bg-dark-bg border border-gold rounded text-white focus:outline-none focus:ring-2 focus:ring-gold/50">
                    </div>
                </div>
                
                <div>
                    <label class="block text-gold mb-2">Description</label>
                    <textarea name="description" required 
                              class="w-full px-4 py-2 bg-dark-bg border border-gold rounded text-white h-24 focus:outline-none focus:ring-2 focus:ring-gold/50"></textarea>
                </div>

                <div id="dishesContainer" class="space-y-4">
                    <h3 class="text-gold text-lg mb-4">Plats du Menu</h3>
                    <div class="dish-entry grid grid-cols-1 md:grid-cols-[1fr,auto] gap-4">
                        <input type="text" name="dishes[]" required placeholder="Nom du plat"
                               class="px-4 py-2 bg-dark-bg border border-gold rounded text-white focus:outline-none focus:ring-2 focus:ring-gold/50">
                        <button type="button" class="remove-dish px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 hidden">
                            Supprimer
                        </button>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="button" id="addDish" 
                            class="px-4 py-2 bg-gold text-dark-bg rounded hover:bg-gold-hover transition-all duration-300">
                        Ajouter un Plat
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition-all duration-300">
                        Créer le Menu
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dishesContainer = document.getElementById('dishesContainer');
            const addDishButton = document.getElementById('addDish');

            function updateRemoveButtons() {
                const removeButtons = dishesContainer.querySelectorAll('.remove-dish');
                removeButtons.forEach(button => {
                    button.classList.toggle('hidden', dishesContainer.children.length <= 2);
                });
            }

            addDishButton.addEventListener('click', function() {
                const newDish = document.createElement('div');
                newDish.className = 'dish-entry grid grid-cols-1 md:grid-cols-[1fr,auto] gap-4';
                newDish.innerHTML = `
                    <input type="text" name="dishes[]" required placeholder="Nom du plat"
                           class="px-4 py-2 bg-dark-bg border border-gold rounded text-white focus:outline-none focus:ring-2 focus:ring-gold/50">
                    <button type="button" class="remove-dish px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        Supprimer
                    </button>
                `;

                newDish.querySelector('.remove-dish').addEventListener('click', function() {
                    newDish.remove();
                    updateRemoveButtons();
                });

                dishesContainer.appendChild(newDish);
                updateRemoveButtons();
            });

            updateRemoveButtons();
        });
    </script>
</body>
</html>