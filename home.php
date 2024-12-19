<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Chef Cuisinier - Accueil</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a1a1a; 
            color: #fff;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            max-width: 1200px;
        }

        header {
            background-color: #252525;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            padding: 1rem 0;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo img {
            max-height: 50px;
        }

        .nav-links {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 20px;
        }

        .nav-links li a {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            transition: color 0.3s ease-in-out;
        }

        .nav-links li a:hover {
            color: #ffd700;
        }

        main {
            padding: 2rem;
            min-height: 70vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .hero {
            padding: 50px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero-content {
            max-width: 600px;
        }

        .hero h1 {
            font-size: 2.5rem;
            color: #ffd700;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 1.1rem;
            color: #ccc;
            margin-bottom: 30px;
        }

        .featured-menus {
            padding: 30px 0;
            text-align: center;
            width: 100%;
        }

        .featured-menus h2 {
            font-size: 2rem;
            color: #ffd700;
            margin-bottom: 20px;
        }

         .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
             max-width: 1200px;
            margin: 0 auto;
       }

        .menu-item {
            border: 1px solid rgba(255,215,0, 0.2);
            border-radius: 8px;
            overflow: hidden;
            background-color: rgba(255,255,255, 0.05);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s ease;
           }
        .menu-item:hover {
          transform: translateY(-2px);
        }
        .menu-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .menu-item-details {
            padding: 15px;
            text-align: left;
        }

        .menu-item-details h3 {
            margin-bottom: 5px;
            font-size: 1.2rem;
            color: #fff;
        }

        .menu-item-details p {
            margin-bottom: 10px;
            color: #ccc;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ffd700;
            color: #1a1a1a;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            font-weight: bold;
            position: relative;
            overflow: hidden;
            z-index: 1;
       }
        .button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
             height: 100%;
            background-color: rgba(255,215,0, 0.2);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
             z-index: -1;
        }
        .button:hover {
            background-color: #e6bc00;
            box-shadow: 0 3px 8px rgba(255, 215, 0, 0.5);
             transform: translateY(-2px);
        }
        .button:hover::before {
            transform: translateX(0);
        }
    </style>
</head>
<body>
    <!-- Header with Navbar -->
    <header>
        <nav>
            <div class="logo">
                <a href="index.html"><img src="images/chef-logo.png" alt="Chef Logo"></a>
            </div>
            <ul class="nav-links">
                <li><a href="menu.html">Menu</a></li>
                <li><a href="reservation.html">Réserver</a></li>
                <li><a href="login.html">Connexion</a></li>
                <li><a href="register.html">Inscription</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Découvrez une Expérience Gastronomique Unique</h1>
                <p>Plongez dans l'univers culinaire du Chef, où chaque plat raconte une histoire.</p>
                <a href="login.html" class="button">Connectez-vous</a>
            </div>
        </section>
        <section class="featured-menus">
            <h2>Aperçu de nos Menus</h2>
            <div class="menu-grid" id="menu-container">
                </div>
        </section>
    </main>
    <script>
         const menuContainer = document.getElementById('menu-container');
        const menuCategories = ['pizza', 'burger', 'pasta', 'steak', 'dessert', 'salad']; 
        const numImagesPerCategory = 2; 

      async function fetchMenus() {
            for (const category of menuCategories) {
                  for(let i = 1; i <= numImagesPerCategory; i++){
                       try {
                         const imageUrl = `https://foodish-api.com/images/${category}/${category}${i}.jpg`;
                           const response = await fetch(imageUrl);
                            if(response.ok) {
                                const menuItem = document.createElement('div');
                                menuItem.classList.add('menu-item');
                                menuItem.innerHTML = `
                                    <img src="${imageUrl}" alt="${category} ${i}">
                                    <div class="menu-item-details">
                                         <h3>Menu ${category} ${i}</h3>
                                          <p>Découvrez ce menu exceptionnel.</p>
                                     </div>
                                `;
                              menuContainer.appendChild(menuItem);
                             } else {
                               console.error(`Error fetching image for ${category} ${i}, status: ${response.status}`);
                                }
                        } catch (error) {
                            console.error(`Error fetching image for ${category} ${i}, error:`, error);
                        }
                    }
                }
        }
     fetchMenus();
    </script>
</body>
</html>
