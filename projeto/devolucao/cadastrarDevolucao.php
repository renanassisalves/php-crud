<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Devolução</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <ul>
        <img src="../img/logo.png" class="logo" alt="Exemplo de logomarca" width="60" height="60">
        <li><a href="#" class="active">Cadastrar Devolução</a></li>
        <li><a href="../devolucao/visualizarDevolucoes.php">Visualizar Devoluções</a></li>
        <a href="../inicio.php" class="voltar"><img src="../img/voltar.png" class="voltar" width="60px" height="60px"></a>
    </ul>

    <!--<button type="submit" class="btnBuscarProdutos"><img src="/img/logo.png" height="30px" width="30px"> </img>Buscar Produtos</button>-->    
    <h1>Cadastrar Devolução</h1>

    <?php
    include_once "../classes/Produto.php";
    include_once "../classes/Banco.php";
    
    if(isset($_GET['resultado']))
    {
        $resultado = $_GET['resultado'];
        if ($resultado == 'sucesso')
        {
            echo('<div style="background-color: #b1ffb8b1;">');
            echo('<p style="color: #1a571fb1; margin: 20px;">Cadastrado com sucesso!</p>');
            echo('</div>');
        }
        else if ($resultado == 'erroquantidade')
        {
            echo('<div style="background-color: #ff9d9448;">');
            echo('<p style="color: #c51d0d; margin: 20px;">Erro : A quantidade a ser devolvida de um produto é maior do que a quantidade em estoque disponível!</p>');
            echo('</div>');
        }
        else
        {
            echo('<div style="background-color: #ff9d9448;">');
            echo('<p style="color: #c51d0d; margin: 20px;">Erro : ' . $resultado . '</p>');
            echo('</div>');
        }
    }

    ?>

    
        <label class="label" style="margin-left: 380px;">Lista de produtos</label>
            <div style="width:800px; border-radius: 10px; margin-left: 20px" class="divProdutos">
            
            <table style="width: 100%">
                <tr>
                    <td class="headerListagemProdutos">ID</td>
                    <td class="headerListagemProdutos">Nome do Produto</td>
                    <td class="headerListagemProdutos">Categoria</td>
                    <td class="headerListagemProdutos">Preço (R$)</td>
                    <td class="headerListagemProdutos">Quantidade Estoque</td>
                    <td class="headerListagemProdutos">Quantidade Devolucao</td>
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
            // print_r($lista_quantidade_array);
        }

        if (isset($lista_array))
        {
            $precoTotal = 0;
            $quantidadeTotal = 0;
            $quantidadeEntradaTotal = 0;
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
                    $quantidadeDevolucao = ($lista_quantidade_array[$index]);
                }

                $precoTotal = $precoTotal += ($preco*$quantidadeDevolucao);
                $quantidadeTotal = $quantidadeTotal += $quantidade;
                $quantidadeEntradaTotal=$quantidadeEntradaTotal+=$quantidadeDevolucao;

                if ($inativado == false) {
                    echo '<tr>';
                    echo '<td>' . $id . '</td>';
                    echo '<td>' . $nome . '</td>';
                    echo '<td>' . $categoriaTexto . '</td>';
                    echo '<td>' . $preco . '</td>';
                    echo '<td>' . $quantidade . '</td>';
                    
                    ###QUANTIDADE ENTRADA
                    echo '<td style="width: 180px; min-width: 60px;">';
                    echo '<form action="../classes/Devolucao.php" method="POST" style="display:inline;">';
                    if ($quantidadeDevolucao != 0) {
                        echo '<input type="number" name="quantidade" value="'.$quantidadeDevolucao.'" min="0.00" max="1000" style="margin:0px; padding:0px; width:60px; height:40px; background-color:lightgreen">';
                    }
                    else
                    {
                        echo '<input type="number" name="quantidade" value="'.$quantidadeDevolucao.'" min="0.00" max="1000" style="margin:0px; padding:0px; width:60px; height:40px; background-color:lightcoral">';
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
                    echo '<input type="hidden" name="quantidadeatual" value="'.$quantidade.'">';
                    echo '</form>';
                    echo '</td>';

                    ###BOTAO REMOVER
                    echo '<td style="max-width: 80px; min-width: 60px;">';
                    echo '<form action="../classes/Devolucao.php" method="POST">';
                    echo '<button type="submit" name="removerDevolucao" class="btnExcluir"><img src="../img/lixeira.png" class="btnExcluir" width="40px" height="40px"></a>';
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
        if (isset($_GET['lista_id']))
        {

                echo '<tr style=background-color:grey;>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td>Estoque total ' . $quantidadeTotal . '</td>';
                echo '<td>Quantidade total '.$quantidadeEntradaTotal.'</td>';
                echo '<td>Preço total R$ ' . $precoTotal . '</td>';
                echo '</tr>';
            
        }
        ?>
            </table>
        </tr>
        </div>
        <div>
            
        <button class="btnAzul" onclick="location.href='../devolucao/selecionarProdutos.php<?php
        echo '?lista_id=';
        if(!empty($lista_array)) {
        echo implode(',', $lista_array);
        }

        echo '&lista_quantidade=';

        if(!empty($lista_quantidade_array)) {
        echo implode(',', $lista_quantidade_array);
        }
        
        ?>'" type="button" style="margin-left: 20px">Selecionar produtos</button>
        </div>
        <br>
        
        <div>
        </div>

        <form action="../classes/Devolucao.php" method="POST">
        <input type="hidden" name="lista_id" style="margin-left: 20px" value="<?php if(isset($_GET['lista_id'])) { echo($lista_id); }?>">
        <input type="hidden" name="lista_quantidade" style="margin-left: 20px" value="<?php if(isset($_GET['lista_quantidade'])) { echo($lista_quantidade); }?>">
        <button type="submit" name="cadastrar" class="btnEnviar" style="margin-left: 10px">Cadastrar</button>
        </form>
    
</body>
</html>