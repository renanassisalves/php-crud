<?php
require "Banco.php";

if(isset($_POST['cadastrar']))
{

    date_default_timezone_set('America/Sao_Paulo');
    $data = date('d/m/Y h:i:s', time());

    $id_fornecedor = $_POST['id_fornecedor'];
    $listaProdutos = $_POST['lista_id'];
    $listaQuantidade = $_POST['lista_quantidade'];
    
    $listaProdutos = explode(",", $listaProdutos);
    $listaQuantidade = explode(",", $listaQuantidade);

    if (Entrada::validar($id_fornecedor) and Entrada::validar($listaProdutos[0] and Entrada::validar($listaQuantidade[0])))
    {
        $entrada = new Entrada($data, $id_fornecedor);
        $entrada->cadastrar($link, $listaProdutos, $listaQuantidade);
    }
    else
    {
        header('location:../entrada/cadastrarEntrada.php?resultado=Verifique todos os campos!');
    }
    
    
}

// if(isset($_POST['alterar']))
// {
//     $id = $_POST['id'];
//     header('location:../entrada/alterarEntrada.php?id=' . $id);   
// }

// if(isset($_POST['alterarconfirma']))
// {
//     $id = $_POST['id'];
//     $nome = $_POST['nome'];
//     Entrada::alterar($link, $id, $nome);
// }

if(isset($_POST['pesquisar']))
{
    $pesquisa = $_POST['pesquisarSearch'];
    header('location:../entrada/visualizarEntradas.php?pesquisa=' . $pesquisa);
}

if(isset($_POST['excluir']))
{
    $id = $_POST['id'];
    Entrada::excluir($link, $id);
}

if(isset($_POST['selecionadofornecedor']))
{
    $id = $_POST['id_fornecedor'];
    $nome = $_POST['nome_fornecedor'];
    
    if (!empty($_POST['lista_id']))
    {
        header('location:../entrada/cadastrarEntrada.php?id_fornecedor='.$id.'&nome_fornecedor='.$nome.'&lista_id='.$_POST['lista_id'].'&lista_quantidade='.$_POST['lista_quantidade']);
    } else {
        header('location:../entrada/cadastrarEntrada.php?id_fornecedor='.$id.'&nome_fornecedor='.$nome);
    }
}

if(isset($_POST['adicionar']))
{
    $id_novo = $_POST['id_novo'];
    $lista_id = $_POST['lista_id'];
    $lista_quantidade = $_POST['lista_quantidade'];
    
    if(isset($_POST['lista_id']))
    {
        if(!empty($lista_id))
        {
            $lista_id= $lista_id.','.$id_novo;
            $lista_quantidade=$lista_quantidade.','.'0';
        }
        else
        {
            $lista_id = $id_novo;
            $lista_quantidade = 0;
        }
    }
    else
    {
        $lista_id = $id_novo;
        $lista_quantidade = 0;
    }

    header('location:../entrada/selecionarProdutos.php?lista_id='.$lista_id.'&lista_quantidade='.$lista_quantidade);
}

if(isset($_POST['remover']))
{
    $id_remover = ($_POST['id_remover']);
    $lista_id = $_POST['lista_id'];
    $lista_id = explode(',', $lista_id);
    $lista_quantidade = $_POST['lista_quantidade'];
    $lista_quantidade = explode(',', $lista_quantidade);

    if (($index = array_search($id_remover, $lista_id)) !== false) {
        unset($lista_id[$index]);
        unset($lista_quantidade[$index]);
    }
    $lista_id = implode(',', $lista_id);
    $lista_quantidade = implode(',', $lista_quantidade);
   header('location:../entrada/selecionarProdutos.php?lista_id='.$lista_id.'&lista_quantidade='.$lista_quantidade);
}

if(isset($_POST['removerEntrada']))
{
    $id_remover = ($_POST['id_remover']);
    $lista_id = $_POST['lista_id'];
    $lista_id = explode(',', $lista_id);
    $lista_quantidade = $_POST['lista_quantidade'];
    $lista_quantidade = explode(',', $lista_quantidade);

    if (($index = array_search($id_remover, $lista_id)) !== false) {
        unset($lista_id[$index]);
        unset($lista_quantidade[$index]);
    }

    $lista_id = implode(',', $lista_id);
    $lista_quantidade = implode(',', $lista_quantidade);
   header('location:../entrada/cadastrarEntrada.php?lista_id='.$lista_id.'&lista_quantidade='.$lista_quantidade);
}

