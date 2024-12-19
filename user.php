<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a1a1a;
            color: #fff;
            min-height: 100vh;
        }

        .dashboard-container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

         h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #ffd700;
             font-size: 2rem;
        }
        h2 {
            color: #ffd700;
             margin-bottom: 20px;
             font-size: 1.5rem;
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

         .booking-container {
           margin-top: 30px;
         }
        .booking-table {
           width: 100%;
           border-collapse: collapse;
           margin-top: 20px;
         }
           .booking-table th,
          .booking-table td {
           padding: 12px 10px;
           text-align: left;
           border-bottom: 1px solid #ddd;
          }
         .booking-table th {
             color: #ffd700;
             font-size: 1.1rem;
         }
         .booking-table td {
           font-size: 1rem;
         }

         .no-bookings-message {
              margin-top: 20px;
           text-align: center;
          font-size: 1.1rem;
         }

        .button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #ffd700; /* Gold button */
            color: #1a1a1a;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
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
        box-shadow: 0 4px 10px rgba(255, 215, 0, 0.5);
          transform: translateY(-2px);
        }
       .button:hover::before {
           transform: translateX(0);
      }

    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Bienvenue, <?php echo $username; ?>!</h1> <!-- Placeholder for username -->

        <h2>Menus Disponibles</h2>
        <div class="menu-container">
            <!-- PHP Loop to generate menu cards -->
            <?php
            // to be replaced with actual data fetching from database
            $menus = [
                [
                    'title' => 'Menu Dégustation Prestige',
                    'description' => 'Une expérience culinaire inoubliable avec des plats raffinés.',
                    'price' => '150€',
                ],
                 [
                    'title' => 'Menu Gastronomique Signature',
                    'description' => 'Explorez les saveurs uniques de nos spécialités.',
                    'price' => '120€',
                ],
                  [
                    'title' => 'Menu Découverte Saisonnière',
                    'description' => 'Savourez des ingrédients frais de saison avec créativité.',
                    'price' => '90€',
                ]
            ];

            foreach ($menus as $menu) {
                echo '<div class="menu-card">';
                echo '<h3>' . htmlspecialchars($menu['title']) . '</h3>';
                echo '<p>' . htmlspecialchars($menu['description']) . '</p>';
                echo '<p>Prix: ' . htmlspecialchars($menu['price']) . '</p>';
                  echo '<a href="booking.html" class="button">Réserver</a>';
                echo '</div>';
            }
            ?>
        </div>

        <div class="booking-container">
            <h2>Vos Réservations</h2>
               <!-- PHP code to show booking data or no bookings message -->
            <?php
            // to be replaced with actual booking data fetching
            $bookings = [
                 [
                    'menu_title' => 'Menu Dégustation Prestige',
                    'date_time' => '2024-06-15 19:00',
                    'guests' => 2,
                     'status' => 'Confirmée'
                ],
                 [
                    'menu_title' => 'Menu Découverte Saisonnière',
                    'date_time' => '2024-07-02 20:00',
                    'guests' => 4,
                      'status' => 'En attente'
                ],
            ];
            if(empty($bookings)){
                echo '<p class="no-bookings-message">Vous n\'avez pas encore de réservations.</p>';
            } else {
                echo '<table class="booking-table">';
                echo '<thead><tr><th>Menu</th><th>Date et Heure</th><th>Nombre de Personnes</th><th>Statut</th></tr></thead>';
                echo '<tbody>';
                  foreach ($bookings as $booking) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($booking['menu_title']) . '</td>';
                    echo '<td>' . htmlspecialchars($booking['date_time']) . '</td>';
                     echo '<td>' . htmlspecialchars($booking['guests']) . '</td>';
                    echo '<td>' . htmlspecialchars($booking['status']) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
           }
            ?>
        </div>
    </div>
</body>
</html>
