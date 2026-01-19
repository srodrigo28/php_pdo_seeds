<?php // v4.1
declare(strict_types=1);

session_start();
require('./src/config/conn.php');

// =======================
// Flash messages (1 vez)
// =======================
$flashSuccess = $_SESSION['flash_success'] ?? null;
$flashError   = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash_success'], $_SESSION['flash_error']);

// =======================
// Buscar clientes
// =======================
try {
    $sql  = "SELECT id, nome, sobrenome, datanasc FROM cadastro ORDER BY nome ASC";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Observação:
    // fetchAll() retorna array (vazio se não tiver registros). Não retorna false.
} catch (PDOException $e) {
    // Em produção, evite mostrar erro técnico
    $flashError = 'Erro ao buscar clientes cadastrados.';
    $result = [];
}

include_once './src/config/head.php';
?>

<div class="bg-primary text-white py-2">
    <h1 class="text-center">Cadastro Cliente</h1>
</div>

<!-- =======================
     Mensagens (flash)
======================= -->
<div class="w-75 mx-auto mt-3" id="flash-container">
    <?php if (!empty($flashSuccess)): ?>
        <div class="alert alert-success flash-message" role="alert">
            <?= htmlspecialchars($flashSuccess, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($flashError)): ?>
        <div class="alert alert-danger flash-message" role="alert">
            <?= htmlspecialchars($flashError, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>
</div>

<form action="./src/cadastrar-v3.php" method="POST" class="d-flex flex-row w-50 mx-auto my-4 gap-3">
    <input
        type="text"
        name="nome"
        id="nome"
        autocomplete="off"
        class="form-control my-2"
        placeholder="Nome"
        required>

    <input
        type="text"
        name="sobrenome"
        id="sobrenome"
        autocomplete="off"
        class="form-control my-2"
        placeholder="Sobrenome"
        required>

    <input
        type="date"
        name="datanasc"
        id="datanasc"
        autocomplete="off"
        class="form-control my-2 w-25 text-center"
        required>

    <input type="submit" value="Cadastrar" class="btn btn-primary my-2 mx-2">
</form>

<div>
    <h2 class="text-center">Lista Cadastrados</h2>

    <table class="w-75 table table-responsive mx-auto my-4">
        <thead>
            <tr>
                <th>Nome</th>
                <th class="text-center">Data Nasc</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>

        <tbody class="scroll-primary">
            <!-- CASO NÃO TENHA REGISTROS -->
            <?php if (empty($result)): ?>
                <tr>
                    <td colspan="3" class="text-center text-muted py-4">
                        Nenhum cliente cadastrado ainda.
                    </td>
                </tr>
                <!-- TEM REGISTROS -->
                <?php else: foreach ($result as $row): ?>
                    <?php
                    $id = (int) ($row['id'] ?? 0);

                    // Exibição segura de nome e sobrenome
                    $nomeExibir = trim(($row['nome'] ?? '') . ' ' . ($row['sobrenome'] ?? ''));
                    $nomeExibir = htmlspecialchars($nomeExibir, ENT_QUOTES, 'UTF-8');

                    // Data segura
                    $dataRaw = $row['datanasc'] ?? '';
                    $dataExibir = '';
                    if (!empty($dataRaw)) {
                        $ts = strtotime($dataRaw);
                        $dataExibir = $ts ? date('d/m/Y', $ts) : '';
                    }
                    ?>
                    <tr>
                        <?php $nome = mb_convert_case($nomeExibir, MB_CASE_TITLE, 'UTF-8');
                        ?>
                        <td class="w-50"><?= $nome ?></td>

                        <td class="text-center w-25">
                            <?= htmlspecialchars($dataExibir) ?>
                        </td>

                        <td class="text-center">
                            <a class="btn btn-sm btn-primary" href="./src/visualizar.php?id=<?= $id ?>">Ver</a>
                            <a class="btn btn-sm btn-warning text-white" href="./src/editar.php?id=<?= $id ?>">Editar</a>
                            <a class="btn btn-sm btn-danger" href="./src/deletar.php?id=<?= $id ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const messages = document.querySelectorAll('.flash-message');

        if (!messages.length) return;

        // Tempo visível da mensagem (ms)
        const DISPLAY_TIME = 1000;
        // Tempo da animação de saída (ms)
        const FADE_TIME = 500;

        setTimeout(() => {
            messages.forEach(msg => {
                msg.style.transition = `opacity ${FADE_TIME}ms ease`;
                msg.style.opacity = '0';

                setTimeout(() => {
                    msg.remove();
                }, FADE_TIME);
            });
        }, DISPLAY_TIME);
    });
</script>
</body>
</html>