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
        <li><a href="cadastrarProduto.php">Cadastrar Produto</a></li>
        <li><a href="visualizarProdutos.php" class="active">Visualizar Produtos</a></li>
        <a href="../inicio.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>


    <!--<button type="submit" class="btnBuscarProdutos"><img src="/img/logo.png" height="30px" width="30px"> </img>Buscar Produtos</button>-->    
    <h1>Alterar Produto</h1>


    <?php 

include_once "../classes/Produto.php";
include_once "../classes/Categoria.php";
include_once "../classes/Banco.php";

if (isset($_GET['id_categoria'])) {
    $id_categoria = $_GET['id_categoria'];
}
if (isset($_GET['nome_categoria'])) {
    $nome_categoria = $_GET['nome_categoria'];
}
    
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

    $produto = Produto::pegarProduto($link, $id);

    $nome = $produto[1];
    $preco = $produto[2];
    $quantidade = $produto[3];
    $lucro_liquido = $produto[4];
    $id_categoria = $produto[5];
    $inativado = $produto[6];

    $categoria = Categoria::pegarCategoria($link, $id_categoria);
    $categoriaTexto = $categoria[0] . " - " . $categoria[1];
    ?>

    <form action="../classes/Produto.php" method="POST">
        <div>
        <label class="label">Nome do Produto <label class="label" style="color: red;">*</label>
            <input type="text" name="nome" value=" <?php echo $nome ?>" placeholder="Digite o nome do produto">
        </label>
        <label class="label">Preço do Produto <label class="label" style="color: red;">*</label>
            <input type="text" name="preco" value=" <?php echo $preco ?>" placeholder="Digite o preço do produto">
        </label>
        <label class="label">Quantidade <label class="label" style="color: red;">*</label>
            <input type="text" name="quantidade" min="1" max="1000" step="1" value=" <?php echo $quantidade ?>" placeholder="Digite a quantidade do produto">
        </label>
        <label class="label">% Lucro Líquido <label class="label" style="color: red;">*</label>
            <input type="text" name="lucro_liquido" min="0.00" max="100" step=".01" value=" <?php echo $lucro_liquido ?>" placeholder="Digite o lucro líquido do produto">
        </label>
        </div>
        <div>
        <label class="label">Categoria do Produto <label class="label" style="color: red;">*</label>
            <input type="text" name="id" disabled <?php if(isset($_GET['id_categoria'])) {echo('value="'.$id_categoria.' - '.$nome_categoria.'">');} ?>
        </label>
        <input type="hidden" name="id_categoria" value="<?php if(isset($_GET['id_categoria'])) { echo($id_categoria); }?>">
        <?php if(isset($_GET['origem'])) {
            echo '<input type="hidden" name="origem" value="'. $_GET['origem'] .'">';
            }
            echo '<input type="hidden" name="alteracao" value="1">';
            echo '<input type="hidden" name="id_produto" value="'.$id.'">';
        ?>
        <button class="btnAzul" name="selecionarcategoriaproduto" type="submit">Selecionar a Categoria</button>
        </div>
        <button type="submit" name="alterarconfirma" class="btnEnviar">Cadastrar</button>
        </div>
    </form>
    
</body>
</html>