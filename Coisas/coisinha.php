<?php
    $HOST = "localhost:3306";
    $USER = "root";
    $SENHA = "cniaraguari85";
    $db = "logistica";

    $CON = new mysqli($HOST, $USER, $SENHA, $DB);
    
    if($CON->connect_error){
        echo "Deu Breno";
    }
?>