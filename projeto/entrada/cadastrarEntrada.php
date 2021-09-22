<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Entrada</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <ul>
        <img src="../img/logo.png" class="logo" alt="Exemplo de logomarca" width="60" height="60">
        <li><a href="#" class="active">Cadastrar entrada</a></li>
        <li><a href="../entrada/visualizarEntradas.php">Visualizar entradas</a></li>
        <a href="../index.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <!--<button type="submit" class="btnBuscarProdutos"><img src="/img/logo.png" height="30px" width="30px"> </img>Buscar Produtos</button>-->    
    <h1>Cadastrar Entrada</h1>

    <?php
    include_once "../classes/Produto.php";
    include_once "../classes/Banco.php";
    if(isset($_GET['id_fornecedor']))
    {
        $id_fornecedor = $_GET['id_fornecedor'];
    }
    if(isset($_GET['nome_fornecedor']))
    {
        $nome_fornecedor = $_GET['nome_fornecedor'];
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

    <form action="../classes/Entrada.php" method="POST">
        <label class="label" style="margin-left: 380px;">Lista de produtos</label>
            <div style="width:800px; border-radius: 10px;" class="divProdutos">
            
            <table style="width: 100%">
                <tr>
                    <td class="headerListagemProdutos">ID</td>
                    <td class="headerListagemProdutos">Nome do Produto</td>
                    <td class="headerListagemProdutos">Categoria</td>
                    <td class="headerListagemProdutos">Preço (R$)</td>
                    <td class="headerListagemProdutos">Quantidade</td>
                    <td class="headerListagemProdutos"></td>
                </tr>

                <?php 
        include_once "../classes/Produto.php";
        include_once "../classes/Categoria.php";
        include_once "../classes/Banco.php";
        if (isset($_GET['pesquisa']))
        {
            $pesquisa = $_GET['pesquisa'];
            $vetor = Produto::listarPesquisa($link, $pesquisa);
        }
        else
        {
            $vetor = Produto::listarTodos($link);
        }
        
        for ($i = 0; $i < count($vetor); $i++)
        {
            $id = $vetor[$i][0];
            $nome = $vetor[$i][1];
            $preco = $vetor[$i][2];
            $quantidade = $vetor[$i][3];
            $lucro_liquido = $vetor[$i][4];
            $id_categoria = $vetor[$i][5];
            $inativado = $vetor[$i][6];

            $categoria = Categoria::pegarCategoria($link, $id_categoria);
            $categoriaTexto = $categoria[0] . " - " . $categoria[1];
            if ($inativado == false) {
                echo '<tr>';
                echo '<td>' . $id . '</td>';
                echo '<td>' . $nome . '</td>';
                echo '<td>' . $categoriaTexto . '</td>';
                echo '<td>' . $preco . '</td>';
                echo '<td>' . $quantidade . '</td>';
                echo  '<td style="max-width: 60px; min-width: 60px;">';
                echo '<form action="../classes/Produto.php" method="POST">';
                echo '<button type="submit" name="excluir" class="btnExcluir"><img src="../img/lixeira.png" class="btnExcluir" width="40px" height="40px"></a>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            
        }
        ?>

            </table>


        </tr>
        </div>
            
        <div>
        <button class="btnAzul" onclick="location.href='../produto/selecionarProdutos.php'" type="button">Selecionar produtos</button>
        </div>
        <br>
        <div>
        <label class="label">Fornecedor do Produto
            <input type="text" name="fornecedor" disabled <?php if(isset($_GET['id_fornecedor'])) {echo('value="'.$id_fornecedor.' - '.$nome_fornecedor);} ?> ">
        </label>
        <input type="hidden" name="id_fornecedor" value="<?php if(isset($_GET['id_fornecedor'])) { echo($id_fornecedor); }?>">
        <button class="btnAzul" onclick="location.href='../fornecedor/selecionarFornecedor.php'" type="button">Selecionar o Fornecedor</button>
        </div>
        <div>
        <button type="submit" name="cadastrar" class="btnEnviar">Cadastrar</button>
        </div>
    </form>
    
</body>
</html>