<?php
    if(isset($_POST["nome"])){

        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $senhaConf = $_POST["senhaConf"];
        $tel = $_POST["tel"];
        $emailCont = $_POST["emailCont"];

        include "conexao.php";
        $cadastro = "INSERT INTO `usuario` (`id`,`nome`,`email`,`senha`,`tel`,`email_contato`) VALUES (NULL, '$nome','$email','$senha','$tel','$emailCont')";

        $cadastro = mysqli_query($con,$cadastro);

        if(mysqli_affected_rows($con)){
            echo "Cadastro com sucessso";
        }
    }

?>

