<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
</head>

<?php

    session_start();
    session_unset(); //LOGOUT AUTOMATICO
    include 'connection.php';

?>

<style>
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            grid-template-areas: 
                "header"
                "main"
                "footer";
            grid-template-rows: auto 1fr auto;
            font-family: "Times New Roman", Times, serif;
        }

        header {
            grid-area: header;
            background-color: #2c3e50;
            color: white;
            padding: 1rem 2rem;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 20px;
        }

        .logo {
            height: 50px;
            width: auto;
        }

        .titolo {
            text-align: center;
            margin: 0;
            font-size: 1.5rem;
        }

        .login-button {
            background-color: #3498db;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            justify-self: end;
            font-family: "Times New Roman", Times, serif;
        }

        main {
            grid-area: main;
            padding: 2rem;
            background-color: #ecf0f1; 
        }

        footer {
            grid-area: footer;
            background-color: #2c3e50;
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        .profilo-button {
            justify-self: end;
            transition: transform 0.3s ease;
            padding: 5px;
            width: clamp(40px, 5vw, 60px);
            height: clamp(40px, 5vw, 60px);
            padding: 3px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .profilo-icona {
            width: clamp(40px, 5vw, 60px);
            height: clamp(40px, 5vw, 60px);
            border-radius: 50%;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .profile-button:hover {
            transform: scale(1.1);
        }

        .profile-button:active {
            transform: scale(0.95);
        }
</style>



<body>

    <header>
        <a href='Donne.php'>
            <img src='logo.png' alt='Logo del sito' class='logo'>
        </a>
        <h1 class='titolo'>Donne nell'informatica</h1>
        <button class='login-button' type='button' onclick="location.href='login.php'">Login</button>
    </header>

    <main>

    <form method="POST" action="check_login.php">

        <h1>Login</h1>
        <labe for="nome">Email</label> <br>
        <input type="text" placeholder="Email" name="EMAIL"> <br> <br>
        <labe for="password">Password</label> <br>
        <input type="password" placeholder="Password" name="PASSWORD"> <br><br>
        <button type="submit" name="LOGIN">Accedi</button>
        <input type="button" value="Registrati" onclick="location.href='registrati.php'">
        <button type="button" onclick="location.href='Donne.php';">Ritorna</button>

    </form>

    </main>

    <footer>
        <p>&copy; Info Women</p>
    </footer>";

    
</body>
</html>