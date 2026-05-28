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

        $host = "localhost:3306";
        $user = "root";
        $key = "cniaraguari85";
        $db = "dbteste";

        $con = new mysqli($host,$user,$key,$db);
        $cadastra = "INSERT INTO `produtos` (`id`, `nomeProd`, `linkProd`, `descProd`, `precoCustProd`, `porcentProd`, `precoProd`, `metaProd`, `divdProd`, `smsProd`) VALUES (NULL, '$nomeProd', '$linkProd', '$descProd', '$precoCustProd', '$porcentProd', '$precoProd', '$metaProd', '$divdProd', '$smsProd')";

        $cadastra = mysqli_query($con,$cadastra);

        if(mysqli_affected_rows($con)){
            echo "<div>$nomeProd</div>";
        }else{
            echo "informação não cadastrada";
        }

        
    }
?>