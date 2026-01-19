<?php // Cadastro V2.0 - 18/01/2026
include_once './config/conn.php';

$nome      = trim(filter_input(INPUT_POST, 'nome', FILTER_DEFAULT));
$sobrenome = trim(filter_input(INPUT_POST, 'sobrenome', FILTER_DEFAULT));
$datanasc  = trim(filter_input(INPUT_POST, 'datanasc', FILTER_DEFAULT));

// 1) Verifica existência com FETCH (mais confiável que rowCount em SELECT no MySQL)
try {
    // ADICIONADO O "FROM cadastro"
    $sqlCheck = "SELECT id FROM cadastro WHERE LOWER(TRIM(nome)) = LOWER(TRIM(:nome)) LIMIT 1";

    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([ ':nome' => $nome ]);

    $existe = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    // 🔴 Já existe
    if ($existe) {
        echo "<script>
                alert('Cliente já cadastrado!');
                window.location.href = '../index.php';
              </script>";
        exit;
    }
    // 2) Se não existe → Cadastra
    $sqlInsert = "
        INSERT INTO cadastro (nome, sobrenome, datanasc)
        VALUES (:nome, :sobrenome, :datanasc)
    ";

    $stmtInsert = $pdo->prepare($sqlInsert);
    $stmtInsert->execute([
        ':nome'      => $nome,
        ':sobrenome' => $sobrenome,
        ':datanasc'  => $datanasc
    ]);

    echo "<script>
            alert('Cliente cadastrado com sucesso!');
            window.location.href = '../index.php';
          </script>";
    exit;

} catch (PDOException $e) {
    echo "<script>
        alert('Erro ao cadastrar cliente.');
        window.location.href = '../index.php';
    </script>";
    // echo $e->getMessage(); // use só pra debug
    exit;
}