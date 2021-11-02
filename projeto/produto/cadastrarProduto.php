<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="../style.css">
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script>

    $("#preco").mask({"mask": "(999) 999-9999"});
    </script>
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
    if(isset($_GET['id_categoria']))
    {
        $id_categoria = $_GET['id_categoria'];
    }
    if(isset($_GET['nome_categoria']))
    {
        $nome_categoria = $_GET['nome_categoria'];
    }
    
    if(isset($_GET['nome_produto']))
    {
        $nome_produto = $_GET['nome_produto'];
    }
    if(isset($_GET['preco_produto']))
    {
        $preco_produto = $_GET['preco_produto'];
    }
    if(isset($_GET['quantidade_produto']))
    {
        $quantidade_produto = $_GET['quantidade_produto'];
    }
    if(isset($_GET['lucro_liquido_produto']))
    {
        $lucro_liquido_produto = $_GET['lucro_liquido_produto'];
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
        <label class="label">Nome do Produto <label class="label" style="color: red;">*</label>
            <input type="text" name="nome" maxlength="255" <?php if(isset($_GET['nome_produto'])) { echo(' value="'.$nome_produto.'" '); } ?> placeholder="Digite o nome do produto">
        </label>
        <label class="label">Preço do Produto <label class="label" style="color: red;">*</label>
            <input type="number" id="preco" name="preco" min="0.00" max="1000" <?php if(isset($_GET['preco_produto'])) { echo(' value="'.$preco_produto.'" '); } ?> step=".01" placeholder="Digite o preço do produto">
        </label>
        <label class="label">Quantidade <label class="label" style="color: red;">*</label>
            <input type="number" name="quantidade" <?php if(isset($_GET['quantidade_produto'])) { echo(' value="'.$quantidade_produto.'" '); } ?> placeholder="Digite a quantidade do produto">
        </label>
        <label class="label">% Lucro Líquido <label class="label" style="color: red;">*</label>
            <input type="text" name="lucro_liquido" min="0.00" max="100" step=".01" <?php if(isset($_GET['lucro_liquido_produto'])) { echo(' value="'.$lucro_liquido_produto.'" '); } ?> placeholder="Digite o lucro líquido do produto">
        </label>
        </div>
        <div>
        <label class="label">Categoria do Produto <label class="label" style="color: red;">*</label>
            <input type="text" name="id" disabled <?php if(isset($_GET['id_categoria'])) {echo('value="'.$id_categoria.' - '.$nome_categoria.'">');} ?>
        </label>
        <input type="hidden" name="id_categoria" value="<?php if(isset($_GET['id_categoria'])) { echo($id_categoria); }?>">
        <?php if(isset($_GET['origem'])) {
            echo '<input type="hidden" name="origem" value="'. $_GET['origem'] .'">';
            } ?>
        <button class="btnAzul" name="selecionarcategoriaproduto" type="submit">Selecionar a Categoria</button>
        </div>
        <div>
        <button type="submit" name="cadastrar" class="btnEnviar">Cadastrar</button>
        </div>
    </form>
</body>
</html>