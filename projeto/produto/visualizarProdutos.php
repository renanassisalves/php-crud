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
        <li><a href="visualizarProdutos.php" class="active">Visualizar produtos</a></li>
        <a href="../index.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <h1>Visualizar Produtos</h1>
    <table style="width: 100%">
        <tr>
            <td class="headerListagem">ID</td>
            <td class="headerListagem">Nome do Produto</td>
            <td class="headerListagem">Categoria</td>
            <td class="headerListagem">Preço (R$)</td>
            <td class="headerListagem">Quantidade</td>
            <td class="headerListagem">
                
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>Produto Exemplo 1</td>
            <td>Categoria Exemplo 1</td>
            <td>R$19,99</td>
            <td>30</td>
            <td style="max-width: 60px; min-width: 60px;">
                <a href="/index.php" class="btnEditar"><img src="../img/lapis.png" class="btnEditar" width="40px" height="40px"></a>
                <a href="/index.php" class="btnExcluir"><img src="../img/lixeira.png" class="btnExcluir" width="40px" height="40px"></a>
            </td>
        </tr>
        
    </table>

    
</body>
</html>