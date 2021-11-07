<?php
require "Banco.php";

if(isset($_POST['relatorioProdutosCategoria']))
{
    header('location:../relatorios/relatorioProdutosPorCategoria.php');
}

if(isset($_POST['relatorioTotalBrutoEmEstoque']))
{
    header('location:../relatorios/relatorioTotalBrutoEmEstoque.php');
}

if(isset($_POST['relatorioLucroLiquidoVendas']))
{
    header('location:../relatorios/selecionarPeriodo.php');
}

if(isset($_POST['gerarRelatorio']))
{
    $dataInicio = $_POST['dataInicio'];
    $dataFim = $_POST['dataFim'];

    header('location:../relatorios/visualizarRelatorio.php?dataInicio='.$dataInicio.'&dataFim='.$dataFim);
    
}



?>