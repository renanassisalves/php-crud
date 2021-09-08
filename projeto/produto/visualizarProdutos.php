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
        <li><a href="cadastrarProduto.php"">Cadastrar Produto</a></li>
        <li><a href="alterarProduto.php">Alterar Produto</a></li>
        <li><a href="excluirProduto.php">Excluir Produto</a></li>
        <li><a href="../categoria/cadastrarCategoria.php">Cadastrar Categoria</a></li>
        <li><a href="../fornecedor/cadastrarFornecedor.php">Cadastrar Fornecedor</a></li>
        <li><a href="visualizarProdutos.php" class="active">Visualizar produtos</a></li>
        <a href="../index.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <!-- <h1>Listagem de produtos</h1>
<div class="backgroundListagem">
    <div class="itemListagem">
        <div class="headerListagem">Nome Produto</div>
        <div class="headerListagem">Preço Produto</div>
        <div class="headerListagem">Quantidade Produto</div>
        <div class="headerListagem">% Lucro Produto</div>
        <div class="headerListagem">Fornecedor Produto</div>
        <div class="headerListagem">Categoria Produto</div>
        <div class="headerListagem">Editar/Excluir</div>
        
    </div>
    <div class="itemListagem">
        <div class="colunaListagem">Produto exemplo 1</div>
        <div class="colunaListagem">Preço exemplo 1</div>
        <div class="colunaListagem">Quantidade exemplo 1</div>
        <div class="colunaListagem">% lucro exemplo 1</div>
        <div class="colunaListagem">Fornecedor exemplo 1</div>
        <div class="colunaListagem">Categoria exemplo 1</div>
        <div class="colunaListagem">
            <a href="../index.php" class="btnEditar"><img src="../img/lapis.png" class="btnEditar" width="30px" height="30px"></a>
            <a href="../index.php" class="btnExcluir"><img src="../img/lixeira.png" class="btnExcluir" width="30px" height="30px"></a>
        </div>
        
    </div>
    
    <div class="itemListagem">
        <div class="colunaListagem">Produto exemplo 2</div>
        <div class="colunaListagem">Preço exemplo 2</div>
        <div class="colunaListagem">Quantidade exemplo 2</div>
        <div class="colunaListagem">% lucro exemplo 2</div>
        <div class="colunaListagem">Fornecedor exemplo 2</div>
        <div class="colunaListagem">Categoria exemplo 2</div>
        <div class="colunaListagem">
            <a href="../index.php" class="btnEditar"><img src="../img/lapis.png" class="btnEditar" width="30px" height="30px"></a>
            <a href="../index.php" class="btnExcluir"><img src="../img/lixeira.png" class="btnExcluir" width="30px" height="30px"></a>
        </div>
    </div>
    <div class="itemListagem">
        <div class="colunaListagem">Produto exemplo 3</div>
        <div class="colunaListagem">Preço exemplo 3</div>
        <div class="colunaListagem">Quantidade exemplo 3</div>
        <div class="colunaListagem">% lucro exemplo 3</div>
        <div class="colunaListagem">Fornecedor exemplo 3</div>
        <div class="colunaListagem">Categoria exemplo 3</div>
        <div class="colunaListagem">
            <a href="../index.php" class="btnEditar"><img src="../img/lapis.png" class="btnEditar" width="30px" height="30px"></a>
            <a href="../index.php" class="btnExcluir"><img src="../img/lixeira.png" class="btnExcluir" width="30px" height="30px"></a>
        </div>
    </div>
</div> -->

    <!--<button type="submit" class="btnBuscarProdutos"><img src="/img/logo.png" height="30px" width="30px"> </img>Buscar Produtos</button>-->    
    <h1>Visualizar Produtos</h1>
    <table style="width: 100%">
        <tr>
            <td class="headerListagem">Nome do Produto</td>
            <td class="headerListagem">Categoria</td>
            <td class="headerListagem">Fornecedor</td>
            <td class="headerListagem">Preço (R$)</td>
            <td class="headerListagem">Quantidade</td>
            <td class="headerListagem">
                
            </td>
        </tr>
        <tr>
            <td>Produto Exemplo 1</td>
            <td>Categoria Exemplo 1</td>
            <td>Fornecedor Exemplo 1</td>
            <td>R$19,99</td>
            <td>30</td>
            <td style="max-width: 60px; min-width: 60px;">
                <a href="/index.php" class="btnEditar"><img src="/img/lapis.png" class="btnEditar" width="40px" height="40px"></a>
                <a href="/index.php" class="btnExcluir"><img src="/img/lixeira.png" class="btnExcluir" width="40px" height="40px"></a>
            </td>
        </tr>
        <tr>
            <td>Produto Exemplo 2</td>
            <td>Categoria Exemplo 2</td>
            <td>Fornecedor Exemplo 2</td>
            <td>R$19,99</td>
            <td>30</td>
            <td style="max-width: 60px; min-width: 60px;">
                <a href="/index.php" class="btnEditar"><img src="/img/lapis.png" class="btnEditar" width="40px" height="40px"></a>
                <a href="/index.php" class="btnExcluir"><img src="/img/lixeira.png" class="btnExcluir" width="40px" height="40px"></a>
            </td>
        </tr>
        <tr>
            <td>Produto Exemplo 3</td>
            <td>Categoria Exemplo 3</td>
            <td>Fornecedor Exemplo 3</td>
            <td>R$19,99</td>
            <td>30</td>
            <td style="max-width: 60px; min-width: 60px;">
                <a href="/index.php" class="btnEditar"><img src="/img/lapis.png" class="btnEditar" width="40px" height="40px"></a>
                <a href="/index.php" class="btnExcluir"><img src="/img/lixeira.png" class="btnExcluir" width="40px" height="40px"></a>
            </td>
        </tr>
    </table>

    
</body>
</html>