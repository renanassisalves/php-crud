<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Endereço</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <ul>
        <img src="../img/logo.png" class="logo" alt="Exemplo de logomarca" width="60" height="60">
        <!-- <li><a href="cadastrarFornecedor.php">Cadastrar Fornecedor</a></li>
        <li><a href="visualizarFornecedores.php">Visualizar Fornecedores</a></li> -->
        <li><a href="visualizarEndereco.php" class="active">Visualizar Endereço</a></li>
        <a href="../index.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <h1>Visualizar Endereço</h1>
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
        else if (str_contains($resultado, 'Cannot delete or update a parent row: a foreign key constraint fails'))
        {
            echo('<div style="background-color: #ff9d9448;">');
            echo('<p style="color: #c51d0d; margin: 10px;">Erro : Primeiramente remova todas as entradas deste fornecedor.</p>');
            echo('</div>');
        }
        else if ($resultado == 'alteradosucesso')
        {
            echo('<div style="background-color: #b1ffb8b1;">');
            echo('<p style="color: #1a571fb1; margin: 10px;">Alterado com sucesso!</p>');
            echo('</div>');
        }
        else if ($resultado == 'excluidosucesso')
        {
            echo('<div style="background-color: #b1ffb8b1;">');
            echo('<p style="color: #1a571fb1; margin: 10px;">Excluído com sucesso!</p>');
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

    <!-- <form action="../classes/Fornecedor.php" method="POST" style="float: right; margin-bottom:10px; margin-right:10px;">
                    <input type="search" name="pesquisarSearch" placeholder="Pesquisar pelo nome...">
                    <button type="submit" name="pesquisar">Pesquisar</button> -->
    </form>
    <table style="width: 100%">
        <tr>
            <td class="headerListagem">ID</td>
            <td class="headerListagem">Longradouro</td>
            <td class="headerListagem">Bairro</td>
            <td class="headerListagem">Número</td>
            <td class="headerListagem">Cep</td>
            <td class="headerListagem"></td>
        </tr>

        <?php 
        include_once "../classes/Fornecedor.php";
        include_once "../classes/Banco.php";
        
        if (isset($_GET['id_endereco']))
        {
            $id_endereco = $_GET['id_endereco'];
            $vetor = Endereco::pegarEndereco($link, $id_endereco);
        }

            $id = $vetor[0];
            $longradouro = $vetor[1];
            $bairro = $vetor[2];
            $numero = $vetor[3];
            $cep = $vetor[4];
            $inativado = $vetor[5];
            if ($inativado == false) {
                echo '<tr>';
                echo '<td>' . $id . '</td>';
                echo '<td>' . $longradouro . '</td>';
                echo '<td>' . $bairro . '</td>';
                echo '<td>' . $numero . '</td>';
                echo '<td>' . $cep . '</td>';
                echo '</tr>';
            }
            
        ?>
    </table>
    <div>
    <?php 
    if (isset($_GET['origem']))
    {
        $origem = $_GET['origem'];
        $origem = str_replace("|||", "&",  $origem);
        echo '<button class="btnAzul" onclick="location.href=\''. $origem .'\'" type="button">Voltar</button>';
    }
    else
    {
        echo '<button class="btnAzul" onclick="location.href=\'../fornecedor/cadastrarFornecedor.php\'" type="button">Voltar</button>';
    }
    ?>
    
    
    </div>
</body>
</html>