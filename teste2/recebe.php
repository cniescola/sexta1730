<?php
    if(isset($_POST["nome"])){

        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $senhaConf = $_POST["senhaConf"];
        $tel = $_POST["tel"];
        $emailCont = $_POST["emailCont"];

        echo $nome."<br>".$email."<br>".$senha."<br>".$senhaConf."<br>".$tel."<br>".$emailCont."<br>";
    }

?>

