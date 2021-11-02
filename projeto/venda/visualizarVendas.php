<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Vendas</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <ul>
        <img src="../img/logo.png" class="logo" alt="Exemplo de logomarca" width="60" height="60">
        <li><a href="cadastrarVenda.php">Cadastrar Venda</a></li>
        <li><a href="visualizarVendas.php" class="active">Visualizar Vendas</a></li>
        <a href="../inicio.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <h1>Visualizar Vendas</h1>

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
 <!-- <form action="../classes/Venda.php" method="POST" style="float: right; margin-bottom:10px; margin-right:10px;">
                    <input type="search" name="pesquisarSearch" placeholder="Pesquisar nome...">
                    <button type="submit" name="pesquisar">Pesquisar</button>
</form> -->

    <table style="width: 100%">
        <tr>
            <td class="headerListagem">ID</td>
            <td class="headerListagem">Data Venda</td>

            <td class="headerListagem"></td>
        </tr>

        <?php 
        include_once "../classes/Venda.php";
        include_once "../classes/Fornecedor.php";
        include_once "../classes/Banco.php";

        
        if (isset($_GET['pesquisa']))
        {
            $pesquisa = $_GET['pesquisa'];
            $vetor = Venda::listarPesquisa($link, $pesquisa);
        }
        else
        {
            $vetor = Venda::listarTodos($link);
        }
        
        for ($i = 0; $i < count($vetor); $i++)
        {
            $id = $vetor[$i][0];
            $data = $vetor[$i][1];
            $inativado = $vetor[$i][2];

            if ($inativado == false) {
                echo '<tr>';
                echo '<td>' . $id . '</td>';
                echo '<td>' . $data . '</td>';
                echo  '<td style="max-width: 60px; min-width: 60px;">';
                echo '<form action="../classes/Venda.php" method="POST">';
                echo '<button type="submit" style="min-width: 200px;" name="visualizarProdutos" class="btnAzul">Visualizar Produtos</button>';
                echo '<input type="hidden" name="id" value=' . $id . '>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            
        }
        ?>
    </table>

    
</body>
</html>