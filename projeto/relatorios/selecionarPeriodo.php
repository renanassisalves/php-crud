<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página inicial</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <ul>
        <img src="../img/logo.png" alt="Exemplo de logomarca" width="60" height="60" class="logo">
        <li><a href="#">Relatórios</a></li>
        <a href="../inicio.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>


    <div class="container">
    <div class="menu">
    <form action="classes/Relatorios.php" method="POST">
    <label class="label" style="color: white;">Relatórios disponíveis</label>
        <br>
        <input type="date" name="dataInicio">Data de início do relatório</input>
        <div></div>
        <input type="date" name="dataFim">Data de fim do relatório</input>
        <div></div>
        <button type="submit" name="gerarRelatorio" class="btnEnviar">Gerar Relatório</button>
        <div></div>
    </form>
    <button class="btnAzul" onclick="location.href='relatorios.php'" type="button">Voltar</button>
    </div>
</div>
</body>
</html>