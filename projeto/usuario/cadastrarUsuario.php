<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <ul>
        <img src="../img/logo.png" class="logo" alt="Exemplo de logomarca" width="60" height="60">
        <li><a href="visualizarUsuarios.php">Visualizar Usuários</a></li>
        <li><a href="#" class="active">Cadastrar Usuário</a></li>
        <a href="../index.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <!--<button type="submit" class="btnBuscarProdutos"><img src="/img/logo.png" height="30px" width="30px"> </img>Buscar Produtos</button>-->    
    <h1>Cadastrar Usuário</h1>
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
        else
        {
            echo('<div style="background-color: #ff9d9448;">');
            echo('<p style="color: #c51d0d; margin: 10px;">Erro : ' . $resultado . '</p>');
            echo('</div>');
        }
    }
    ?>
    
    <form action="../classes/Usuario.php" method="POST">
        <div style="margin-left: auto; margin-right: auto; display: block;">
        <label class="label">Nome do usuário
            <input type="text" name="nome" maxlength="255" placeholder="Digite o nome do usuário">
        </label>
        </div>
        <div>
        <label class="label">Login do usuário
            <input type="text" name="login" maxlength="255" placeholder="Digite o login do usuário">
        </label>
        </div>
        <div>
        <label class="label">Senha do usuário
            <input type="password" name="senha" maxlength="255" placeholder="Digite a senha do usuário">
        </label>
        </div>
        <div>
        <label class="label">Confirme a senha
            <input type="password" name="senhaConfirma" maxlength="255" placeholder="Confirme a senha do usuário">
        </label>
        </div>
        <div>
            <label class="label">Nível de acesso
                <div></div>
                <select name="nivel_de_acesso">
                    <option value="administrador">Administrador</option>
                    <option value="funcionario">Funcionário</option>
                </select>
            </label>
        </div>
        <div></div>
        <button type="submit" name="cadastrar" class="btnEnviar">Cadastrar</button>
        </div>
    </form>
    
</body>
</html>