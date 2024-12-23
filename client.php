<?php
session_start();
require_once 'db_connect.php';


if (!isset($_SESSION['username']) || !isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}


$username = $_SESSION['username'];
$user_id = $_SESSION['id_user'];


$menus_query = "SELECT id_menu, title, description, price FROM menus";
$menus_result = $conn->query($menus_query);
$menus = [];
if ($menus_result) {
    while ($row = $menus_result->fetch_assoc()) {
        $menus[] = $row;
    }
}


$bookings_query = "SELECT b.*, m.title as menu_title 
                  FROM bookings b 
                  JOIN menus m ON b.id_menu = m.id_menu 
                  WHERE b.id_user = ? 
                  ORDER BY b.booking_time DESC";
$stmt = $conn->prepare($bookings_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$bookings_result = $stmt->get_result();
$bookings = [];
if ($bookings_result) {
    while ($row = $bookings_result->fetch_assoc()) {
        $bookings[] = $row;
    }
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Client</title>
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
            <h1 class="text-gold text-xl font-bold">The Pierre Palette</h1>
            <a href="logout.php" class="px-4 py-2 bg-gold text-dark-bg font-bold rounded hover:bg-gold-hover transition-all duration-300">
                Déconnexion
            </a>
        </div>
    </nav>

    <div class="w-[90%] max-w-7xl mx-auto py-8">
        <!-- Welcome Message -->
        <h1 class="text-center text-4xl text-gold mb-8">
            Bienvenue, <?php echo htmlspecialchars($username); ?>!
        </h1>

        <!-- Available Menus Section -->
        <h2 class="text-2xl text-gold mb-6">Menus Disponibles</h2>
        <div class="flex flex-wrap justify-center gap-5">
            <?php if (empty($menus)): ?>
                <p class="text-center text-lg">Aucun menu disponible pour le moment.</p>
            <?php else: ?>
                <?php foreach ($menus as $menu): ?>
                    <div class="w-[280px] bg-white/5 rounded-lg p-5 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <h3 class="text-gold text-xl mb-3">
                            <?php echo htmlspecialchars($menu['title']); ?>
                        </h3>
                        <p class="mb-4">
                            <?php echo htmlspecialchars($menu['description']); ?>
                        </p>
                        <p class="mb-4">
                            Prix: <?php echo htmlspecialchars($menu['price']); ?>€
                        </p>
                        <a href="booking.php?menu_id=<?php echo $menu['id_menu']; ?>" 
                           class="inline-block px-4 py-2 bg-gold text-dark-bg font-bold rounded hover:bg-gold-hover transition-all duration-300">
                            Réserver
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- User Bookings Section -->
        <div class="mt-12">
            <h2 class="text-2xl text-gold mb-6">Vos Réservations</h2>
            <?php if (empty($bookings)): ?>
                <p class="text-center text-lg mt-5">Vous n'avez pas encore de réservations.</p>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th class="text-left p-3 text-gold">Menu</th>
                                <th class="text-left p-3 text-gold">Date et Heure</th>
                                <th class="text-left p-3 text-gold">Personnes</th>
                                <th class="text-left p-3 text-gold">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr class="border-b border-white/10">
                                    <td class="p-3">
                                        <?php echo htmlspecialchars($booking['menu_title']); ?>
                                    </td>
                                    <td class="p-3">
                                        <?php echo date('d/m/Y H:i', strtotime($booking['booking_time'])); ?>
                                    </td>
                                    <td class="p-3">
                                        <?php echo htmlspecialchars($booking['guests']); ?>
                                    </td>
                                    <td class="p-3">
                                        <?php echo htmlspecialchars($booking['status']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>