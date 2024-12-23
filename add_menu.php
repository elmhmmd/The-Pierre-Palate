<?php
session_start();
require 'db_connect.php';

// Verify chef authentication
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'chef') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $price = floatval($_POST['price']);
    $description = trim($_POST['description']);
    $dishes = $_POST['dishes'];

    
    $conn->begin_transaction();

    try {
        // Insert menu
        $menu_stmt = $conn->prepare("INSERT INTO menus (title, description, price) VALUES (?, ?, ?)");
        $menu_stmt->bind_param("ssd", $title, $description, $price);
        $menu_stmt->execute();
        $menu_id = $conn->insert_id;
        $menu_stmt->close();

        // Insert dishes and create menu-dish relationships
        foreach ($dishes as $dish_name) {
            // Check if dish exists
            $check_dish = $conn->prepare("SELECT id_dish FROM dishes WHERE name = ?");
            $check_dish->bind_param("s", $dish_name);
            $check_dish->execute();
            $result = $check_dish->get_result();
            
            if ($result->num_rows > 0) {
                // Dish exists, get its ID
                $dish_id = $result->fetch_assoc()['id_dish'];
            } else {
                // Create new dish
                $dish_stmt = $conn->prepare("INSERT INTO dishes (name) VALUES (?)");
                $dish_stmt->bind_param("s", $dish_name);
                $dish_stmt->execute();
                $dish_id = $conn->insert_id;
                $dish_stmt->close();
            }
            $check_dish->close();

            // Link dish to menu
            $link_stmt = $conn->prepare("INSERT INTO menu_dishes (id_menu, id_dish) VALUES (?, ?)");
            $link_stmt->bind_param("ii", $menu_id, $dish_id);
            $link_stmt->execute();
            $link_stmt->close();
        }

        // Commit transaction
        $conn->commit();
        $_SESSION['message'] = "Menu créé avec succès!";
        
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        $_SESSION['error'] = "Erreur lors de la création du menu: " . $e->getMessage();
    }

    header('Location: chef.php');
    exit();
}
?>