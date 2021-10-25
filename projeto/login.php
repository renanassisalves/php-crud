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
    <ul>
        <img src="img/logo.png" alt="Exemplo de logomarca" width="60" height="60" class="logo">
    </ul>


    <div class="container">
    <div class="menu">
    <form action="../classes/Usuario.php" method="POST">
    <label class="label" style="color: white;">Login do usuário
            <input type="text" name="login" maxlength="255" placeholder="Digite o seu login">
        </label>
        <br>
        <label class="label" style="color: white;">Senha do usuário
            <input type="password" name="senha" maxlength="255" placeholder="Digite a sua senha">
        </label>
        <div></div>
        <button type="submit" name="entrar" class="btnEnviar">Entrar</button>
    </form>
    </div>
</div>
</body>
</html>