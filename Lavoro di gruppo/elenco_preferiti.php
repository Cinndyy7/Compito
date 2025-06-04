<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donne</title>
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

        .donna-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .donna-card h3 {
            color: #2c3e50;
            margin-top: 0;
        }
        
    </style>
</head>


<?php
    include "connection.php";
    session_start();

    
    if (!isset($_SESSION['user_id'])) {
        ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Donne nell'informatica</title>
    </head>
    <body>
        <header>
            <img src='logo.png' alt='Logo del sito' class='logo'>
            <h1 class='titolo'>Donne nell'informatica</h1>
            <button class='login-button' type='button' onclick="location.href='login.php'">Login</button>
        </header>
        
        <main>
            <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="donna-card">';
                echo '<h3>' . $row['NOME'] . ' ' . $row['COGNOME'] . '</h3>';
                echo '<button class="donna-button" type="button" onclick="location.href=\'donna.php?ID=' . $row['ID'] . '\'">Visualizza</button>';
                echo '</div>';
            }
        } else {
            echo '<p class="nessun-risultato">Nessuna donna trovata nel database</p>';
        }
        ?>
    </main>
    
    <footer>
        <p>&copy; Le donne nell'informatica</p>
    </footer>
</body>
</html>
<?php
    die();
}
?>

<body>
    
    <header>
        <a href='Donne.php'>
            <img src='logo.png' alt='Logo del sito' class='logo'>
        </a>
        <h1 class='titolo'>Donne nell'informatica</h1>
        <a href='profilo.php?ID=<?php echo $_SESSION["user_id"] ?>' class='profilo-button'>
            <img src='profilo-icona.png' alt='Profilo' class='profilo-icona'>
        </a>
        
    </header>
    <main>
        <!-- STAMPA l'elenco delle donne -->
        <?php
            $sql = 'SELECT USERNAME FROM UTENTI WHERE ID=' . $_SESSION["user_id"];
            $result = $connection->query($sql);
            $username= $result->fetch_assoc()["USERNAME"];
            echo "Ciao " . $username . "!!!";
            echo '<button type="button" onclick="location.href=\'logout.php\'">Logout</button>';
            $sql = "SELECT U.USERNAME, D.NOME , D.COGNOME
                    FROM UTENTI_DONNE UD
                    JOIN UTENTI U ON UD.ID_UTENTE = U.ID
                    JOIN DONNE D ON UD.ID_DONNA = D.ID
                    WHERE UD.ID_UTENTE = " . $_SESSION['user_id'] . "
                    AND UD.PREFERITI = 1"; // Mostra solo i preferiti
            $result = $connection->query($sql);
            if($result && $result->num_rows > 0) {
                echo '<h2>I tuoi preferiti</h2>';
                while($row = $result->fetch_assoc()) {
                    echo '<div class="donna-card">';
                    echo '<h3>' . $row['NOME'] . ' ' . $row['COGNOME'] . '</h3>';
                    echo '</div><br>';
                }
            } else {
                echo '<p class="nessun-risultato">Nessun preferito salvato</p>';
            }
            echo '<button type="button" onclick="location.href=\'donne.php\'">Ritorna</button>';

        ?>

    </main>

    <footer>
        <p>&copy; Info Women</p>
    </footer>";

</body>
</html>