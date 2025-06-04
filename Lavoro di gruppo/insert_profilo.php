<?php

    include "connection.php";

    if(isset($_POST['NOME']) && isset($_POST['COGNOME'])&& isset($_POST['USERNAME'])&& isset($_POST['EMAIL'])&& isset($_POST['PASSWORD'])){
        $nome=$_POST['NOME'];
        $cognome=$_POST['COGNOME'];
        $email=$_POST['EMAIL'];
        $password=$_POST['PASSWORD'];
        $username=$_POST['USERNAME'];
    
        $sql="SELECT ID,USERNAME FROM UTENTI WHERE EMAIL= " . "'" . $email . "'" ; 
        echo $sql;
        // if ($connection->query($sql) === FALSE) {
        //     echo "Errore: " . $connection->error;
        // }
        $result=$connection->query($sql);

        echo"". $result->num_rows ."";
        
        if($result->num_rows >0){
            echo '<script>alert("Email già registrato..."); window.location.href = "login.php";</script>';

        }else{
            //INSERT

            $sql="INSERT INTO UTENTI (NOME,COGNOME,EMAIL,USERNAME,PASSWORD) VALUES (" . 
                    " '" . $nome . "' ," .  
                    " '" . $cognome . "' ," .
                    " '" . $email . "' ," .  
                    " '" . $username . "' ," .
                    " '" . md5($password) . "' )";

            echo $sql;
            $connection->query($sql);
            header("location:login.php");
    }


}
    $connection -> close();

?>