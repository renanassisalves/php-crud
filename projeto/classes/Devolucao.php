<?php
require "Banco.php";

if(isset($_POST['cadastrar']))
{

    date_default_timezone_set('America/Sao_Paulo');
    $data = date('d/m/Y h:i:s', time());


    $listaProdutos = $_POST['lista_id'];
    $listaQuantidade = $_POST['lista_quantidade'];
    
    $listaProdutos = explode(",", $listaProdutos);
    $listaQuantidade = explode(",", $listaQuantidade);

    if (Devolucao::validar($listaProdutos[0] and Devolucao::validar($listaQuantidade[0])))
    {
        $devolucao = new Devolucao($data);
        $devolucao->cadastrar($link, $listaProdutos, $listaQuantidade);
    }
    else
    {
        header('location:../devolucao/cadastrarDevolucao.php?resultado=Verifique todos os campos!');
    }
    
    
}

// if(isset($_POST['alterar']))
// {
//     $id = $_POST['id'];
//     header('location:../devolucao/alterarDevolucao.php?id=' . $id);   
// }

// if(isset($_POST['alterarconfirma']))
// {
//     $id = $_POST['id'];
//     $nome = $_POST['nome'];
//     Devolucao::alterar($link, $id, $nome);
// }

if(isset($_POST['pesquisar']))
{
    $pesquisa = $_POST['pesquisarSearch'];
    header('location:../devolucao/visualizarDevolucoes.php?pesquisa=' . $pesquisa);
}

if(isset($_POST['excluir']))
{
    $id = $_POST['id'];
    Devolucao::excluir($link, $id);
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

    header('location:../devolucao/selecionarProdutos.php?lista_id='.$lista_id.'&lista_quantidade='.$lista_quantidade);
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
   header('location:../devolucao/selecionarProdutos.php?lista_id='.$lista_id.'&lista_quantidade='.$lista_quantidade);
}

if(isset($_POST['removerDevolucao']))
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
   header('location:../devolucao/cadastrarDevolucao.php?lista_id='.$lista_id.'&lista_quantidade='.$lista_quantidade);
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
   header('location:../devolucao/cadastrarDevolucao.php?lista_id='.$lista_id.'&lista_quantidade='.$lista_quantidade);
}

if(isset($_POST['visualizarProdutos']))
{
    $id_devolucao = $_POST['id'];
    header('location:../devolucao/visualizarProdutosDevolucao.php?id_devolucao='.$id_devolucao);
}


class Devolucao
{
    private $id;
    private $data_devolucao;

    public function __construct(String $data_devolucao)
    {
        $this->data_devolucao = $data_devolucao;
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
        if ($this::validar($listaProdutos[0]) and $this::validar($listaQuantidade[0]))
        {
            mysqli_query($link, "insert into devolucao(data_devolucao, inativado)
            values(now(), false)");
    
            if (mysqli_error($link)>0)
            {
                header('location:../devolucao/cadastrarDevolucao.php?resultado=' . mysqli_error($link));
            } else
            {
                $query = "insert into devolucao_produto(id_produto, id_devolucao, quantidade) values";
                

                $idDevolucao = mysqli_insert_id($link);
                for ($i=0; $i < sizeof($listaProdutos); $i++) { 
                    if ($i == sizeof($listaProdutos)-1)
                    {
                        $query = $query."(".$listaProdutos[$i].", ". $idDevolucao.", ". $listaQuantidade[$i] .");";
                    }
                    else
                    {
                        $query = $query."(".$listaProdutos[$i].", ". $idDevolucao.", ". $listaQuantidade[$i] ."),";
                    } 
                    $queryQuantidade = mysqli_query($link, "SELECT quantidade FROM produto WHERE id = ".$listaProdutos[$i].";");
                    $quantidadeAtual = mysqli_fetch_row($queryQuantidade);
                    $query2 = "update produto set quantidade = " . max(($quantidadeAtual[0] - $listaQuantidade[$i]),0)  . " where id = ". $listaProdutos[$i].";";
                    mysqli_query($link, $query2);
                }
                mysqli_query($link, $query);
            }
            
            if (mysqli_error($link)>0)
                {
                header('location:../devolucao/cadastrarDevolucao.php?resultado=' . mysqli_error($link));
                }
                else {
                    header('location:../devolucao/cadastrarDevolucao.php?resultado=sucesso');
                }
        }
        else
        {
            header('location:../devolucao/cadastrarDevolucao.php?resultado=Verifique todos os campos!');
        }
    }


    public static function excluir(mysqli $link, int $id)
    {
        mysqli_query($link, "delete from devolucao where id=" . $id . ";" );
        header('location:../categoria/visualizarCategorias.php');

        if (mysqli_error($link)>0)
            {
                header('location:../categoria/visualizarCategorias.php?resultado=' . mysqli_error($link));
            } else
            {
                header('location:../categoria/visualizarCategorias.php?resultado=excluidosucesso');
            }
    }

    public static function pegarDevolucao(mysqli $link, int $id)
    {
        $sql = mysqli_query($link, "select * from devolucao where id=$id;");
        $resultado = mysqli_fetch_row($sql);
        return $resultado;
    }

    public static function pegarQuantidadeProdutoDevolucao(mysqli $link, int $id_devolucao, int $id_produto)
    {
        $sql = mysqli_query($link, "select * from devolucao_produto where id_devolucao=$id_devolucao and id_produto=$id_produto;");
        $resultado = mysqli_fetch_row($sql);
        return $resultado;
    }

    public static function listarTodos(mysqli $link)
    {
        $sql = mysqli_query($link, "select * from devolucao;");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }

    public static function listarPesquisa(mysqli $link, $pesquisa)
    {
        $sql = mysqli_query($link, "select * from devolucao where nome like '%$pesquisa%';");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }
}
?>