<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrati</title>
</head>

<?php

    include "connection.php";

    session_start();
    session_unset();


    if(isset($_POST['EMAIL']) && isset($_POST['PASSWORD'])){

        $email=$_POST['EMAIL'];
        $password=$_POST['PASSWORD'];

        $sql="SELECT ID,USERNAME,AMMINISTRATORE FROM UTENTI WHERE EMAIL= " . "'" . $email . "' AND PASSWORD= " . "'" . md5($password) . "'" ; 
        echo $sql;
        // if ($connection->query($sql) === FALSE) {
        //     echo "Errore: " . $connection->error;
        // }
        $result=$connection->query($sql);

        echo"". $result->num_rows ."";
        
        if($result->num_rows >0){
            $recordset=$result->fetch_assoc();

            //LOGIN OK

            $_SESSION['user_id']=$recordset['ID']; // mette id nel user_id
            $_SESSION['username']=$recordset['USERNAME'];

            // echo $recordset["AMMINISTRATORE"];

            if($recordset['AMMINISTRATORE']== 1){
                header("location: amministratore.php");
            }else{
                header("location: Donne.php");
            }
            
        }else{
            header("location: login.php");
            
        }

    }



?>



<body>
</body>
</html>