<?php
    require('./src/config/conn.php');

    $sql = "SELECT * FROM cadastro";
    $stmt = $pdo->query($sql);
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
?>
<?= include_once './src/config/head.php'; ?>

    <div class="bg-primary text-white p-3 py-5">
        <h1 class="text-center">Cadastro Cliente</h1>
    </div>

    <form action="./src/cadastrar.php" method="POST" class="d-flex flex-row w-50 mx-auto my-5 gap-3">
        <input type="text" name="nome"      id="nome"       autocomplete="off"  class="form-control my-2">
        <input type="text" name="sobrenome" id="sobrenome"  autocomplete="off"  class="form-control my-2">
        <input type="date" name="datanasc"  id="datanasc"   autocomplete="off"  class="form-control my-2 w-25 text-center">
        
        <input type="submit" value="Cadastrar" class="btn btn-primary my-2 mx-2">
    </form>

    <div>
        <h2 class="text-center">Lista Cadastrados</h2>

        <ul class="scroll-primary list-group w-50 mx-auto my-5">
            <?php 
                foreach ( $result as $row ) {
                    echo '<li class="list-group-item">' . $row['nome'] . '</li>'; 
                } 
                ?>
        </ul>
    </div>
</body>
</html>