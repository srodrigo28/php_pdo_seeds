<?php

include_once './config/conn.php';

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

if (empty($id)) {
    echo "<script>  alert('ID não informado!'); </script> ";    
    echo "<script>  window.location.href = 'index.php';  </script>";
}
    
$sql = "SELECT * FROM cadastro `cadastro` WHERE id = $id";
$stmt = $pdo->query($sql);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    echo "<script>  alert('Registro não encontrado!'); </script> ";    
    echo "<script>  window.location.href = 'index.php';  </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>