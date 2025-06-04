<?php

    include "connection.php";

    $sql="DELETE FROM COMMENTI WHERE ID=" . $_GET['COMMENTO_ID'];
    echo $sql;
    $connection->query($sql);

    header("location:Donna.php?ID=" . $_GET['DONNA_ID']);

    $connection->close();


?>