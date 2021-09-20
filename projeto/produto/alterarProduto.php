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
        <a href="../index.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>


    <!--<button type="submit" class="btnBuscarProdutos"><img src="/img/logo.png" height="30px" width="30px"> </img>Buscar Produtos</button>-->    
    <h1>Alterar Produto</h1>

    <form action="">
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
            <input type="text" name="nome" placeholder="Digite o lucro líquido do produto">
        </label>
        </div>
        <div>
        <label class="label">Categoria do Produto
            <input type="text" name="categoria" placeholder="Selecione a categoria do produto">
        </label>
        <button class="btnAzul">Selecionar a Categoria</button>
        <button class="btnAzul">Cadastrar a Categoria</button>
        </div>
        <div>
        <button type="submit" class="btnEnviar">Cadastrar</button>
        </div>
    </form>
    
</body>
</html>