<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Chef Cuisinier - Accueil</title>
    <style>
        /* Styles as per the previously used theme with modifications */
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
       .menu-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .menu-card {
            width: 280px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
        }
         .menu-card img {
             width: 100%;
            height: 200px;
            object-fit: cover;
             display: block;
             margin-bottom: 10px;
         }
        .menu-card h3{
            color: #ffd700;
            margin-bottom: 10px;
            font-size: 1.3rem;
        }
         .menu-card p{
             margin-bottom: 15px;
             font-size: 1rem;
         }
          .menu-card .button{
            display: inline-block;
              padding: 10px 15px;
              text-decoration: none;
            font-size: 1rem;
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
            <div class="menu-container" id="menu-container">
            <!-- Menu cards as in User Dashboard -->
                  <div class="menu-card">
                      <img src="https://foodish-api.com/images/pizza/pizza1.jpg" alt="Menu Dégustation Prestige">
                      <h3>Menu Dégustation Prestige</h3>
                      <p>Une expérience culinaire inoubliable avec des plats raffinés.</p>
                       <p>Prix: 150€</p>
                      <a href="reservation.html" class="button">Réserver</a>
                 </div>
                 <div class="menu-card">
                      <img src="https://foodish-api.com/images/burger/burger2.jpg" alt="Menu Gastronomique Signature">
                      <h3>Menu Gastronomique Signature</h3>
                       <p>Explorez les saveurs uniques de nos spécialités.</p>
                       <p>Prix: 120€</p>
                       <a href="reservation.html" class="button">Réserver</a>
                  </div>
                <div class="menu-card">
                    <img src="https://foodish-api.com/images/pasta/pasta3.jpg" alt="Menu Découverte Saisonnière">
                    <h3>Menu Découverte Saisonnière</h3>
                      <p>Savourez des ingrédients frais de saison avec créativité.</p>
                        <p>Prix: 90€</p>
                    <a href="reservation.html" class="button">Réserver</a>
               </div>
            </div>
        </section>
    </main>
</body>
</html>
