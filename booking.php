<?php
session_start();
require_once 'db_connect.php';

// Check authentication
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit();
}

// Validate menu_id parameter
if (!isset($_GET['menu_id']) || !is_numeric($_GET['menu_id'])) {
    header('Location: client.php');
    exit();
}

$menu_id = $_GET['menu_id'];
$user_id = $_SESSION['id_user'];

// Fetch menu details
$menu_query = "SELECT m.*, GROUP_CONCAT(d.name SEPARATOR ', ') as dishes 
               FROM menus m 
               LEFT JOIN menu_dishes md ON m.id_menu = md.id_menu 
               LEFT JOIN dishes d ON md.id_dish = d.id_dish 
               WHERE m.id_menu = ?
               GROUP BY m.id_menu";
               
$stmt = $conn->prepare($menu_query);
$stmt->bind_param("i", $menu_id);
$stmt->execute();
$result = $stmt->get_result();
$menu = $result->fetch_assoc();
$stmt->close();

if (!$menu) {
    header('Location: client.php');
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = (int)$_POST['guests'];
    $booking_time = date('Y-m-d H:i:s', strtotime("$date $time"));
    
    $errors = [];
    
    // Validate inputs
    if (strtotime($booking_time) < time()) {
        $errors[] = "La date de réservation doit être dans le futur.";
    }
    
    if ($guests < 1 || $guests > 10) {
        $errors[] = "Le nombre de personnes doit être entre 1 et 10.";
    }
    
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO bookings (id_user, id_menu, booking_time, guests, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->bind_param("iisi", $user_id, $menu_id, $booking_time, $guests);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Votre réservation a été enregistrée et est en attente de confirmation.";
            header('Location: client.php');
            exit();
        } else {
            $errors[] = "Une erreur est survenue lors de la réservation.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation - <?php echo htmlspecialchars($menu['title']); ?></title>
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
            <h1 class="text-gold text-xl font-bold">The Pierre Palette</h1>
            <a href="client.php" class="px-4 py-2 bg-gold text-dark-bg font-bold rounded hover:bg-gold-hover transition-all duration-300">
                Retour
            </a>
        </div>
    </nav>

    <div class="w-[90%] max-w-2xl mx-auto py-8">
        <?php if (!empty($errors)): ?>
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-6">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white/5 p-6 rounded-lg shadow-xl mb-8">
            <h2 class="text-2xl text-gold mb-4"><?php echo htmlspecialchars($menu['title']); ?></h2>
            <p class="mb-4 text-gray-300"><?php echo htmlspecialchars($menu['description']); ?></p>
            <?php if ($menu['dishes']): ?>
                <p class="mb-4 text-sm text-gray-400">
                    <span class="text-gold">Plats:</span> <?php echo htmlspecialchars($menu['dishes']); ?>
                </p>
            <?php endif; ?>
            <p class="text-gold font-bold text-lg mb-4">Prix: <?php echo htmlspecialchars($menu['price']); ?>€</p>
        </div>

        <div class="bg-white/5 p-6 rounded-lg shadow-xl">
            <h3 class="text-xl text-gold mb-6">Réserver ce Menu</h3>
            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gold mb-2">Date</label>
                        <input type="date" name="date" required 
                               min="<?php echo date('Y-m-d'); ?>"
                               class="w-full px-4 py-2 bg-dark-bg border border-gold rounded text-white">
                    </div>
                    <div>
                        <label class="block text-gold mb-2">Heure</label>
                        <select name="time" required 
                                class="w-full px-4 py-2 bg-dark-bg border border-gold rounded text-white">
                            <option value="">Choisir une heure</option>
                            <?php
                            for ($hour = 12; $hour <= 22; $hour++) {
                                printf(
                                    '<option value="%02d:00">%02d:00</option>',
                                    $hour,
                                    $hour
                                );
                                if ($hour != 22) {
                                    printf(
                                        '<option value="%02d:30">%02d:30</option>',
                                        $hour,
                                        $hour
                                    );
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-gold mb-2">Nombre de personnes</label>
                    <input type="number" name="guests" required min="1" max="10" 
                           class="w-full px-4 py-2 bg-dark-bg border border-gold rounded text-white">
                    <p class="text-sm text-gray-400 mt-1">Maximum 10 personnes par réservation</p>
                </div>

                <button type="submit" 
                        class="w-full px-6 py-3 bg-gold text-dark-bg font-bold rounded-lg hover:bg-gold-hover transition-all duration-300">
                    Confirmer la Réservation
                </button>
            </form>
        </div>
    </div>
</body>
</html>