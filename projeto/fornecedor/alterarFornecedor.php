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
        <li><a href="visualizarFornecedores.php">Visualizar Fornecedores</a></li>
        <a href="../inicio.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <!--<button type="submit" class="btnBuscarFornecedors"><img src="/img/logo.png" height="30px" width="30px"> </img>Buscar Fornecedors</button>-->    
    <h1>Alterar Fornecedor</h1>

    <?php
    include_once "../classes/Fornecedor.php";
    include_once "../classes/Banco.php";
    $id = $_GET['id'];
    $fornecedor = Fornecedor::pegarFornecedor($link, $id);
    $idEndereco = $fornecedor[4];
    $endereco = Fornecedor::pegarEnderecoFornecedor($link, $idEndereco);

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
            <input type="text" name="nome" maxlength="255" value="<?php echo $fornecedor[1] ?>">
        </label>
        <label class="label">Responsável pelo fornecimento <label class="label" style="color: red;">*</label>
            <input type="text" name="responsavel" maxlength="255" value="<?php echo $fornecedor[2] ?>">
        </label>
        <label class="label">Telefone do responsável <label class="label" style="color: red;">*</label>
            <input type="text" name="tel_responsavel" maxlength="50" value="<?php echo $fornecedor[3] ?>">
        </label>
        </div>
        <div><h1>Endereço</h1></div>
        <div>
        <label class="label">Longradouro <label class="label" style="color: red;">*</label>
            <input type="text" name="longradouro" maxlength="50" value="<?php echo $endereco[1] ?>">
        </label>
        
        <label class="label">Bairro <label class="label" style="color: red;">*</label>
            <input type="text" name="bairro" maxlength="100" value="<?php echo $endereco[2] ?>">
        </label>
        <label class="label">Número <label class="label" style="color: red;">*</label>
            <input type="text" name="numero" maxlength="10" value="<?php echo $endereco[3] ?>">
        </label>

        <label class="label">CEP <label class="label" style="color: red;">*</label>
            <input type="text" name="cep" maxlength="10" value="<?php echo $endereco[4] ?>">
        </label>

        </div>
        <?php
        echo '<input type="hidden" name="id_fornecedor" value=' . $id . '>';
        ?>
    <div>
        
        <button type="submit" name="alterarconfirma" class="btnEnviar">Alterar</button>
    </div>
    </form>
    
</body>
</html>