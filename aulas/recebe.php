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

        echo $nomeProd."<br>".$linkProd."<br>".$descProd."<br>".$precoCustProd."<br>".$porcentProd."<br>".$precoProd."<br>".$metaProd."<br>".$divdProd."<br>";
    }
?>