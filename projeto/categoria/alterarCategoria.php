<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Categoria</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <ul>
        <img src="../img/logo.png" class="logo" alt="Exemplo de logomarca" width="60" height="60">
        <li><a href="#" class="active">Cadastrar Categoria</a></li>
        <li><a href="visualizarCategorias.php">Visualizar Categorias</a></li>
        <a href="../index.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <!--<button type="submit" class="btnBuscarProdutos"><img src="/img/logo.png" height="30px" width="30px"> </img>Buscar Produtos</button>-->    
    <h1>Alterar Categoria</h1>

    <?php
    include_once "../classes/Categoria.php";
    include_once "../classes/Banco.php";
    $id = $_GET['id'];
    $categoria = Categoria::pegarCategoria($link, $id);
    ?>


    <form action="../classes/Categoria.php" method="POST">
        <div>
        <label class="label">Nome
            <input type="text" name="nome" maxlength="255" value="<?php echo $categoria[1] ?>">
        </label>
        <?php
        echo '<input type="hidden" name="id" value=' . $id . '>';
        ?>
        </div>
        <div>
        <button type="submit" name="alterarconfirma" class="btnEnviar">Alterar</button>
        </div>
    </form>
    
</body>
</html>