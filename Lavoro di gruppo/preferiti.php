<?php

    session_start();

    include "connection.php";

    if(isset($_GET['ID'])) {
        $id_donna=$_GET["ID"];
        $id_utente=$_SESSION["user_id"];
    
        $sql="INSERT INTO UTENTI_DONNE (ID_UTENTE,ID_DONNA,PREFERITI) VALUES (" . $id_utente . "," . $id_donna . ",1)"; 
        echo $sql;
        if ($connection->query($sql) === FALSE) {
            echo "Errore: " . $connection->error;
        }


    header("location:Donna.php?ID=" . $_GET['ID']);
}
    $connection -> close();

?>