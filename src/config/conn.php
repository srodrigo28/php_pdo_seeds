<?php

 try{
    $pdo = new PDO('mysql:hostname=localhost;dbname=sistema_cadastro', 'root', '');
 }catch(PDOException $e){
    echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
 }