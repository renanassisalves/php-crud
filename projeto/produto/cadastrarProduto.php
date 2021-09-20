<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <ul>
        <img src="../img/logo.png" class="logo" alt="Exemplo de logomarca" width="60" height="60">
        <li><a href="#" class="active">Cadastrar Produto</a></li>
        <li><a href="visualizarProdutos.php">Visualizar produtos</a></li>
        <a href="../index.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <!--<button type="submit" class="btnBuscarProdutos"><img src="/img/logo.png" height="30px" width="30px"> </img>Buscar Produtos</button>-->    
    <h1>Cadastrar Produto</h1>

    <?php
    include_once "../classes/Produto.php";
    include_once "../classes/Banco.php";
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
    }
    if(isset($_GET['nome']))
    {
        $nome = $_GET['nome'];
    }
    
    

    if(isset($_GET['resultado']))
    {
        $resultado = $_GET['resultado'];
        if ($resultado == 'sucesso')
        {
            echo('<div style="background-color: #b1ffb8b1;">');
            echo('<p style="color: #1a571fb1; margin: 10px;">Cadastrado com sucesso!</p>');
            echo('</div>');
        }
        else
        {
            echo('<div style="background-color: #ff9d9448;">');
            echo('<p style="color: #c51d0d; margin: 10px;">Erro : ' . $resultado . '</p>');
            echo('</div>');
        }
    }

    ?>

    <form action="../classes/Produto.php" method="POST">
        <div>
        <label class="label">Nome do Produto
            <input type="text" name="nome" placeholder="Digite o nome do produto">
        </label>
        <label class="label">Preço do Produto
            <input type="text" name="preco" placeholder="Digite o preço do produto">
        </label>
        <label class="label">Quantidade
            <input type="number" name="quantidade" placeholder="Digite a quantidade do produto">
        </label>
        <label class="label">% Lucro Líquido
            <input type="text" name="lucro_liquido" placeholder="Digite o lucro líquido do produto">
        </label>
        </div>
        <div>
        <label class="label">Categoria do Produto
            <input type="text" name="id" disabled <?php if(isset($_GET['id'])) {echo('value="'.$id.' - '.$nome.'">');} ?>
        </label>
        <input type="hidden" name="id_categoria" value="<?php if(isset($_GET['id'])) { echo($id); }?>">
        <button class="btnAzul" onclick="location.href='../categoria/selecionarCategoria.php'" type="button">Selecionar a Categoria</button>
        </div>
        <div>
        <button type="submit" name="cadastrar" class="btnEnviar">Cadastrar</button>
        </div>
    </form>
    
</body>
</html>