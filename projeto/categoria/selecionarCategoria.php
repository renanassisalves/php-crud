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
        <li><a href="cadastrarCategoria.php">Cadastrar Categoria</a></li>
        <li><a href="visualizarCategorias.php">Visualizar Categorias</a></li>
        <li><a href="selecionarCategoria.php" class="active">Selecionar Categoria</a></li>
        <a href="../inicio.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <h1>Visualizar Categorias</h1>

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
 <form action="../classes/Categoria.php" method="POST" style="float: right; margin-bottom:10px; margin-right:10px;">
                    <input type="search" name="pesquisarSearch" placeholder="Pesquisar nome...">
                    <input type="hidden" name="origem" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <button type="submit" name="pesquisar">Pesquisar</button>
</form>

    <table style="width: 100%">
        <tr>
            <td class="headerListagem">ID</td>
            <td class="headerListagem">Nome da Categoria</td>
            <td class="headerListagem"></td>
        </tr>

        <?php 
        include_once "../classes/Categoria.php";
        include_once "../classes/Banco.php";
        if (isset($_GET['pesquisa']))
        {
            $pesquisa = $_GET['pesquisa'];
            $vetor = Categoria::listarPesquisa($link, $pesquisa);
        }
        else
        {
            $vetor = Categoria::listarTodos($link);
        }

        $nome_produto = $_GET['nome_produto'];
        $nome_produto = str_replace(' ', '%20', $nome_produto);
        $preco_produto = $_GET['preco_produto'];
        $quantidade_produto = $_GET['quantidade_produto'];
        $lucro_liquido_produto = $_GET['lucro_liquido_produto'];
        
        for ($i = 0; $i < count($vetor); $i++)
        {
            $id = $vetor[$i][0];
            $nome_categoria = $vetor[$i][1];
            $inativado = $vetor[$i][2];

            $id_post = str_replace(' ', '%20', $id);
            $nome_post = str_replace(' ', '%20', $nome_categoria);
            if ($inativado == false) {
                echo '<tr>';
                echo '<td>' . $id . '</td>';
                echo '<td>' . $nome_categoria . '</td>';
                echo  '<td style="max-width: 60px; min-width: 60px;">';
                echo '<form action="../classes/Categoria.php" method="POST">';
                echo '<button type="submit" name="selecionadoproduto" class="btnEditar"><img src="../img/mais.jpg" class="btnEditar" width="40px" height="40px"></button>';
                echo '<input type="hidden" name="id_categoria" value=' . $id_post . '>';
                echo '<input type="hidden" name="nome_categoria" value=' . $nome_post . '>';
                echo '<input type="hidden" name="nome_produto" value=' . $nome_produto . '>';
                echo '<input type="hidden" name="preco_produto" value=' . $preco_produto . '>';
                echo '<input type="hidden" name="quantidade_produto" value=' . $quantidade_produto . '>';
                echo '<input type="hidden" name="lucro_liquido_produto" value=' . $lucro_liquido_produto . '>';
                if(isset($_GET['origem'])) {
                    echo '<input type="hidden" name="origem" value="'. $_GET['origem'] .'">';
                    } 
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            
        }
        ?>
    </table>
    <div>
    <button class="btnAzul" onclick="location.href='../categoria/cadastrarCategoria.php'" type="button">Cadastrar nova categoria</button>
    </div>
</body>
</html>