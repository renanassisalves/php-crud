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
        <li><a href="relatorios.php">Visualizar Relatórios</a></li>
        <li><a href="#" class="active">Relatório produtos por categoria</a></li>
        <a href="../inicio.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <h1>Relatório de produtos por categoria</h1>

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

    <table style="width: 100%">
        <tr>
            <td class="headerListagem">ID</td>
            <td class="headerListagem">Nome da Categoria</td>
            <td class="headerListagem">Quantidade de produtos nessa categoria</td>
        </tr>

        <?php 
        include_once "../classes/Categoria.php";
        include_once "../classes/Banco.php";

        $vetor = Categoria::listarTodos($link);

        
        for ($i = 0; $i < count($vetor); $i++)
        {
            $id = $vetor[$i][0];
            $nome = $vetor[$i][1];
            $inativado = $vetor[$i][2];
            $produtosNessaCategoria = Categoria::contarProdutosCategoria($link, $id);
            $produtosNessaCategoriaTotal = Categoria::contarProdutosCategoriaTotal($link);
            if ($inativado == false) {
                echo '<tr>';
                echo '<td>' . $id . '</td>';
                echo '<td>' . $nome . '</td>';
                echo '<td>' . $produtosNessaCategoria[0][0] . '</td>';
                echo '</tr>';
            }
            
        }
        ?>

    <tr style=background-color:grey>
            <td></td>
            <td></td>
            <td>Total de Produtos : <?php echo $produtosNessaCategoriaTotal[0][0] ?></td>
        </tr>
    </table>

    <button class="btnAzul" onclick="location.href='relatorios.php'" type="button">Voltar</button>
</body>
</html>