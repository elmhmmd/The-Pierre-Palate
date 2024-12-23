<?php

session_start();
require 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];

    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    if (empty($email)) {
        $errors[] = "email is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if ($password != $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $checkUsername = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $checkUsername->bind_param("s", $username);
        $checkUsername->execute();

        if($checkUsername->get_result()->num_rows > 0) {
            $errors[] = "Username already exists";
        } 

        $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();

        if($checkUsername->get_result()->num_rows > 0) {
            $errors[] = "Email already in use";
        }


        if (empty($errors)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password_hash);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Registration successful!"; 
            } else {
                $errors[] = "Error during registration. Please try again.";
            }
            $stmt->close();
        }
    }
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-bg': '#1a1a1a',
                        'gold': '#ffd700',
                        'gold-hover': '#e6bc00',
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-dark-bg text-white flex items-center justify-center min-h-screen overflow-y-auto">
    <div class="form-container w-full max-w-md px-8 py-12 bg-white/5 rounded-lg shadow-xl">
        <h2 class="text-center mb-8 text-gold text-3xl font-semibold">Inscription</h2>
         <?php
        if (isset($_SESSION['errors'])) {
           echo '<div style="color: red;">';
           foreach ($_SESSION['errors'] as $error) {
               echo $error . "<br>";
           }
          echo '</div>';
          unset($_SESSION['errors']);
       }
    ?>
        <form action="" method="post">
            <div class="form-group mb-6">
                <label for="username" class="block mb-2 text-lg">Nom d'utilisateur:</label>
                <div class="relative">
                    <input type="text" id="username" name="username" required class="w-full px-4 py-3 bg-transparent border-b-2 border-gold text-white text-base outline-none focus:ring-0 focus:shadow-[0_3px_6px_rgba(255,215,0,0.3)] transition-all duration-300">
                </div>
            </div>
            <div class="form-group mb-6">
                <label for="email" class="block mb-2 text-lg">Email:</label>
                <div class="relative">
                    <input type="email" id="email" name="email" required class="w-full px-4 py-3 bg-transparent border-b-2 border-gold text-white text-base outline-none focus:ring-0 focus:shadow-[0_3px_6px_rgba(255,215,0,0.3)] transition-all duration-300">
                </div>
            </div>
            <div class="form-group mb-6">
                <label for="password" class="block mb-2 text-lg">Mot de Passe:</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required class="w-full px-4 py-3 bg-transparent border-b-2 border-gold text-white text-base outline-none focus:ring-0 focus:shadow-[0_3px_6px_rgba(255,215,0,0.3)] transition-all duration-300">
                </div>
            </div>
            <div class="form-group mb-6">
                <label for="confirm_password" class="block mb-2 text-lg">Confirmer Mot de Passe:</label>
                <div class="relative">
                    <input type="password" id="confirm_password" name="confirm_password" required class="w-full px-4 py-3 bg-transparent border-b-2 border-gold text-white text-base outline-none focus:ring-0 focus:shadow-[0_3px_6px_rgba(255,215,0,0.3)] transition-all duration-300">
                </div>
            </div>
            <button type="submit" class="button block w-full py-3 bg-gold text-dark-bg border-none rounded-md cursor-pointer text-lg font-bold relative overflow-hidden z-10 hover:bg-gold-hover hover:shadow-[0_4px_10px_rgba(255,215,0,0.5)] hover:translate-y-[-2px] transition-all duration-300 before:content-[''] before:absolute before:top-0 before:left-0 before:w-full before:h-full before:bg-[rgba(255,215,0,0.2)] before:translate-x-[-100%] before:transition-transform before:duration-300 hover:before:translate-x-0">S'inscrire</button>
        </form>
        <p class="text-center mt-5">Vous avez déjà un compte? <a href="login.php" class="text-gold hover:underline">Connectez-vous</a></p>
    </div>
</body>
</html>