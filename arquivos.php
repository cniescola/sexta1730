<?php
    $host = "localhost:3306";
    $user = "root";
    $senha = "cniaraguari85";
    $db = "login";

    $con = new mysqli( $host, $user, $senha,$db);

    if($con->connect_error){
        echo "deu zebra";
    }

?>