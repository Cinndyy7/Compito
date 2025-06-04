<?php

    include "connection.php";

    session_start();

    if (!isset($_SESSION["user_id"])) {
        echo '<script>alert("Accesso non autorizzato"); window.location.href = "donne.php";</script>';
    }

    if(isset($_POST['COMMENTO']) && isset($_POST['VALUTAZIONE'])){
        
        
        $commento=$_POST['COMMENTO'];
        $valutazione=$_POST['VALUTAZIONE'];
    

        $sql = "INSERT INTO COMMENTI (ID_UTENTE,ID_DONNA,DATA_ORA,VALUTAZIONE,COMMENTO) VALUES (
                " .  $_SESSION["user_id"] . "," .
                "" .  $_GET["ID"] . "," .
                "'" .  date("Y-m-d H:i:s") . "'," .
                "" .  $valutazione . "," .
                "'" .  $commento . "')";

        echo  $sql;
        $connection->query($sql);

        header("location:Donna.php?ID=" . $_GET['ID']);

    }
    
    $sql = "SELECT NOME, COGNOME FROM DONNE WHERE ID = " . $_GET['ID'];
    $result=$connection->query($sql);
    $donna =$result->fetch_assoc();
    
    $connection -> close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commenta</title>
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

    
    .profilo-button {
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

    .comment-form {
        max-width: 600px;
        margin: 2rem auto;
        padding: 2rem;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    label {
        display: block;
        margin-bottom: 0.5rem;
    }
    
    select, textarea {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
</style>

<body>

    <header>
        <a href='donne.php' class='logo-button'>
            <img src='logo.png' alt='Logo del sito' class='logo'>
        </a>
        <h1 class='titolo'>Donne nell'informatica</h1>
        <a href='profilo.php?ID=<?php echo $_SESSION["user_id"] ?>' class='profilo-button'>
            <img src='profilo-icona.png' alt='Profilo' class='profilo-icona'>
        </a>
        
    </header>

    <div class="comment-form">
        <h2>Commenta <?= $donna['NOME'] ?> <?= $donna['COGNOME'] ?></h2>
        
        <form method="POST">
            <input type="hidden" name="donna_id" value="<?= $_GET["ID"] ?>">
            
            <div class="form-group">
                <label>Valutazione (1-5 stelle)</label>
                <select name="VALUTAZIONE" required>
                    <option value="1">1 Stella</option>
                    <option value="2">2 Stelle</option>
                    <option value="3">3 Stelle</option>
                    <option value="4">4 Stelle</option>
                    <option value="5">5 Stelle</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Commento</label>
                <textarea name="COMMENTO" rows="5" required></textarea>
            </div>
            
            <button type="submit">Invia Commento</button>
        </form>
    </div>
    <footer>
        <p>&copy; Info Women</p>
    </footer>";

</body>
</html>