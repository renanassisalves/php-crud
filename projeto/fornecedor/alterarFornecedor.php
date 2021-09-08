<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Fornecedor</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <ul>
        <img src="../img/logo.png" class="logo" alt="Exemplo de logomarca" width="60" height="60">
        <li><a href="#" class="active">Alterar Fornecedor</a></li>
        <li><a href="visualizarFornecedor.php">Visualizar Fornecedores</a></li>
        <a href="../index.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <!--<button type="submit" class="btnBuscarFornecedors"><img src="/img/logo.png" height="30px" width="30px"> </img>Buscar Fornecedors</button>-->    
    <h1>Alterar Fornecedor</h1>

    <form action="../classes/Fornecedor.php" method="POST">
        <div>
        <label class="label">Nome do Fornecedor
            <input type="text" name="nome" placeholder="Digite o nome do fornecedor">
        </label>
        <label class="label">Responsável pelo fornecimento
            <input type="text" name="responsavel" placeholder="Digite o nome do responsável">
        </label>
        <label class="label">Telefone do responsável
            <input type="text" name="tel_responsavel" placeholder="Digite o telefone do responsável">
        </label>
        </div>
        <div><h1>Endereço</h1></div>
        <div>
        <label class="label">Longradouro
            <input type="text" name="longradouro" placeholder="Digite o longradouro">
        </label>
        
        <label class="label">Bairro
            <input type="text" name="bairro" placeholder="Digite o bairro">
        </label>
        <label class="label">Número
            <input type="text" name="numero" placeholder="Digite o número">
        </label>

        <label class="label">CEP
            <input type="text" name="cep" placeholder="Digite o cep">
        </label>

        </div>
    <div>
        <button type="submit" name="alterar" class="btnEnviar">Alterar</button>
    </div>
    </form>
    
</body>
</html>