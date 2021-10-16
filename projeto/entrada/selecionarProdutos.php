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
        <li><a href="visualizarProdutos.php">Visualizar Produtos</a></li>
        <li><a href="selecionarProdutos.php" class="active">Selecionar Produtos</a></li>
        <a href="../index.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <h1>Visualizar Produtos</h1>

    <?php 
    if(isset($_GET['resultado']))
    {
        $resultado = $_GET['resultado'];
        if ($resultado == 'sucesso')
        {
            echo('<div style="background-color: #b1ffb8b1;">');
            echo('<p style="color: #1a571fb1; margin: 10px;">Cadastrado com sucesso!</p>');
            echo('</div>');
        }
        else if (str_contains($resultado, 'Cannot delete or update a parent row: a foreign key constraint fails'))
        {
            echo('<div style="background-color: #ff9d9448;">');
            echo('<p style="color: #c51d0d; margin: 10px;">Erro : Primeiramente exclua todos os produtos desta categoria.</p>');
            echo('</div>');
        }
        else if ($resultado == 'alteradosucesso')
        {
            echo('<div style="background-color: #b1ffb8b1;">');
            echo('<p style="color: #1a571fb1; margin: 10px;">Alterado com sucesso!</p>');
            echo('</div>');
        }
        else if ($resultado == 'excluidosucesso')
        {
            echo('<div style="background-color: #b1ffb8b1;">');
            echo('<p style="color: #1a571fb1; margin: 10px;">Excluído com sucesso!</p>');
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

<!-- <form action="../classes/Produto.php" method="POST" style="float: right; margin-bottom:10px; margin-right:10px;">
                    <input type="search" name="pesquisarSearch" placeholder="Pesquisar nome...">
                    <button type="submit" name="pesquisarSelecionar">Pesquisar</button>
</form> -->

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
        
        <?php 
        include_once "../classes/Produto.php";
        include_once "../classes/Categoria.php";
        include_once "../classes/Banco.php";

        $lista_id = [];
        $lista_quantidade = [];

        if (isset($_GET['lista_id']))
        {
            $lista_id = $_GET['lista_id'];
        }

        if (isset($_GET['lista_quantidade']))
        {
            $lista_quantidade = $_GET['lista_quantidade'];
        }

        if (isset($_GET['pesquisa']))
        {
            $pesquisa = $_GET['pesquisa'];
            $vetor = Produto::listarPesquisa($link, $pesquisa);
        }
        else
        {
            $vetor = Produto::listarTodos($link);
        }
        
        if (!empty($lista_id))
        {$arrayLista = explode(',', $lista_id);}
        else {
            $arrayLista = [];
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
                
                if (in_array($id, $arrayLista))
                {
                    echo '<tr>';
                    echo '<td>' . $id . '</td>';
                    echo '<td>' . $nome . '</td>';
                    echo '<td>' . $categoriaTexto . '</td>';
                    echo '<td>' . $preco . '</td>';
                    echo '<td>' . $quantidade . '</td>';
                    echo  '<td style="max-width: 60px; min-width: 60px;">';
                    echo '<form action="../classes/Entrada.php" method="POST">';
                    echo '<button type="submit" name="remover" class="btnExcluir"><img src="../img/menos.png" class="btnExcluir" width="40px" height="40px"></a>';
                    echo '<input type="hidden" name="id_remover" value="'.$id.'">';
                    if (isset($_GET['lista_id']))
                    {
                        echo '<input type="hidden" name="lista_id" value="'.$lista_id.'">';
                    }
                    if (isset($_GET['lista_quantidade']))
                    {
                        echo '<input type="hidden" name="lista_quantidade" value="'.$lista_quantidade.'">';
                    }
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
                else {
                    echo '<tr>';
                    echo '<td>' . $id . '</td>';
                    echo '<td>' . $nome . '</td>';
                    echo '<td>' . $categoriaTexto . '</td>';
                    echo '<td>' . $preco . '</td>';
                    echo '<td>' . $quantidade . '</td>';
                    echo  '<td style="max-width: 60px; min-width: 60px;">';
                    echo '<form action="../classes/Entrada.php" method="POST">';
                    echo '<button type="submit" name="adicionar" class="btnExcluir"><img src="../img/mais.jpg" class="btnExcluir" width="40px" height="40px"></a>';
                    echo '<input type="hidden" name="id_novo" value="'.$id.'">';
                    if (isset($_GET['lista_id']))
                    {
                        echo '<input type="hidden" name="lista_id" value="'.$lista_id.'">';
                    }
                    if (isset($_GET['lista_quantidade']))
                    {
                        echo '<input type="hidden" name="lista_quantidade" value="'.$lista_quantidade.'">';
                    }
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
                
            }
            
        }
        ?>

    </table>
    <div>
    <button class="btnAzul" onclick="location.href='../produto/cadastrarProduto.php'" type="button">Cadastrar novo produto</button>
    <button class="btnAzul" onclick="location.href='../entrada/cadastrarEntrada.php?lista_id=<?php if(!empty($lista_id)) {echo $lista_id;} if(!empty($lista_quantidade)) {echo '&lista_quantidade='.$lista_quantidade;}?>'" type="button">Finalizar seleção</button>
    </div>
    
</body>
</html>