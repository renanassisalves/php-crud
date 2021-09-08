<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Categoria</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <ul>
        <img src="../img/logo.png" class="logo" alt="Exemplo de logomarca" width="60" height="60">
        <li><a href="cadastrarFornecedor.php">Cadastrar Fornecedor</a></li>
        <li><a href="visualizarFornecedor.php" class="active">Visualizar Fornecedor</a></li>
        <a href="../index.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <h1>Visualizar Fornecedores</h1>
    <table style="width: 100%">
        <tr>
            <td class="headerListagem">ID</td>
            <td class="headerListagem">Nome do Fornecedor</td>
            <td class="headerListagem">Responsavel</td>
            <td class="headerListagem">Telefone Responsável</td>
            <td class="headerListagem"></td>
            <td class="headerListagem"></td>
        </tr>

        <?php 
        include_once "../classes/Fornecedor.php";
        include_once "../classes/Banco.php";
        
        $vetor = Fornecedor::listarTodos($link);

        for ($i = 0; $i < count($vetor); $i++)
        {
            $id = $vetor[$i][0];
            $nome = $vetor[$i][1];
            $responsavel = $vetor[$i][2];
            $tel_responsavel = $vetor[$i][3];
            $inativado = $vetor[$i][5];
            if ($inativado == false) {
                echo '<tr>';
                echo '<td>' . $id . '</td>';
                echo '<td>' . $nome . '</td>';
                echo '<td>' . $responsavel . '</td>';
                echo '<td>' . $tel_responsavel . '</td>';
                echo '<td><button>Visualizar Endereco</button></td>';
                echo  '<td style="max-width: 60px; min-width: 60px;">';
                echo '<form action="../classes/Fornecedor.php" method="POST">';
                echo '<button type="submit" name="alterar" class="btnEditar"><img src="../img/lapis.png" class="btnEditar" width="40px" height="40px"></button>';
                echo '<button type="submit" name="excluir" class="btnExcluir"><img src="../img/lixeira.png" class="btnExcluir" width="40px" height="40px"></a>';
                echo '<input type="hidden" name="id" value=' . $id . '>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            
        }
        ?>
    </table>

    
</body>
</html>