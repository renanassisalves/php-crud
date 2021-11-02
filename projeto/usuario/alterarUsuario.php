<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Usuário</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <ul>
        <img src="../img/logo.png" class="logo" alt="Exemplo de logomarca" width="60" height="60">
        <li><a href="#" class="active">Alterar Usuário</a></li>
        <li><a href="visualizarUsuarios.php">Visualizar Usuários</a></li>
        <a href="../inicio.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <!--<button type="submit" class="btnBuscarProdutos"><img src="/img/logo.png" height="30px" width="30px"> </img>Buscar Produtos</button>-->    
    <h1>Alterar Usuário</h1>

    <?php
session_start();
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true) or ($_SESSION['nivel_de_acesso'] == 1))
{
  unset($_SESSION['login']);
  unset($_SESSION['senha']);
  header('location:../index.php');
  }
$nome = $_SESSION['nome'];
$login = $_SESSION['login'];
$nivel_de_acesso = $_SESSION['nivel_de_acesso'];

    include_once "../classes/Usuario.php";
    include_once "../classes/Banco.php";
    $id = $_GET['id'];
    $usuario = Usuario::pegarUsuario($link, $id);

    if(isset($_GET['resultado']))
    {
        $resultado = $_GET['resultado'];
        if ($resultado == 'sucesso')
        {
            echo('<div style="background-color: #b1ffb8b1;">');
            echo('<p style="color: #1a571fb1; margin: 10px;">Cadastrado com sucesso!</p>');
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

    <form action="../classes/Usuario.php" method="POST">
        <div>
        <label class="label">Nome
            <input type="text" name="nome" maxlength="255" value="<?php echo $usuario[1] ?>">
        </label>
        <label class="label">Login
            <input type="text" name="login" maxlength="255" value="<?php echo $usuario[2] ?>">
        </label>
        <label class="label">Nova Senha
            <input type="password" name="senha" maxlength="255" value="<?php echo $usuario[3] ?>">
        </label>
        <label class="label">Confirme a nova senha
            <input type="password" name="senhaConfirma" maxlength="255" value="<?php echo $usuario[3] ?>">
        </label>

        <div>
        <label class="label">Nível de acesso
        <div></div>
        <select name="nivel_de_acesso">
        <?php if ($usuario[4] == 1) 
        {
            echo '<option value="funcionario">Funcionário</option>';
            echo '<option value="administrador">Administrador</option>';
        }
        else if ($usuario[4] == 2)
        {
            echo '<option value="administrador">Administrador</option>';
            echo '<option value="funcionario">Funcionário</option>';
        }
        ?>
                </select>
            </label>
        </div>

        <?php
        echo '<input type="hidden" name="id" value=' . $id . '>';
        ?>
        </div>
        <div>
        <button type="submit" name="alterarconfirma" class="btnEnviar">Alterar</button>
        </div>
    </form>
    
</body>
</html>