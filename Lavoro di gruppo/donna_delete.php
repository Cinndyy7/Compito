<?php

    include "connection.php";

    $sql="DELETE FROM DONNE WHERE ID=" . $_GET['ID'];
    echo $sql;
    $connection->query($sql);

    header("location:amministratore.php");

    $connection->close();


?>