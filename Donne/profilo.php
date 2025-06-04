<?php
    
    include "connection.php";

    session_start();



    if(!isset($_SESSION["user_id"])) {
        echo '<script>alert("Utente non esiste"); window.location.href = "Donne.php";</script>';
    }else{
        $user = $_GET['ID'];
        echo''.$user.'';
        $sql = "SELECT * FROM UTENTI WHERE ID = " . $user;
        $result = $connection->query($sql);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nome = $row['NOME'];
            $cognome = $row['COGNOME'];
            $email = $row['EMAIL'];
            $username = $row['USERNAME'];
            $password = $row['PASSWORD'];
        } else {
            echo "Utente non trovato!";
        }
    }

    $connection->close();

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
        <a href='
            <?php 
            include "connection.php";
            $sql1="SELECT AMMINISTRATORE FROM UTENTI WHERE ID = " . $_SESSION["user_id"];
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
        <img src='profilo-icona.png' alt='Profilo' class='profilo-icona'>
    </header>

    <main>
        <form method="POST" action="update_profilo.php">

            <h1>Profilo utente</h1>

            <!-- Stampa i dati dell'utente -->
            
            <label>Nome: <?php echo $nome; ?> </label> <br><br>
            
            <label>Cognome: <?php echo $cognome ?> </label> <br><br>
            
            <label>Username: <?php echo $username; ?></label> <br><br>
            
            <label>Email: <?php echo $email; ?></label> <br><br>
            
            <label>Password: <?php echo $password; ?></label> <br><br>
            

            <button type="submit" name="Modifica">Modifica</button>

            <?php
                include "connection.php";

                
                $sql1="SELECT AMMINISTRATORE FROM UTENTI WHERE ID = " . $_SESSION["user_id"];
                $result1 = $connection->query($sql1);
                $row= $result1->fetch_assoc();
                if($row["AMMINISTRATORE"] != 1 ) {
                    echo '<button type="button" onclick="location.href=\'Donne.php?ID=' . $_GET['ID'] . '\'">Ritorna</button>';
                }else{
                    echo '<button type="button" onclick="location.href=\'amministratore.php?ID=' . $_GET['ID'] . '\'">Ritorna</button>';
                } ?>

          



        </form>

    </main>

    <footer>
        <p>&copy; Info Women</p>
    </footer>";

</body>
</html>