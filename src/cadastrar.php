<?php
include_once './config/conn.php';

$nome      = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
$sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_DEFAULT);
$datanasc  = filter_input(INPUT_POST, 'datanasc', FILTER_DEFAULT);

try {
    $sql = "INSERT INTO `cadastro`(nome, sobrenome, dataanasc) VALUES ('$nome', '$sobrenome', '$datanasc')";
    $stmt = $pdo->prepare($sql);
    // $stmt->execute();

} catch (PDOException $e) {
    echo "<script>alert('Erro ao cadastrar cliente');</script>";
    // Para debug:
    echo "Erro ao cadastrar cliente: " . $e->getMessage();
    exit;
}