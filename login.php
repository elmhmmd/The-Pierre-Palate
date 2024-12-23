<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a1a1a; /* Dark background */
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.05); /* Slightly transparent white */
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #ffd700; /* Gold color */
             font-size: 2rem;
        }

        .form-group {
            margin-bottom: 25px;
             position: relative;
        }

       .form-group label {
            display: block;
            margin-bottom: 5px;
             font-size: 1.1rem;
           color: #fff;
       }
       .form-group input {
             width: 100%;
            padding: 12px 0;
           background-color: transparent;
            border: none;
            border-bottom: 2px solid #ffd700; /* Thick gold border only at the bottom */
             color: #fff;
              font-size: 1rem;
              outline: none;
           transition: border-bottom-color 0.3s ease, box-shadow 0.3s ease;
            }
           .form-group input:focus {
           box-shadow: 0 3px 6px rgba(255, 215, 0, 0.3);
          }

        .button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #ffd700; /* Gold button */
            color: #1a1a1a;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            font-size: 1.1rem;
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

        p {
            text-align: center;
           margin-top: 20px;
        }
        p a{
        color: #ffd700;
        }
        p a:hover{
        text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Connexion</h2>
        <form action="/login" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de Passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="button">Se Connecter</button>
        </form>
        <p>Vous n'avez pas de compte? <a href="register.html">Inscrivez-vous</a></p>
    </div>
</body>
</html>