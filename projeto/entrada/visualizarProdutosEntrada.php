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
        <li><a href="../entrada/visualizarEntradas.php">Visualizar Entradas</a></li>
        <li><a href="#" class="active">Visualizar Entrada</a></li>
        <a href="../inicio.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>
    <?php 
    include_once "../classes/Entrada.php";
    include_once "../classes/Produto.php";
    include_once "../classes/Categoria.php";
    include_once "../classes/Banco.php";

    $idEntrada = $_GET['id_entrada'];
    $dataEntrada = Entrada::pegarEntrada($link, $idEntrada);
    $dataEntrada = $dataEntrada[1];
    ?>
    <h1>Visualizar Produtos Entrada <?php echo($dataEntrada); ?></h1>

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
            <td class="headerListagem">Nome do Produto</td>
            <td class="headerListagem">Categoria</td>
            <td class="headerListagem">Preço (R$)</td>
            <td class="headerListagem">Quantidade</td>
            <td class="headerListagem">
                
            </td>
        </tr>
        
        <?php 
            $vetorEntrada = Produto::listarEntrada($link,$idEntrada);
        
        for ($i = 0; $i < count($vetorEntrada); $i++)
        {
            $vetor = Produto::pegarProduto($link, $vetorEntrada[$i][0]);
            $id = $vetor[0];
            $nome = $vetor[1];
            $preco = $vetor[2];
            $quantidade_estoque = $vetor[3];
            $lucro_liquido = $vetor[4];
            $id_categoria = $vetor[5];
            $inativado = $vetor[6];

            $quantidadeEntrada = Entrada::pegarQuantidadeProdutoEntrada($link, $idEntrada, $id);
            $categoria = Categoria::pegarCategoria($link, $id_categoria);
            $categoriaTexto = $categoria[0] . " - " . $categoria[1];
            if ($inativado == false) {
                echo '<tr>';
                echo '<td>' . $id . '</td>';
                echo '<td>' . $nome . '</td>';
                echo '<td>' . $categoriaTexto . '</td>';
                echo '<td>' . $preco . '</td>';
                echo '<td>' . $quantidadeEntrada[2] . '</td>';
                // echo  '<td style="max-width: 60px; min-width: 60px;">';
                // echo '<form action="../classes/Produto.php" method="POST">';
                // echo '<button type="submit" name="alterar" class="btnEditar"><img src="../img/lapis.png" class="btnEditar" width="40px" height="40px"></button>';
                // echo '<button type="submit" name="excluir" class="btnExcluir"><img src="../img/lixeira.png" class="btnExcluir" width="40px" height="40px"></a>';
                // echo '<input type="hidden" name="id" value=' . $id . '>';
                // echo '</form>';
                // echo '</td>';
                echo '</tr>';
            }
            
        }
        ?>

    </table>

    <!-- <button class="btnAzul" onclick="location.href='../produto/cadastrarProduto.php'" type="button">Cadastrar novo produto</button> -->

    
</body>
</html>