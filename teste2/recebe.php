<?php
    if(isset($_POST["nome"])){

        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $senhaConf = $_POST["senhaConf"];
        $tel = $_POST["tel"];
        $emailCont = $_POST["emailCont"];

        $url = "localhost:3306";
        $user = "root";
        $key = "cniaraguari85";
        $db = "dbconta";

        $con = new mysqli($url,$user,$key,$db);

        $cadastro = "INSERT INTO `usuario` (`id`,`nome`,`email`,`senha`,`tel`,`email_contato`) VALUES (NULL, '$nome','$email','$senha','$tel','$emailCont')";

        $cadastro = mysqli_query($con,$cadastro);

        $id = mysqli_insert_id($con);

        if(mysqli_affected_rows($con)){
            echo "<ul class='list-group list-group-horizontal'>".
            "<li class='list-group-item'>#</li>".
            "<li class='list-group-item'>Nome</li>".
            "<li class='list-group-item'>Email</li>".
            "<li class='list-group-item'>Senha</li>".
            "<li class='list-group-item'>Telefone</li>".
            "<li class='list-group-item'>Email-Contato</li>".
            "</ul>".
            "<ul class='list-group list-group-horizontal'>".
            "<li class='list-group-item'>$id</li>".
            "<li class='list-group-item'>$nome</li>".
            "<li class='list-group-item'>$email</li>".
            "<li class='list-group-item'>$senha</li>".
            "<li class='list-group-item'>$tel</li>".
            "<li class='list-group-item'>$emailCont</li>".
            "</ul>";
        }
    }

?>

