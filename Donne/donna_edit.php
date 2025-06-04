<?php

    include "connection.php";

    session_start();

    if (!isset($_SESSION["user_id"])) {
        echo '<script>alert("Accesso non autorizzato"); window.location.href = "donne.php";</script>';
    }

    if(isset($_POST['NOME']) && isset($_POST['COGNOME'])&& isset($_POST['DATA_NASCITA'])&& isset($_POST['DESCRIZIONE'])){
        
        $id=$_GET["ID"] ;
        
        $nome=$_POST['NOME'];
        $cognome=$_POST['COGNOME'];
        $data_nascita=$_POST['DATA_NASCITA'];
        $descrizione=$_POST['DESCRIZIONE'];
    

        $sql = "UPDATE DONNE SET 
                NOME ='" .  $nome . "'," .
                "COGNOME ='" .  $cognome . "'," .
                "DATA_NASCITA ='" .  $data_nascita . "'," .
                "DESCRIZIONE ='" .  $descrizione . "' WHERE ID=" . $id;

        echo  $sql;
        $connection->query($sql);


    header("location:amministratore.php");

}
$connection -> close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo utente</title>
</head>

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

        .card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .card h3 {
            color: #2c3e50;
            margin-top: 0;
        }
        
    </style>

<body>
    <header>
        <a href='amministratore.php' class='logo-button'>
            <img src='logo.png' alt='Logo del sito' class='logo'>
        </a>
        <h1 class='titolo'>Amministratore</h1>
        <a href='profilo.php?ID= <?php echo $_SESSION["user_id"] ?>' class='profilo-button'>
            <img src='profilo-icona.png' alt='Profilo' class='profilo-icona'>
        </a>
    </header>

    <main>

    <form method="POST" action="">

        <?php 
            include "connection.php";
            $sql="SELECT NOME,COGNOME FROM DONNE WHERE ID= ". $_GET["ID"] ; 
            // echo $sql;
            // if ($connection->query($sql) === FALSE) {
            //     echo "Errore: " . $connection->error;
            // }
            $result=$connection->query($sql);
            $row=$result->fetch_assoc();
            echo "<h1>" . $row["NOME"] . " ". $row["COGNOME"] ."</h1>"; 
        ?>
        
        <label for name="NOME">Nome: </label>
        <input type="text" name="NOME"> <br><br> 

        <label for name="COGNOME">Cognome: </label>
        <input type="text" name="COGNOME"> <br><br> 

        <label for name="DATA_NASCITA">Data di nascita: </label>
        <input type="date" name="DATA_NASCITA"> <br><br> 

        <label for name="DESCRIZIONE">Descrizione: </label>
        <input type="text" name="DESCRIZIONE"> <br><br> 

        <button type="submit" name="Modifica">Modifica</button>
        <button type="reset" name="ANNULLA">Cancella</button>
        <button type="button" onclick="location.href='amministratore.php';">Ritorna</button>



    </form>
    </main>

    <footer>
        <p>&copy; Info Women</p>
    </footer>";


</body>
</html>