if(isset($_POST['adicionarQuantidade']))
{
    $id_adicionar = ($_POST['id_adicionar']);
    $lista_id = $_POST['lista_id'];
    $quantidade = $_POST['quantidade'];
    $lista_id = explode(',', $lista_id);
    $lista_quantidade = $_POST['lista_quantidade'];
    $lista_quantidade = explode(',', $lista_quantidade);

    if (($index = array_search($id_adicionar, $lista_id)) !== false) {
        
        $lista_quantidade[$index]  = $quantidade;
    }
    
    $lista_id = implode(',', $lista_id);
    $lista_quantidade = implode(',', $lista_quantidade);
   header('location:../entrada/cadastrarEntrada.php?lista_id='.$lista_id.'&lista_quantidade='.$lista_quantidade);
}

if(isset($_POST['visualizarProdutos']))
{
    $id_entrada = $_POST['id'];
    header('location:../entrada/visualizarProdutosEntrada.php?id_entrada='.$id_entrada);
}

if(isset($_POST['visualizarEndereco']))
{
    $id = $_POST['id_endereco'];
    $origem = $_POST['origem'];
    header('location:../fornecedor/visualizarEndereco.php?id_endereco=' . $id . '&origem=' . $origem);
}

class Entrada
{
    private $id;
    private $data_entrada;
    private $id_fornecedor;

    public function __construct(String $data_entrada, int $id_fornecedor)
    {
        $this->data_entrada = $data_entrada;
        $this->id_fornecedor = $id_fornecedor;
        $this->inativado = false;
    }

    public static function validar(string $campo)
    {
        if (empty($campo)) {
            return false;
        } else
        {
            return true;
        }
    }

    public static function formatar(string $campo)
    {
        $campo = trim($campo);
        $campo = str_replace("'", "", $campo);
        return $campo;
    }

    public function cadastrar(mysqli $link, Array $listaProdutos, Array $listaQuantidade)
    {
        
        $id_fornecedor = $this::formatar($this->id_fornecedor);
        if ($this::validar($id_fornecedor))
        {
            mysqli_query($link, "insert into entrada(data_entrada, id_fornecedor, inativado)
            values(now(), $id_fornecedor, false)");
    
            if (mysqli_error($link)>0)
            {
                header('location:../entrada/cadastrarEntrada.php?resultado=' . mysqli_error($link));
            } else
            {
                $query = "insert into entrada_produto(id_produto, id_entrada, quantidade) values";
                

                $idEntrada = mysqli_insert_id($link);
                for ($i=0; $i < sizeof($listaProdutos); $i++) { 
                    if ($i == sizeof($listaProdutos)-1)
                    {
                        $query = $query."(".$listaProdutos[$i].", ". $idEntrada.", ". $listaQuantidade[$i] .");";
                    }
                    else
                    {
                        $query = $query."(".$listaProdutos[$i].", ". $idEntrada.", ". $listaQuantidade[$i] ."),";
                    } 
                    $queryQuantidade = mysqli_query($link, "SELECT quantidade FROM produto WHERE id = ".$listaProdutos[$i].";");
                    $quantidadeAtual = mysqli_fetch_row($queryQuantidade);
                    $query2 = "update produto set quantidade = " . $quantidadeAtual[0] + $listaQuantidade[$i] . " where id = ". $listaProdutos[$i].";";
                    mysqli_query($link, $query2);
                }
                mysqli_query($link, $query);
            }
            
            if (mysqli_error($link)>0)
                {
                header('location:../entrada/cadastrarEntrada.php?resultado=' . mysqli_error($link));
                }
                else {
                    header('location:../entrada/cadastrarEntrada.php?resultado=sucesso');
                }
        }
        else
        {
            header('location:../entrada/cadastrarEntrada.php?resultado=Verifique todos os campos!');
        }
    }


    public static function excluir(mysqli $link, int $id)
    {
        mysqli_query($link, "delete from entrada where id=" . $id . ";" );
        header('location:../categoria/visualizarCategorias.php');

        if (mysqli_error($link)>0)
            {
                header('location:../categoria/visualizarCategorias.php?resultado=' . mysqli_error($link));
            } else
            {
                header('location:../categoria/visualizarCategorias.php?resultado=excluidosucesso');
            }
    }

    public static function pegarEntrada(mysqli $link, int $id)
    {
        $sql = mysqli_query($link, "select * from entrada where id=$id;");
        $resultado = mysqli_fetch_row($sql);
        return $resultado;
    }

    public static function pegarQuantidadeProdutoEntrada(mysqli $link, int $id_entrada, int $id_produto)
    {
        $sql = mysqli_query($link, "select * from entrada_produto where id_entrada=$id_entrada and id_produto=$id_produto;");
        $resultado = mysqli_fetch_row($sql);
        return $resultado;
    }

    public static function listarTodos(mysqli $link)
    {
        $sql = mysqli_query($link, "select * from entrada;");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }

    public static function listarPesquisa(mysqli $link, $pesquisa)
    {
        $sql = mysqli_query($link, "select * from entrada where nome like '%$pesquisa%';");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }
}
?>