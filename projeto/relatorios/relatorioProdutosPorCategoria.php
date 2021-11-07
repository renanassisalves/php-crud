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

    <table style="width: 55%; margin-left: 22.5%; margin-right:22.5%;" id="relatorio" name="relatorio">
        <thead>
            <th class="headerListagem">ID</th>
            <th class="headerListagem">Nome da Categoria</th>
            <th class="headerListagem">Quantidade de produtos nessa categoria</th>
        </thead>
        <tbody>
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
                if (empty($produtosNessaCategoria[0][0]))
                {
                    echo '<td>0</td>';    
                }else
                {
                    echo '<td>' . $produtosNessaCategoria[0][0] . '</td>';
                }
                echo '</tr>';
            }
            
        }
        ?>

        <tr style=background-color:grey>
            <td></td>
            <td></td>
            <td>Total de Produtos : <?php echo $produtosNessaCategoriaTotal[0][0] ?></td>
        </tr>
        </tbody>
    </table>


    <div class="row" style="padding-left: 12px; padding-top: 12px;">
    <button class="btnAzul" onclick="location.href='relatorios.php'" style="margin-right: 35%;" type="button">Voltar</button>
      <button class="btnAzul" id="download-csv">Gerar CSV</button>
      <button class="btnAzul" id="download-json">Gerar JSON</button>
      <button class="btnAzul" id="download-pdf">Gerar PDF</button>
    
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

    <link href="https://unpkg.com/tabulator-tables@4.2.0/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@4.2.0/dist/js/tabulator.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.5/jspdf.plugin.autotable.js"></script>

    <script>
            var table = new Tabulator("#relatorio", {
                layout: "fitDataFill",
                pagination:"local",
                paginationSize:20,
            });
            
            function voltar() {
                $("#report-result-panel").hide();
                $("#report-list-panel").show();
            }
            
            $("#download-csv").click(function(){
                table.download("csv", "data.csv");
            });
            
            $("#download-json").click(function () {
                table.download("json", "data.json");
            });
            
            $("#download-xlsx").click(function () {
                table.download("xlsx", "data.xlsx", {sheetName: "dados"});
            });
            
            $("#download-pdf").click(function () {
                table.download("pdf", "data.pdf", {orientation: "portrait", title: "Relatório de produtos por categoria"});
            });
        </script>
</body>
</html>