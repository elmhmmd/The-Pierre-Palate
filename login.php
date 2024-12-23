<?php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $errors = [];
    if (empty($email) || empty($password)) {
        $errors[] = "Email and password are required.";
    }
    if(empty($errors)) {
        $stmt = $conn->prepare("SELECT id_user, username, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'chef') {
                header("Location: chef.php");
            } else {
                header("Location: client.php");
            }
            exit;
        } else {
            $errors[] = "Invalid username or password.";
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
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: '#ffd700',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans m-0 p-0 bg-[#1a1a1a] text-white flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-10 bg-white/5 rounded-lg shadow-lg">
        <h2 class="text-center mb-8 text-gold text-3xl">Connexion</h2>
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
            <div class="mb-6 relative">
                <label for="email" class="block mb-2 text-lg text-white">Email:</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       required 
                       class="w-full py-3 bg-transparent border-b-2 border-gold text-white text-base outline-none focus:shadow-[0_3px_6px_rgba(255,215,0,0.3)] transition-all duration-300">
            </div>
            <div class="mb-6 relative">
                <label for="password" class="block mb-2 text-lg text-white">Mot de Passe:</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required 
                       class="w-full py-3 bg-transparent border-b-2 border-gold text-white text-base outline-none focus:shadow-[0_3px_6px_rgba(255,215,0,0.3)] transition-all duration-300">
            </div>
            <button type="submit" 
                    class="w-full py-3 bg-gold text-[#1a1a1a] rounded font-bold text-lg relative overflow-hidden hover:bg-[#e6bc00] hover:shadow-[0_4px_10px_rgba(255,215,0,0.5)] hover:-translate-y-0.5 transition-all duration-300">
                Se Connecter
            </button>
        </form>
        <p class="text-center mt-5">
            Vous n'avez pas de compte? 
            <a href="signup.php" class="text-gold hover:underline">Inscrivez-vous</a>
        </p>
    </div>
</body>
</html>
