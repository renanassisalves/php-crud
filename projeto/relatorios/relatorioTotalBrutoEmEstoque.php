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
        <li><a href="relatorios.php">Visualizar Relatórios</a></li>
        <li><a href="#" class="active">Relatório valor total bruto em estoque</a></li>
        <a href="../inicio.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <h1>Relatório valor total bruto em estoque</h1>

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
            echo('<p style="color: #c51d0d; margin: 10px;">Erro : Primeiramente exclua todas as entradas deste produto.</p>');
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
            <td class="headerListagem">Nome do Produto</td>
            <td class="headerListagem">Categoria</td>
            <td class="headerListagem">Preço (R$)</td>
            <td class="headerListagem">Quantidade</td>
            <td class="headerListagem">Valor Total em estoque (R$)</td>
        </tr>
        
        <?php 
        include_once "../classes/Produto.php";
        include_once "../classes/Categoria.php";
        include_once "../classes/Banco.php";
        
        $vetor = Produto::listarTodos($link);
        $quantidadeTotal = 0;
        
        for ($i = 0; $i < count($vetor); $i++)
        {
            $id = $vetor[$i][0];
            $nome = $vetor[$i][1];
            $preco = $vetor[$i][2];
            $quantidade = $vetor[$i][3];
            $quantidadeTotal = $quantidadeTotal+$quantidade;
            $lucro_liquido = $vetor[$i][4];
            $id_categoria = $vetor[$i][5];
            $inativado = $vetor[$i][6];

            $categoria = Categoria::pegarCategoria($link, $id_categoria);
            $categoriaTexto = $categoria[0] . " - " . $categoria[1];

            $valorQuantidadeBrutaProduto = Produto::pegarQuantidadeBruta($link, $id);
            $valorQuantidadeBrutaTotal = Produto::pegarQuantidadeBrutaTotal($link);
            if ($inativado == false) {
                echo '<tr>';
                echo '<td>' . $id . '</td>';
                echo '<td>' . $nome . '</td>';
                echo '<td>' . $categoriaTexto . '</td>';
                echo '<td>' . $preco . '</td>';
                echo '<td>' . $quantidade . '</td>';
                echo '<td>R$ ' . $valorQuantidadeBrutaProduto[0] . '</td>';
                echo '</tr>';
            }
            
        }

        echo '<tr style=background-color:grey;>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';;
                echo '<td>Quantidade total: ' . $quantidadeTotal . ' produtos</td>';
                echo '<td>Valor Bruto total: R$ ' . $valorQuantidadeBrutaTotal[0] . '</td>';
                echo '</tr>';
        ?>

    </table>

    <button class="btnAzul" onclick="location.href='relatorios.php'" type="button">Voltar</button>

    
</body>
</html>