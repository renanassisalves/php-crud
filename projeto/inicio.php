<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página inicial</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
session_start();
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true))
{
  unset($_SESSION['login']);
  unset($_SESSION['senha']);
  header('location:index.php');
  }
$nome = $_SESSION['nome'];
$login = $_SESSION['login'];
$nivel_de_acesso = $_SESSION['nivel_de_acesso'];

?>

    <ul>
        <img src="img/logo.png" alt="Exemplo de logomarca" width="60" height="60" class="logo">
        <li><a href="entrada/cadastrarEntrada.php">Iniciar Entrada</a></li>
        <li><a href="venda/cadastrarVenda.php">Iniciar Venda</a></li>
        <li><a href="devolucao/cadastrarDevolucao.php">Iniciar Devolução</a></li>
        <li><a href="produto/cadastrarProduto.php">Cadastrar Produto</a></li>
        <li><a href="fornecedor/cadastrarFornecedor.php">Cadastrar Fornecedor</a></li>
        <?php 
        if ($nivel_de_acesso == 2)
        {
            echo '<li><a href="relatorios/relatorios.php">Relatórios</a></li>';
            echo '<li><a href="usuario/visualizarUsuarios.php">Visualizar usuários cadastrados</a></li>';
            echo '<li><a href="usuario/visualizarLogs.php">Visualizar logs</a></li>';
        }
        ?>
        <li><a href="classes/Usuario.php?deslogar=true" style="background-color: lightcoral;">Deslogar</a></li>
        <p class="loginStatus">Bem-vindo, <?php echo $nome ?>!</p>
    </ul>
</body>
</html>