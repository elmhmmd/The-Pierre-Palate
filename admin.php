<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Chef</title>
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
          .overview-container {
            display: flex;
             flex-wrap: wrap;
           justify-content: space-around;
           gap: 20px;
            margin-bottom: 30px;
          }
          .stat-card {
             width: 220px;
           background-color: rgba(255, 255, 255, 0.05);
             border-radius: 10px;
            padding: 20px;
           box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
             text-align: center;
           transition: transform 0.3s ease, box-shadow 0.3s ease;
          }
          .stat-card:hover {
           transform: translateY(-5px);
           box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
          }
          .stat-card h3 {
            color: #fff;
             font-size: 1.2rem;
           margin-bottom: 10px;
          }
          .stat-card p {
               color: #ffd700;
               font-size: 1.5rem;
           font-weight: bold;
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
          .booking-table .button {
           font-size: 0.9rem;
           padding: 8px 12px;
          }
         .next-client-container {
            margin-top: 30px;
         }
         .next-client-card {
            width: 100%;
            max-width: 400px;
             background-color: rgba(255, 255, 255, 0.05);
           border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
              margin: 20px auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
         }
         .next-client-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
          }
          .next-client-card h3 {
            color: #ffd700;
              margin-bottom: 10px;
             font-size: 1.3rem;
           }
            .next-client-card p{
                font-size: 1rem;
             margin-bottom: 10px;
            }
         .no-bookings-message {
             margin-top: 20px;
            text-align: center;
           font-size: 1.1rem;
          }

        .button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #ffd700;
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
    <div class="dashboard-container">
         <h1>Tableau de Bord Chef</h1>
        <div class="overview-container">
            <div class="stat-card">
                <h3>Demandes en attente</h3>
                <p><?php echo $pending_requests; ?> </p> 
            </div>
             <div class="stat-card">
                <h3>Approuvées aujourd'hui</h3>
                  <p><?php echo $approved_today; ?></p>  
            </div>
            <div class="stat-card">
                <h3>Approuvées demain</h3>
                <p><?php echo $approved_tomorrow; ?></p>  
            </div>
            <div class="stat-card">
                <h3>Clients Inscrits</h3>
                <p><?php echo $registered_clients; ?></p>  
             </div>
        </div>
         <div class="booking-container">
            <h2>Réservations Récentes</h2>
            <?php
            $bookings = [
                 [
                    'client_name' => 'Jane Doe',
                    'menu_title' => 'Menu Dégustation Prestige',
                    'date_time' => '2024-06-15 19:00',
                    'guests' => 2,
                     'status' => 'En attente'
                ],
                [
                     'client_name' => 'John Smith',
                    'menu_title' => 'Menu Découverte Saisonnière',
                    'date_time' => '2024-07-02 20:00',
                    'guests' => 4,
                      'status' => 'En attente'
                ]
            ];
             if(empty($bookings)){
                echo '<p class="no-bookings-message">Aucune réservation en attente.</p>';
            } else {
                echo '<table class="booking-table">';
                echo '<thead><tr><th>Client</th><th>Menu</th><th>Date et Heure</th><th>Nombre de Personnes</th><th>Statut</th><th>Actions</th></tr></thead>';
                echo '<tbody>';
                foreach ($bookings as $booking) {
                  echo '<tr>';
                   echo '<td>' . htmlspecialchars($booking['client_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($booking['menu_title']) . '</td>';
                    echo '<td>' . htmlspecialchars($booking['date_time']) . '</td>';
                     echo '<td>' . htmlspecialchars($booking['guests']) . '</td>';
                     echo '<td>' . htmlspecialchars($booking['status']) . '</td>';
                   echo '<td><button class="button">Accepter</button> <button class="button">Refuser</button></td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            }
            ?>
        </div>
        <div class="next-client-container">
              <h2>Prochain Client</h2>
             <?php
                  // Replace with actual data fetching
                  $next_client = [
                   'client_name' => 'Jane Doe',
                   'menu_title' => 'Menu Dégustation Prestige',
                   'date_time' => '2024-06-15 19:00',
                   'guests' => 2,
                  ];
                 if(!empty($next_client)){
                  echo '<div class="next-client-card">';
                  echo '<h3>' . htmlspecialchars($next_client['client_name']) . '</h3>';
                  echo '<p>Menu: ' . htmlspecialchars($next_client['menu_title']) . '</p>';
                   echo '<p>Date et Heure: ' . htmlspecialchars($next_client['date_time']) . '</p>';
                    echo '<p>Nombre de Personnes: ' . htmlspecialchars($next_client['guests']) . '</p>';
                   echo '</div>';
                 }else{
                    echo '<p class="no-bookings-message">Pas de prochains clients.</p>';
                  }
             ?>
        </div>
    </div>
</body>
</html>
