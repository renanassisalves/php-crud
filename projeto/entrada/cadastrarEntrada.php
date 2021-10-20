<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Entrada</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <ul>
        <img src="../img/logo.png" class="logo" alt="Exemplo de logomarca" width="60" height="60">
        <li><a href="#" class="active">Cadastrar entrada</a></li>
        <li><a href="../entrada/visualizarEntradas.php">Visualizar entradas</a></li>
        <a href="../index.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <!--<button type="submit" class="btnBuscarProdutos"><img src="/img/logo.png" height="30px" width="30px"> </img>Buscar Produtos</button>-->    
    <h1>Cadastrar Entrada</h1>

    <?php
    include_once "../classes/Produto.php";
    include_once "../classes/Banco.php";
    if(isset($_GET['id_fornecedor']))
    {
        $id_fornecedor = $_GET['id_fornecedor'];
    }
    if(isset($_GET['nome_fornecedor']))
    {
        $nome_fornecedor = $_GET['nome_fornecedor'];
    }
    
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

    
        <label class="label" style="margin-left: 380px;">Lista de produtos</label>
            <div style="width:800px; border-radius: 10px;" class="divProdutos">
            
            <table style="width: 100%">
                <tr>
                    <td class="headerListagemProdutos">ID</td>
                    <td class="headerListagemProdutos">Nome do Produto</td>
                    <td class="headerListagemProdutos">Categoria</td>
                    <td class="headerListagemProdutos">Preço (R$)</td>
                    <td class="headerListagemProdutos">Quantidade Estoque</td>
                    <td class="headerListagemProdutos">Quantidade Entrada</td>
                    <td class="headerListagemProdutos"></td>
                </tr>

                <?php 
        include_once "../classes/Produto.php";
        include_once "../classes/Categoria.php";
        include_once "../classes/Banco.php";
        // if (isset($_GET['pesquisa']))
        // {
        //     $pesquisa = $_GET['pesquisa'];
        //     $vetor = Produto::listarPesquisa($link, $pesquisa);
        // }
        // else
        // {
        //     $vetor = Produto::listarTodos($link);
        // }
            
        if (isset($_GET['lista_id']))
        {
            $lista_id = $_GET['lista_id'];
            $lista_array = explode(",", $_GET["lista_id"]);
            $lista_array = array_values(array_unique($lista_array));
        }

        if (isset($_GET['lista_quantidade']))
        {
            $lista_quantidade = $_GET['lista_quantidade'];
            $lista_quantidade_array = explode(",", $_GET["lista_quantidade"]);
            print_r($lista_quantidade_array);
        }

        if (isset($lista_array))
        {
            for ($i = 0; $i < sizeof($lista_array); $i++)
            {
                if (!empty($lista_array[$i]))
                {

                
                $vetor = Produto::pegarProduto($link, $lista_array[$i]);
                $id = $vetor[0];
                $nome = $vetor[1];
                $preco = $vetor[2];
                $quantidade = $vetor[3];
                $lucro_liquido = $vetor[4];
                $id_categoria = $vetor[5];
                $inativado = $vetor[6];
    
                $categoria = Categoria::pegarCategoria($link, $id_categoria);
                $categoriaTexto = $categoria[0] . " - " . $categoria[1];

                if (($index = array_search($id, $lista_array)) !== false) {
                    $quantidadeEntrada = ($lista_quantidade_array[$index]);
                }

                if ($inativado == false) {
                    echo '<tr>';
                    echo '<td>' . $id . '</td>';
                    echo '<td>' . $nome . '</td>';
                    echo '<td>' . $categoriaTexto . '</td>';
                    echo '<td>' . $preco . '</td>';
                    echo '<td>' . $quantidade . '</td>';
                    
                    ###QUANTIDADE ENTRADA
                    echo '<td style="width: 180px; min-width: 60px;">';
                    echo '<form action="../classes/Entrada.php" method="POST" style="display:inline;">';
                    if ($quantidadeEntrada != 0) {
                        echo '<input type="number" name="quantidade" value="'.$quantidadeEntrada.'" min="0.00" max="1000" style="margin:0px; padding:0px; width:60px; height:40px; background-color:lightgreen">';
                    }
                    else
                    {
                        echo '<input type="number" name="quantidade" value="'.$quantidadeEntrada.'" min="0.00" max="1000" style="margin:0px; padding:0px; width:60px; height:40px; background-color:lightcoral">';
                    }
                    
                    echo '<button type="submit" name="adicionarQuantidade" class="btnExcluir"><img src="../img/mais.jpg" class="btnExcluir" width="40px" height="40px"></a>';
                    echo '<input type="hidden" name="id_adicionar" value="'.$id.'">';
                    if (isset($_GET['lista_id']))
                    {
                        echo '<input type="hidden" name="lista_id" value="'.$lista_id.'">';
                    }
                    if (isset($_GET['lista_quantidade']))
                    {
                        echo '<input type="hidden" name="lista_quantidade" value="'.$lista_quantidade.'">';
                    }
                    echo '</form>';
                    echo '</td>';

                    ###BOTAO REMOVER
                    echo '<td style="max-width: 80px; min-width: 60px;">';
                    echo '<form action="../classes/Entrada.php" method="POST">';
                    echo '<button type="submit" name="removerEntrada" class="btnExcluir"><img src="../img/lixeira.png" class="btnExcluir" width="40px" height="40px"></a>';
                    echo '<input type="hidden" name="id_remover" value="'.$id.'">';
                    if (isset($_GET['lista_id']))
                    {
                        echo '<input type="hidden" name="lista_id" value="'.$lista_id.'">';
                    }
                    if (isset($_GET['lista_quantidade']))
                    {
                        echo '<input type="hidden" name="lista_quantidade" value="'.$lista_quantidade.'">';
                    }
                    echo '</form>';
                    echo '</td>';

                    echo '</tr>';
                }
                
            }
        }
        }
        ?>
            </table>
        </tr>
        </div>
        <div>
            
        <button class="btnAzul" onclick="location.href='../entrada/selecionarProdutos.php<?php
        echo '?lista_id=';
        if(!empty($lista_array)) {
        echo implode(',', $lista_array);
        }

        echo '&lista_quantidade=';

        if(!empty($lista_quantidade_array)) {
        echo implode(',', $lista_quantidade_array);
        }
        
        ?>'" type="button">Selecionar produtos</button>
        </div>
        <br>
        <div>
        <label class="label">Fornecedor do Produto
            <input type="text" name="fornecedor" disabled <?php if(isset($_GET['id_fornecedor'])) {echo('value="'.$id_fornecedor.' - '.$nome_fornecedor);} ?> ">
        </label>
        
        <button class="btnAzul" onclick="location.href='../fornecedor/selecionarFornecedor.php<?php if(!empty($lista_array)) {
        echo '?lista_id=';
        echo implode(',', $lista_array);
        }
        
        if(!empty($lista_quantidade_array)) {
        echo '&lista_quantidade=';
        echo implode(',', $lista_quantidade_array);
        }
        
        ?>'" type="button">Selecionar o Fornecedor</button>
        </div>
        <div>
        </div>

        <form action="../classes/Entrada.php" method="POST">
        <input type="hidden" name="id_fornecedor" value="<?php if(isset($_GET['id_fornecedor'])) { echo($id_fornecedor); }?>">
        <input type="hidden" name="lista_id" value="<?php if(isset($_GET['lista_id'])) { echo($lista_id); }?>">
        <input type="hidden" name="lista_quantidade" value="<?php if(isset($_GET['lista_quantidade'])) { echo($lista_quantidade); }?>">
        <button type="submit" name="cadastrar" class="btnEnviar">Cadastrar</button>
        </form>
    
</body>
</html>