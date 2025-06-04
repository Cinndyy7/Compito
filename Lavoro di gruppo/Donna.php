<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donna</title>
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

        
        .logo-button {
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
            width: clamp(40px, 5vw, 60px);/* Larghezza adattativa tra 30px e 50px */
            height: clamp(40px, 5vw, 60px); /* Altezza adattativa tra 30px e 50px */
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
</head>


<?php

    include "connection.php";

    session_start();

    if(!isset($_SESSION['user_id'])){
        echo '<script>alert("Non ti sei loggato"); window.location.href = "Login.php";</script>';     
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
            <h1 class='titolo'>Donna</h1>
            <a href='profilo.php?ID=<?php echo $_SESSION["user_id"] ?>' class='profilo-button'>
                <img src='profilo-icona.png' alt='Profilo' class='profilo-icona'>
            </a>
        </header>

        <main>
        
            <!-- STAMPA I dati e le immagini della donna attraverso $_GET['ID'] -->
            <?php
                $connection->set_charset("utf8mb4");
                $sql = "SELECT * FROM DONNE WHERE ID=" . $_GET['ID'];
                $result = $connection->query($sql);
                
                if($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    
                    // Recupera il ritratto (prima immagine)
                    $sql_ritratto = "SELECT URL FROM IMMAGINI WHERE ID_DONNA = " . $row['ID'] . " ORDER BY ID ASC LIMIT 1";
                    $result_img = $connection->query($sql_ritratto);
                    $ritratto = $result_img && $result_img->num_rows > 0 
                        ? $result_img->fetch_assoc()['URL'] 
                        : 'immagini/placeholder.jpg';
                    
                    echo '<div style="display: flex; gap: 30px; align-items: center; margin-bottom: 20px;">';
                    
                    // Ritratto a sinistra
                    if($ritratto) {
                        echo '<img src="' . $ritratto . '" 
                                  style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1)">';
                    }
                    
                    echo '<div>';
                    echo '<h3 style="margin: 0">' . $row['NOME'] . ' ' . $row['COGNOME']  . '</h3>';
                    echo '<p class="data-nascita" style="margin: 10px 0">Nata il: ' . $row['DATA_NASCITA'] . '</p>';
                    echo '</div></div>';
                    
                    // Descrizione
                    echo '<p class="descrizione">' . $row['DESCRIZIONE'] . '</p>';
                    
                    // Altre immagini
                    $sql_altre = "SELECT URL, DESCRIZIONE FROM IMMAGINI WHERE ID_DONNA = " . $row['ID'] . " ORDER BY ID DESC LIMIT 3";
                    $altre_img = $connection->query($sql_altre);
                    
                    if($altre_img && $altre_img->num_rows > 0) {
                        echo '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 30px;">';
                        while($img = $altre_img->fetch_assoc()) {
                            // echo $img["URL"];
                            echo '<div>';
                            echo '<img src="' . $img['URL'] . '" 
                                          style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px">';
                            echo '<p style="text-align: center; font-size: 0.9rem; margin: 8px 0">' . $img['DESCRIZIONE'] . '</p>';
                            echo '</div>';
                        }
                        echo '</div>';
                    }


                    echo '<div style="margin-top: 40px; border-top: 2px solid #2c3e50; padding-top: 20px;">';
                    echo '<h3>Commenti</h3>';

                    // Query per recuperare i commenti con lo username
                    $sql_commenti = "SELECT C.*, U.USERNAME 
                                    FROM COMMENTI C
                                    JOIN UTENTI U ON C.ID_UTENTE = U.ID
                                    WHERE C.ID_DONNA = " . $row['ID'] . "
                                    ORDER BY C.DATA_ORA DESC";

                    $result_commenti = $connection->query($sql_commenti);

                    if($result_commenti && $result_commenti->num_rows > 0) {
                        while($commento = $result_commenti->fetch_assoc()) {
                            echo '<div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 15px;">';
                            echo '<div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">';
                            echo '<strong>' . $commento['USERNAME'] . '</strong>';
                            echo '<span style="color: #666;">' . $commento['DATA_ORA'] . '</span>';
                            echo '<div style="display: flex; gap: 5px;">';
                            for($i = 1; $i <= 5; $i++) {
                                echo '<span style="color: ' . ($i <= $commento['VALUTAZIONE'] ? '#f1c40f' : '#ddd') . '">★</span>';
                            }
                            // echo $commento["ID"];
                            if($commento['ID_UTENTE'] == $_SESSION["user_id"]) {
                                echo '<button type="button" onclick="location.href=\'commento_delete.php?DONNA_ID=' . $_GET['ID'] . "&&COMMENTO_ID=" . $commento["ID"] . '\'">ELIMINA</button>';
                            }
                            echo '</div></div>';
                            echo '<p>' . $commento['COMMENTO'] . '</p>';
                            echo '</div>';
                        }

                        $sql1="SELECT AMMINISTRATORE FROM UTENTI WHERE ID = " . $_SESSION["user_id"];
                        $result1 = $connection->query($sql1);
                        $row= $result1->fetch_assoc();
                            if($row["AMMINISTRATORE"] != 1 ) {
                                echo '<div style="margin-top: 20px;">
                                        <button type="button" onclick="location.href=\'commenta.php?ID=' . $_GET['ID'] . '\'">Lascia un commento</button>
                                        </div>';
                            }else{
                            }
                        
                        
                    } else {
                        
                        $sql1="SELECT AMMINISTRATORE FROM UTENTI WHERE ID = " . $_SESSION["user_id"];
                        $result1 = $connection->query($sql1);
                        $row= $result1->fetch_assoc();
                        if($row["AMMINISTRATORE"] != 1 ) {
                            echo '<p>Nessun commento presente. Sii il primo a commentare!</p>';
                            echo '<div style="margin-top: 20px;">
                            <button type="button" onclick="location.href=\'commenta.php?ID=' . $_GET['ID'] . '\'">Lascia un commento</button>
                            </div>';
                        }else{
                                echo '<p>Nessun commento presente.</p>';
                            }
                        
                    }

                    echo '</div>'; // Chiusura sezione commenti
                }
                
                $sql1="SELECT AMMINISTRATORE FROM UTENTI WHERE ID = " . $_SESSION["user_id"];
                $result1 = $connection->query($sql1);
                $row= $result1->fetch_assoc();
                if($row["AMMINISTRATORE"] != 1 ) {
                    echo '<button type="button" onclick="location.href=\'preferiti.php?ID=' . $_GET["ID"] . '\'">Aggiungi ai preferiti</button>';
                    echo '<button type="button" onclick="location.href=\'donne.php\'">Ritorna</button>';
                }else{
                        echo '<button type="button" onclick="location.href=\'amministratore.php\'">Ritorna</button>';
                    }
            ?>
        </main>

        <footer>
            <p>&copy; Info Women</p>
        </footer>

</body>
</html>