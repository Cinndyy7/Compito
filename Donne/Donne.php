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
        .bottone-destro {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .bottone-destro button {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-left: 10px;
            font-family: "Times New Roman", Times, serif;
        }

        .bottone-destro button:hover {
            background-color: #2c3e50;
            transform: scale(1.05);
        }

        .bottone-destro button:active {
            transform: scale(0.95);
        }

        
    </style>
</head>


<?php
    session_start();
    include "connection.php";

    $sql = "SELECT * FROM DONNE ORDER BY COGNOME ASC";
    $result = $connection->query($sql);

    if (!isset($_SESSION['user_id'])) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Donne nell'informatica</title>
</head>
<body>
    <header>
        <a href='Donne.php'>
            <img src='logo.png' alt='Logo del sito' class='logo'>
        </a>
        <h1 class='titolo'>Donne nell'informatica</h1>
        <button class='login-button' type='button' onclick="location.href='login.php'">Login</button>
    </header>

    <main>
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $sql_img = "SELECT URL FROM IMMAGINI WHERE ID_DONNA = " . $row['ID'] . " ORDER BY ID ASC LIMIT 1";
                $result_img = $connection->query($sql_img);
                $img_url = $result_img && $result_img->num_rows > 0 
                    ? $result_img->fetch_assoc()['URL'] 
                    : 'immagini/placeholder.jpg'; // Immagine di default se non trovata
                // echo $img_url;

                echo '<div class="donna-card">';
                // Aggiungi l'immagine affianco al nome
                echo '<div style="display: flex; gap: 20px; align-items: center;">';
                echo '<img src="' . $img_url . '" alt="Ritratto" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">';
                echo '<div>';
                echo '<h3>' . $row['NOME'] . ' ' . $row['COGNOME'] . '</h3>';
                echo '<div class="bottone-destro"><button class="donna-button" type="button" onclick="location.href=\'donna.php?ID=' . $row['ID'] . '\'">Visualizza</button></div>';

                echo '</div></div>';
                echo '</div><br>';
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
        <a href='
            <?php $sql1="SELECT AMMINISTRATORE FROM UTENTI WHERE ID = " . $_SESSION["user_id"];
                        $result1 = $connection->query($sql1);
                        $row= $result1->fetch_assoc();
                            if($row["AMMINISTRATORE"] != 1 ) {
                                echo 'donne.php';
                            }else{
                                echo 'amministratore.php';
                            } ?>' class='logo-button'>
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
            echo '<div class="bottone-destro"><button type="button" onclick="location.href=\'logout.php\'">Logout</button></div>';
            echo '<div class="bottone-destro"><button type="button" onclick="location.href=\'elenco_preferiti.php\'">Vedi lista dei preferiti</button></div>';
            $sql = "SELECT * FROM DONNE ORDER BY COGNOME ASC";
            $result = $connection->query($sql);
            
            if($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $sql_img = "SELECT URL FROM IMMAGINI WHERE ID_DONNA = " . $row['ID'] . " ORDER BY ID ASC LIMIT 1";
                    $result_img = $connection->query($sql_img);
                    $img_url = $result_img && $result_img->num_rows > 0 
                        ? $result_img->fetch_assoc()['URL'] 
                        : 'immagini/placeholder.jpg'; // Immagine di default se non trovata
                    // echo $img_url;

                    echo '<div class="donna-card">';
                    // Aggiungi l'immagine affianco al nome
                    echo '<div style="display: flex; gap: 20px; align-items: center;">';
                    echo '<img src="' . $img_url . '" alt="Ritratto" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">';
                    echo '<div>';
                    echo '<h3>' . $row['NOME'] . ' ' . $row['COGNOME'] . '</h3>';
                    echo '<div class="bottone-destro"><button class="donna-button" type="button" onclick="location.href=\'donna.php?ID=' . $row['ID'] . '\'">Visualizza</button></div>';

                    echo '</div></div>';
                    echo '</div><br>';
                }
            } else {
                echo '<p class="nessun-risultato">Nessuna donna trovata nel database</p>';
            }
        ?>

    </main>

    <footer>
        <p>&copy; Info Women</p>
    </footer>";

</body>
</html>