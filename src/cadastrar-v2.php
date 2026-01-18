<?php

$nome      = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
$sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_DEFAULT);
$datanasc  = filter_input(INPUT_POST, 'datanasc', FILTER_DEFAULT);

try {
    include_once './config/conn.php';

    // Validação: se faltar algo, avisa e redireciona depois de 2s
    if (empty($nome) || empty($sobrenome) || empty($datanasc)) {
        echo "<script>
                alert('Todos os campos são obrigatórios!');
                setTimeout(function(){
                    window.location.href = '../index.php';
                }, 400);
              </script>";
        exit; // <-- IMPORTANTÍSSIMO: para o PHP aqui
    }

    // Inserção
    $sql = "INSERT INTO cadastro (nome, sobrenome, datanasc)
            VALUES (:nome, :sobrenome, :datanasc)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':sobrenome', $sobrenome);
    $stmt->bindParam(':datanasc', $datanasc);
    $stmt->execute();

    // Sucesso + redirect com delay (sem header)
    echo "<script>
            alert('Cliente cadastrado com sucesso!');
            setTimeout(function(){
                window.location.href = '../index.php';
            }, 400);
          </script>";
    exit;

} catch (PDOException $e) {
    echo "<script>alert('Erro ao cadastrar cliente');</script>";
    // Para debug:
    echo "Erro ao cadastrar cliente: " . $e->getMessage();
    exit;
}