<?php
    $url = "localhost:3306";
        $user = "root";
        $key = "cniaraguari85";
        $db = "dbconta";

        $con = new mysqli($url,$user,$key,$db);


   /* db
        CREATE DATABASE dbcontas;

use dbcontas;

CREATE TABLE usuario (
        `id` INT NOT NULL auto_increment PRIMARY KEY,
        `nome` varchar(50) null,
        `email` varchar(50) not null unique,
        `senha` varchar(50) not null,
        `tel` varchar(50) null,
        `email_contato` varchar(50) null
);
        */