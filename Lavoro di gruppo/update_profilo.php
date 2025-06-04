<?php

    include "connection.php";

    session_start();

    if (!isset($_SESSION["user_id"])) {
        echo '<script>alert("Accesso non autorizzato"); window.location.href = "donne.php";</script>';
    }

    if(isset($_POST['NOME']) && isset($_POST['COGNOME'])&& isset($_POST['EMAIL'])&& isset($_POST['USERNAME'])&& isset($_POST['PASSWORD'])&& isset($_POST['PASSWORD2'])){
        
        $id=$_SESSION["user_id"] ;
        
        $nome=$_POST['NOME'];
        $cognome=$_POST['COGNOME'];
        $email=$_POST['EMAIL'];
        $password=$_POST['PASSWORD'];
        $password2=$_POST['PASSWORD2'];
        $username=$_POST['USERNAME'];
    

        if($password == $password2){

            $check_email = $connection->query("SELECT ID FROM UTENTI WHERE EMAIL = " . $email);
            if ($check_email->num_rows > 0) {
                echo '<script>alert("Email già registrata da un altro utente"); window.location.href = "donne.php";</script>';
            }
            
            $sql = "UPDATE UTENTI SET 
                    NOME ='" .  $nome . "'," .
                    "COGNOME ='" .  $cognome . "'," .
                    "EMAIL ='" .  $email . "'," .
                    "USERNAME ='" .  $username . "'," .
                    "PASSWORD ='" .  md5($password) . "' WHERE ID=" . $id;

            echo "". $sql ."";
            $connection->query($sql);
            $sql="SELECT ID FROM UTENTI WHERE AMMINISTRATORE = 1";
            $result = $connection->query($sql);
            while($row = $result->fetch_assoc()) {
                if($row["ID"] != $_SESSION["user_id"]) {
                    header("location: profilo.php?ID=" . $id);
                }else{
                    header("location:amministratore.php");
                }
            }
            
        }else{
            echo '<script>alert("Password non corrispondono"); window.location.href = "update_profilo.php";</script>';
        }


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
        <a href='profilo.php?ID=<?php echo $_SESSION["user_id"] ?>' class='profilo-button'>
            <img src='profilo-icona.png' alt='Profilo' class='profilo-icona'>
        </a>
    </header>

    <main>
    <form method="POST" action="">

        <h1>Profilo utente</h1>
        
        <label for name="NOME">Nome: </label>
        <input type="text" name="NOME"> <br><br> 

        <label for name="COGNOME">Cognome: </label>
        <input type="text" name="COGNOME"> <br><br> 

        <label for name="USERNAME">Username: </label>
        <input type="text" name="USERNAME"> <br><br> 

        <label for name="EMAIL">Email: </label>
        <input type="email" name="EMAIL"> <br><br> 

        <label for name="PASSWORD">Password: </label>
        <input type="password" name="PASSWORD"> <br><br> 

        <label for name="PASSWORD">Conferma password: </label>
        <input type="password" name="PASSWORD2"> <br><br> 

        <button type="submit" name="Modifica">Modifica</button>
        <button type="reset" name="ANNULLA">Cancella</button>
        <button type="button" onclick="location.href='profilo.php?ID= <?php echo $_SESSION['user_id']    ?>';">Ritorna</button>



    </form>
    </main>

    <footer>
        <p>&copy; Info Women</p>
    </footer>";

</body>
</html>