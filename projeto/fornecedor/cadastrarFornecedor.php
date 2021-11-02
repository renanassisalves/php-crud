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
        <li><a href="#" class="active">Cadastrar Fornecedor</a></li>
        <li><a href="visualizarFornecedores.php">Visualizar Fornecedores</a></li>
        <a href="../index.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <!--<button type="submit" class="btnBuscarFornecedors"><img src="/img/logo.png" height="30px" width="30px"> </img>Buscar Fornecedors</button>-->    
    <h1>Cadastrar Fornecedor</h1>

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

    <form action="../classes/Fornecedor.php" method="POST">
        <div>
        <label class="label">Nome do Fornecedor <label class="label" style="color: red;">*</label>
            <input type="text" name="nome" maxlength="255" placeholder="Digite o nome do fornecedor">
        </label>
        <label class="label">Responsável pelo fornecimento <label class="label" style="color: red;">*</label>
            <input type="text" name="responsavel" maxlength="255" placeholder="Digite o nome do responsável">
        </label>
        <label class="label">Telefone do responsável <label class="label" style="color: red;">*</label>
            <input type="text" name="tel_responsavel" maxlength="50" placeholder="Digite o telefone do responsável">
        </label>
        </div>
        <div><h1>Endereço</h1></div>
        <div>
        <label class="label">Longradouro <label class="label" style="color: red;">*</label>
            <input type="text" name="longradouro" maxlength="50" placeholder="Digite o longradouro">
        </label>
        
        <label class="label">Bairro <label class="label" style="color: red;">*</label>
            <input type="text" name="bairro" maxlength="100" placeholder="Digite o bairro">
        </label>
        <label class="label">Número <label class="label" style="color: red;">*</label>
            <input type="text" name="numero" maxlength="10" placeholder="Digite o número">
        </label>
        <label class="label">CEP <label class="label" style="color: red;">*</label>
            <input type="text" name="cep" maxlength="10" placeholder="Digite o cep">
        </label>
        <?php if(isset($_GET['origem'])) {
            echo '<input type="hidden" name="origem" value="'. $_GET['origem'] .'">';
            } ?>
        </div>
    <div>
        <button type="submit" name="cadastrar" class="btnEnviar">Cadastrar</button>
    </div>
    </form>
    
</body>
</html>