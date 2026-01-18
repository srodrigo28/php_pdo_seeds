<?php
    require('./src/config/conn.php');

    $sql = "SELECT * FROM cadastro";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($result === false){
        echo "<script>
                alert('Erro ao buscar clientes cadastrados');
                setTimeout(function(){
                    window.location.href = 'index.php';
                }, 400);
              </script>";
        exit;
    }

    $stmt->execute();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link 
        rel="stylesheet" 
        crossorigin="anonymous" 
        referrerpolicy="no-referrer"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" 
        integrity="sha512-t4GWSVZO1eC8BM339Xd7Uphw5s17a86tIZIj8qRxhnKub6WoyhnrxeCIMeAqBPgdZGlCcG2PrZjMc+Wr78+5Xg==" 
    />
    <script 
        defer
        crossorigin="anonymous" 
        referrerpolicy="no-referrer">
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js" 
        integrity="sha512-3dZ9wIrMMij8rOH7X3kLfXAzwtcHpuYpEgQg1OA4QAob1e81H8ntUQmQm3pBudqIoySO5j0tHN4ENzA6+n2r4w==" 
    </script>
    <script 
        defer
        crossorigin="anonymous" 
        referrerpolicy="no-referrer">
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" 
        integrity="sha512-VK2zcvntEufaimc+efOYi622VN5ZacdnufnmX7zIhCPmjhKnOi9ZDMtg1/ug5l183f19gG1/cBstPO4D8N/Img==" 
    </script>
</head>
<body>

    <h1 class="text-center mt-5">Cadastro Cliente</h1>

    <form action="./src/cadastrar.php" method="POST" class="d-flex flex-column w-50 mx-auto my-5 gap-3">
        <input type="text" name="nome"      id="nome"       autocomplete="off"  class="form-control my-2">
        <input type="text" name="sobrenome" id="sobrenome"  autocomplete="off"  class="form-control my-2">
        <input type="date" name="datanasc"  id="datanasc"   autocomplete="off"  class="form-control my-2">
        
        <input type="submit" value="Cadastrar" class="btn btn-primary my-2 mx-2">
    </form>

    <div>
        <h2 class="text-center">Clientes Cadastrados</h2>
        <ul class="list-group">
            <?php foreach($result as $row): ?>
                <li class="list-group-item">
                    <?php 
                        echo "ID: " . $row['id'] . " | Nome: " . $row['nome'] . " | Sobrenome: " . $row['sobrenome'] . " | Data de Nascimento: " . $row['datanasc'];
                    ?>
                </li>
            <?php endforeach; ?>
    </div>
    
</body>
</html>