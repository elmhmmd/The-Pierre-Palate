<?php
session_start();
require 'db_connect.php';

// Verify chef authentication
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'chef') {
    header('Location: login.php');
    exit();
}

// Fetch dashboard statistics
$stats_query = "SELECT 
    COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_requests,
    COUNT(CASE WHEN status = 'approved' AND DATE(booking_time) = CURDATE() THEN 1 END) as approved_today,
    COUNT(CASE WHEN status = 'approved' AND DATE(booking_time) = DATE_ADD(CURDATE(), INTERVAL 1 DAY) THEN 1 END) as approved_tomorrow,
    (SELECT COUNT(*) FROM users WHERE role = 'client') as registered_clients
FROM bookings";

$stats_result = $conn->query($stats_query);
$stats = $stats_result->fetch_assoc();

// Fetch pending bookings
$pending_query = "SELECT b.*, u.username as client_name, m.title as menu_title 
    FROM bookings b 
    JOIN users u ON b.id_user = u.id_user 
    JOIN menus m ON b.id_menu = m.id_menu 
    WHERE b.status = 'pending' 
    ORDER BY b.booking_time DESC 
    LIMIT 5";

$pending_result = $conn->query($pending_query);
$pending_bookings = [];
while ($row = $pending_result->fetch_assoc()) {
    $pending_bookings[] = $row;
}

// Fetch next booking
$next_booking_query = "SELECT b.*, u.username as client_name, m.title as menu_title 
    FROM bookings b 
    JOIN users u ON b.id_user = u.id_user 
    JOIN menus m ON b.id_menu = m.id_menu 
    WHERE b.status = 'approved' 
    AND b.booking_time > NOW() 
    ORDER BY b.booking_time ASC 
    LIMIT 1";

$next_booking_result = $conn->query($next_booking_query);
$next_booking = $next_booking_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Chef</title>
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
            <h1 class="text-gold text-xl font-bold">The Pierre Palette - Chef Dashboard</h1>
            <div class="flex items-center gap-4">
                <a href="create_menu.php" class="px-4 py-2 bg-gold text-dark-bg font-bold rounded hover:bg-gold-hover transition-all duration-300">
                    Créer un Menu
                </a>
                <a href="logout.php" class="px-4 py-2 bg-red-500 text-white font-bold rounded hover:bg-red-600 transition-all duration-300">
                    Déconnexion
                </a>
            </div>
        </div>
    </nav>

    <div class="w-[90%] max-w-7xl mx-auto py-8">
        <!-- Statistics Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white/5 p-4 rounded-lg">
                <h3 class="text-gold text-lg mb-2">Demandes en attente</h3>
                <p class="text-2xl"><?php echo $stats['pending_requests']; ?></p>
            </div>
            <div class="bg-white/5 p-4 rounded-lg">
                <h3 class="text-gold text-lg mb-2">Réservations aujourd'hui</h3>
                <p class="text-2xl"><?php echo $stats['approved_today']; ?></p>
            </div>
            <div class="bg-white/5 p-4 rounded-lg">
                <h3 class="text-gold text-lg mb-2">Réservations demain</h3>
                <p class="text-2xl"><?php echo $stats['approved_tomorrow']; ?></p>
            </div>
            <div class="bg-white/5 p-4 rounded-lg">
                <h3 class="text-gold text-lg mb-2">Clients inscrits</h3>
                <p class="text-2xl"><?php echo $stats['registered_clients']; ?></p>
            </div>
        </div>

        <!-- Pending Bookings Section -->
        <div class="mb-8">
            <h2 class="text-2xl text-gold mb-6">Demandes de Réservation en Attente</h2>
            <?php if (empty($pending_bookings)): ?>
                <p class="text-center text-lg">Aucune demande en attente.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th class="text-left p-3 text-gold">Client</th>
                                <th class="text-left p-3 text-gold">Menu</th>
                                <th class="text-left p-3 text-gold">Date</th>
                                <th class="text-left p-3 text-gold">Personnes</th>
                                <th class="text-left p-3 text-gold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pending_bookings as $booking): ?>
                                <tr class="border-b border-white/10">
                                    <td class="p-3"><?php echo htmlspecialchars($booking['client_name']); ?></td>
                                    <td class="p-3"><?php echo htmlspecialchars($booking['menu_title']); ?></td>
                                    <td class="p-3"><?php echo date('d/m/Y H:i', strtotime($booking['booking_time'])); ?></td>
                                    <td class="p-3"><?php echo htmlspecialchars($booking['guests']); ?></td>
                                    <td class="p-3">
                                        <a href="approve_booking.php?id=<?php echo $booking['id_bookings']; ?>" 
                                           class="inline-block px-3 py-1 bg-green-500 text-white rounded mr-2 hover:bg-green-600">
                                            Approuver
                                        </a>
                                        <a href="reject_booking.php?id=<?php echo $booking['id_bookings']; ?>" 
                                           class="inline-block px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                            Rejeter
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Next Client Section -->
        <div class="bg-white/5 p-6 rounded-lg">
            <h2 class="text-2xl text-gold mb-6">Prochain Client</h2>
            <?php if ($next_booking): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <h3 class="text-gold mb-2">Client</h3>
                        <p><?php echo htmlspecialchars($next_booking['client_name']); ?></p>
                    </div>
                    <div>
                        <h3 class="text-gold mb-2">Menu</h3>
                        <p><?php echo htmlspecialchars($next_booking['menu_title']); ?></p>
                    </div>
                    <div>
                        <h3 class="text-gold mb-2">Date et Heure</h3>
                        <p><?php echo date('d/m/Y H:i', strtotime($next_booking['booking_time'])); ?></p>
                    </div>
                    <div>
                        <h3 class="text-gold mb-2">Nombre de Personnes</h3>
                        <p><?php echo htmlspecialchars($next_booking['guests']); ?></p>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-center text-lg">Aucune réservation à venir</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>