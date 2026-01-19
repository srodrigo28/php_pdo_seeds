<?php
// Cadastro V3 - 18/01/2026
// Objetivo: validar, impedir duplicidade, inserir e redirecionar com feedback (flash message).

declare(strict_types=1);

session_start(); // necessário para usar mensagens flash (sucesso/erro)

require_once './config/conn.php'; // preferível ao include_once (falha caso não exista)

// ===============================
// 1) Captura e sanitização básica
// ===============================
$nome      = trim((string) filter_input(INPUT_POST, 'nome', FILTER_DEFAULT));
$sobrenome = trim((string) filter_input(INPUT_POST, 'sobrenome', FILTER_DEFAULT));
$datanasc  = trim((string) filter_input(INPUT_POST, 'datanasc', FILTER_DEFAULT));

// ==================================
// 2) Validação de campos obrigatórios
// ==================================
if ($nome === '' || $sobrenome === '' || $datanasc === '') {
    $_SESSION['flash_error'] = 'Todos os campos são obrigatórios.';
    header('Location: ../index.php');
    exit;
}

// ==================================
// 3) Normaliza data para YYYY-MM-DD
//    Evita duplicidade por formatos diferentes
// ==================================
$ts = strtotime(str_replace('/', '-', $datanasc));
if ($ts === false) {
    $_SESSION['flash_error'] = 'Data de nascimento inválida.';
    header('Location: ../index.php');
    exit;
}
$datanasc = date('Y-m-d', $ts);

// ==================================================
// 4) Regras de unicidade: nome + sobrenome + datanasc
//    (Sugestão: reforçar com UNIQUE no banco também)
// ==================================================
try {   // 4.1) Verifica se já existe (usando FETCH, mais confiável que rowCount em SELECT)
        // Regra se existe mesmo nome e sobrenome ideial seria também data de nascimento
    $sqlCheck = "SELECT id  FROM cadastro  
                    WHERE LOWER(TRIM(nome)) = LOWER(TRIM(:nome)) 
                    AND LOWER(TRIM(sobrenome)) = LOWER(TRIM(:sobrenome)) 
                LIMIT 1  ";

    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([ ':nome'      => $nome, ':sobrenome' => $sobrenome ]);

    $existe = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    // Se já existe, não cadastra e retorna mensagem
    if ($existe) {
        $_SESSION['flash_error'] = 'Cliente já cadastrado!';
        header('Location: ../index.php');
        exit;
    }

    // 4.2) Insere (cliente não existe)
    $sqlInsert = "
        INSERT INTO cadastro (nome, sobrenome, datanasc)
        VALUES (:nome, :sobrenome, :datanasc)
    ";

    $stmtInsert = $pdo->prepare($sqlInsert);
    $stmtInsert->execute([
        ':nome'      => $nome,
        ':sobrenome' => $sobrenome,
        ':datanasc'  => $datanasc,
    ]);

    // 4.3) Sucesso: flash + redirect
    $_SESSION['flash_success'] = 'Cliente cadastrado com sucesso!';
    header('Location: ../index.php');
    exit;

} catch (PDOException $e) {
    // Erro genérico para o usuário (não expõe detalhes do banco)
    $_SESSION['flash_error'] = 'Erro ao cadastrar cliente. Tente novamente.';
    header('Location: ../index.php');
    exit;

    // Para debug local, você pode registrar log (recomendado):
    // error_log('Erro cadastro: ' . $e->getMessage());
}
