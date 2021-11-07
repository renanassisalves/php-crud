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
        <li><a href="#" class="active">Relatório lucro total líquido por período</a></li>
        <a href="../inicio.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <h1>Relatório lucro total líquido por período</h1>

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

        $dataInicio = $_GET['dataInicio'];
        $dataFim = $_GET['dataFim'];
        echo('<h2 style="margin-left:50px;">Período do relatório: '.$dataInicio.'/'.$dataFim.'</h2>')
    ?>
    <table style="width: 55%; margin-left: 22.5%; margin-right:22.5%;" id="relatorio" name="relatorio">
    <thead>
        <tr>
            <th class="headerListagem">ID_VENDA</th>
            <th class="headerListagem">Nome do Produto</th>
            <th class="headerListagem">Preço do Produto</th>
            <th class="headerListagem">Quantidade na Venda</th>
            <th class="headerListagem">% de Lucro Líquido</th>
            <th class="headerListagem">Lucro Liquido Total</th>
            <th class="headerListagem">Data da Venda</th>
        </tr>
</thead>
<tbody>
        <?php 
        include_once "../classes/Produto.php";
        include_once "../classes/Banco.php";

        

        $vetor = Produto::gerarRelatorioLucroLiquido($link, $dataInicio, $dataFim);
        $lucroLiquidoTotalGeral = 0;
        $quantidadeVendaGeral = 0;
        for ($i = 0; $i < count($vetor); $i++)
        {
            $idVenda = $vetor[$i][1];
            $nomeProduto = $vetor[$i][4];
            $precoProduto = $vetor[$i][5];
            $quantidadeVenda = $vetor[$i][2];
            $porcentagemLucroLiquido = $vetor[$i][7];
            $lucroLiquidoTotal = $vetor[$i][13];
            $lucroLiquidoTotal = round($lucroLiquidoTotal, 2);
            $dataVenda = $vetor[$i][11];
            $lucroLiquidoTotalGeral = $lucroLiquidoTotalGeral+$lucroLiquidoTotal;
            $lucroLiquidoTotalGeral = round($lucroLiquidoTotalGeral, 2);
            $quantidadeVendaGeral = $quantidadeVendaGeral+$quantidadeVenda;

            echo '<tr>';
            echo '<td>' . $idVenda . '</td>';
            echo '<td>' . $nomeProduto . '</td>';
            echo '<td>' . $precoProduto . '</td>';
            echo '<td>' . $quantidadeVenda . '</td>';
            echo '<td>' . $porcentagemLucroLiquido . '</td>';
            echo '<td>R$ ' . $lucroLiquidoTotal . '</td>';
            echo '<td>' . $dataVenda . '</td>';
            echo '</tr>';   
        }

        echo '<tr style=background-color:grey;>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td> Vendas totais no período: ' . $quantidadeVendaGeral . '</td>';
            echo '<td></td>';
            echo '<td> Lucro total no período: R$' . $lucroLiquidoTotalGeral . '</td>';
            echo '<td></td>';
            echo '</tr>';
        ?>
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
                table.download("pdf", "data.pdf", {orientation: "portrait", title: "Relatório lucro total líquido por período - <?php echo $dataInicio."/".$dataFim."\"" ?>});
            });
        </script>

    
</body>
</html>