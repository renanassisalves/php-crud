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

?>