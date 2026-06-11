<?php
    if(isset($_POST['nomeProd'])){
        
        $nomeProd =$_POST["nomeProd"];
        $linkProd =$_POST["linkProd"];
        $descProd =$_POST["descProd"];
        $precoCustProd =$_POST["precoCustProd"];
        $porcentProd =$_POST["porcentProd"];
        $precoProd =$_POST["precoProd"];
        $metaProd =$_POST["metaProd"];
        $divdProd =$_POST["divdProd"];
        $smsProd =$_POST["smsProd"];

        include "conexao.php";
        $cadastra = "INSERT INTO `prods` (`id`, `nome`, `link`, `desc`, `PC`, `percent`, `PP`) VALUES (NULL, '$nomeProd', '$linkProd', '$descProd', '$precoCustProd', '$porcentProd', '$precoProd')";

        $cadastra = mysqli_query($con,$cadastra);

        if(mysqli_affected_rows($con)){
            echo "<div>$nomeProd</div>";
        }else{
            echo "informação não cadastrada";
        }

        
    }
?>