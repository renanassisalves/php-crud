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
        <li><a href="#" class="active">Cadastrar entrada</a></li>
        <li><a href="alterarEntrada.php">Alterar entrada</a></li>
        <li><a href="visualizarProdutos.php">Visualizar entradas</a></li>
        <a href="../index.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <!--<button type="submit" class="btnBuscarProdutos"><img src="/img/logo.png" height="30px" width="30px"> </img>Buscar Produtos</button>-->    
    <h1>Cadastrar Entrada</h1>
    <form action="../classes/Produto.php" method="POST">
        <div>
        <label class="label">Lista de produtos
            <input type="text" name="nome" placeholder="Digite o nome do produto">
            FAZER A LISTAGEM DE PRODUTOS<br>
        </label>

        </div>
        <div>
        <label class="label">Fornecedor do Produto
            <input type="text" name="id_fornecedor" placeholder="Selecione o fornecedor do produto">
        </label>
        
        <button class="btnAzul">Selecionar o Fornecedor</button>
        <button class="btnAzul" onclick="location.href='../fornecedor/cadastrarFornecedor.php'" type="button">Cadastrar o Fornecedor</button>
        </div>
        <div>
        <button type="submit" name="cadastrar" class="btnEnviar">Cadastrar</button>
        </div>
    </form>
    
</body>
</html>