<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Fornecedores</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <ul>
        <img src="../img/logo.png" class="logo" alt="Exemplo de logomarca" width="60" height="60">
        <li><a href="cadastrarFornecedor.php">Cadastrar Fornecedor</a></li>
        <li><a href="visualizarFornecedores.php" class="active">Visualizar Fornecedores</a></li>
        <a href="../inicio.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <h1>Visualizar Fornecedores</h1>
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

    <form action="../classes/Fornecedor.php" method="POST" style="float: right; margin-bottom:10px; margin-right:10px;">
                    <input type="search" name="pesquisarSearch" placeholder="Pesquisar pelo nome...">
                    <button type="submit" name="pesquisar">Pesquisar</button>
    </form>
    <table style="width: 100%">
        <tr>
            <td class="headerListagem">ID</td>
            <td class="headerListagem">Nome do Fornecedor</td>
            <td class="headerListagem">Responsável</td>
            <td class="headerListagem">Telefone Responsável</td>
            <td class="headerListagem"></td>
            <td class="headerListagem"></td>
        </tr>

        <?php 
        include_once "../classes/Fornecedor.php";
        include_once "../classes/Banco.php";
        
        if (isset($_GET['pesquisa']))
        {
            $pesquisa = $_GET['pesquisa'];
            $vetor = Fornecedor::listarPesquisa($link, $pesquisa);
        }
        else
        {
            $vetor = Fornecedor::listarTodos($link);
        }

        for ($i = 0; $i < count($vetor); $i++)
        {
            $id = $vetor[$i][0];
            $nome = $vetor[$i][1];
            $responsavel = $vetor[$i][2];
            $tel_responsavel = $vetor[$i][3];
            $id_endereco = $vetor[$i][4];
            $inativado = $vetor[$i][5];
            if ($inativado == false) {
                echo '<tr>';
                echo '<td>' . $id . '</td>';
                echo '<td>' . $nome . '</td>';
                echo '<td>' . $responsavel . '</td>';
                echo '<td>' . $tel_responsavel . '</td>';
                
                echo  '<td style="max-width: 300px; min-width: 80px;">';
                echo '<form action="../classes/Fornecedor.php" method="POST">';
                echo '<button type="submit" name="visualizarEndereco">Visualizar Endereco</button>';
                echo '<button type="submit" name="alterar" class="btnEditar"><img src="../img/lapis.png" class="btnEditar" width="40px" height="40px"></button>';
                echo '<button type="submit" name="excluir" class="btnExcluir"><img src="../img/lixeira.png" class="btnExcluir" width="40px" height="40px"></a>';
                echo '<input type="hidden" name="id_fornecedor" value=' . $id . '>';
                echo '<input type="hidden" name="id_endereco" value=' . $id_endereco . '>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            
        }
        ?>
    </table>

    <div>
    <button class="btnAzul" onclick="location.href='../fornecedor/cadastrarFornecedor.php'" type="button">Cadastrar novo fornecedor</button>
    </div>

    
</body>
</html>