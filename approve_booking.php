<?php
session_start();
require 'db_connect.php';

// Verify chef authentication
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'chef') {
    header('Location: login.php');
    exit();
}

// Validate booking ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "ID de réservation invalide.";
    header('Location: chef.php');
    exit();
}

$booking_id = $_GET['id'];

// Check if booking exists and is pending
$check_stmt = $conn->prepare("SELECT status FROM bookings WHERE id_bookings = ? AND status = 'pending'");
$check_stmt->bind_param("i", $booking_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Réservation introuvable ou déjà traitée.";
    $check_stmt->close();
    header('Location: chef.php');
    exit();
}
$check_stmt->close();

// Update booking status to approved
$update_stmt = $conn->prepare("UPDATE bookings SET status = 'approved' WHERE id_bookings = ?");
$update_stmt->bind_param("i", $booking_id);

if ($update_stmt->execute()) {
    $_SESSION['success'] = "Réservation approuvée avec succès.";
} else {
    $_SESSION['error'] = "Erreur lors de l'approbation de la réservation.";
}

$update_stmt->close();
header('Location: chef.php');
exit();
?>