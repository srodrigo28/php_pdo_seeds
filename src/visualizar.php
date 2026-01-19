<?php

include_once './config/conn.php';

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

/* Validar ID se existe */
if (empty($id)) {
    echo "<script>  alert('ID não informado!'); </script> ";    
    echo "<script>  window.location.href = 'index.php';  </script>";
}
    
// Buscar os dados do registro pelo ID
$sql = "SELECT * FROM cadastro `cadastro` WHERE id = $id";
$stmt = $pdo->query($sql);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar se o registro foi encontrado
if (!$result) {
    echo "<script>  alert('Registro não encontrado!'); </script> ";    
    echo "<script>  window.location.href = 'index.php';  </script>";
}
// var_dump($result);
?>

<?php include_once './config/head.php'; ?>

<a href="../index.php" class="btn btn-danger m-3">Voltar</a>

<div class="bg-primary pb-3 text-white">
    <h1 class="text-center py-3" ><?= ($result['nome']) ?> <?= ($result['sobrenome']) ?> </h1>
    <h3 class="text-center"><?= ($result['datanasc'])  ?> </h3>
</div>
</body>
</html>










