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
    
    include_once './src/config/head.php';
?>

    <div class="bg-primary text-white py-2">
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

        <table class="w-75 table table-responsive mx-auto my-5">
            <thead class="">
                <tr class="">
                    <th class="">Nome</th>
                    <th class="text-center">Data Nasc</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="scroll-primary">
                <?php foreach ( $result as $row ): ?>
                <tr class="">
                    <td class="w-50"> <?=($row['nome']); ?>      </td>
                    <td class="text-center w-25"> <?=($row['datanasc']); ?>  </td>
                    <td>
                        <a class="btn bt-sm btn-primary" href="./src/visualizar.php?id=<?=($row['id']); ?>">Ver</a>
                        <a class="btn bt-sm btn-warning text-white" href="./src/editar.php?id=<?=($row['id']); ?>">Editar</a>
                        <a class="btn bt-sm btn-danger"  href="./src/deletar.php?id=<?=($row['id']); ?>">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>