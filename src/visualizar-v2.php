<?php
declare(strict_types=1);

session_start();

require_once './config/conn.php';
require_once './config/head.php';

/*
 * 1) Captura o ID da URL com validação numérica.
 * FILTER_VALIDATE_INT garante que só entra número inteiro válido.
 */
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {  // Flash message (aparece no index) + redireciona
    $_SESSION['flash_error'] = 'ID não informado ou inválido.';
    header('Location: ../index.php');
    exit;
}

try { // 2) Busca no banco usando Prepared Statement (seguro)
    $sql = "SELECT id, nome, sobrenome, datanasc FROM cadastro WHERE id = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        $_SESSION['flash_error'] = 'Registro não encontrado.';
        header('Location: ../index.php');
        exit;
    }

} catch (PDOException $e) {
    $_SESSION['flash_error'] = 'Erro ao buscar o registro.';
    header('Location: ../index.php');
    exit; // Debug local: error_log($e->getMessage());
    
}
// 3) Preparação para exibição segura (evita XSS)
$nomeCompleto = trim(($result['nome'] ?? '') . ' ' . ($result['sobrenome'] ?? ''));
$nomeCompleto = mb_convert_case($nomeCompleto, MB_CASE_TITLE, 'UTF-8'); // capitalize elegante PT-BR
$nomeCompletoSafe = htmlspecialchars($nomeCompleto, ENT_QUOTES, 'UTF-8');

$dataRaw = $result['datanasc'] ?? '';
$dataFormatada = '';
if (!empty($dataRaw)) {
    $ts = strtotime($dataRaw);
    $dataFormatada = $ts ? date('d/m/Y', $ts) : '';
}
$dataFormatadaSafe = htmlspecialchars($dataFormatada, ENT_QUOTES, 'UTF-8');
?>

<!-- HTML -->
<a href="../index.php" class="btn btn-danger m-3">Voltar</a>

<div class="bg-primary pb-3 text-white w-50 mx-auto my-5 border rounded-4">
    <h1 class="text-center py-3"><?= $nomeCompletoSafe ?></h1>

    <!-- Exibe apenas a data formatada -->
    <h3 class="text-center"><?= $dataFormatadaSafe ?></h3>
</div>

</body>
</html>