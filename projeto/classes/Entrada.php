<?php
require "Banco.php";

if(isset($_POST['cadastrar']))
{

    date_default_timezone_set('America/Sao_Paulo');
    $data = date('d/m/Y h:i:s', time());

    $id_fornecedor = $_POST['id_fornecedor'];
    $listaProdutos = $_POST['lista_id'];
    
    $listaProdutos = explode(",", $listaProdutos);
    $entrada = new Entrada($data, $id_fornecedor);
    $entrada->cadastrar($link, $listaProdutos);
}

if(isset($_POST['alterar']))
{
    $id = $_POST['id'];
    header('location:../categoria/alterarCategoria.php?id=' . $id);   
}

if(isset($_POST['alterarconfirma']))
{
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    Entrada::alterar($link, $id, $nome);
}

if(isset($_POST['pesquisar']))
{
    $pesquisa = $_POST['pesquisarSearch'];
    header('location:../categoria/visualizarEntradas.php?pesquisa=' . $pesquisa);
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
        header('location:../entrada/cadastrarEntrada.php?id_fornecedor='.$id.'&nome_fornecedor='.$nome.'&lista_id='.$_POST['lista_id']);
    } else {
        header('location:../entrada/cadastrarEntrada.php?id_fornecedor='.$id.'&nome_fornecedor='.$nome);
    }
    
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
       
        $validacao = false;

        if (empty($campo)) {
            header('location:../entrada/cadastrarEntrada.php?resultado=Verifique todos os campos!');
            $validacao = false;
        } else
        {
            $validacao = true;
        }

        if ($validacao)
        {
            return true;
        }
        else {
            return false;
        }
    }

    public static function formatar(string $campo)
    {
        $campo = trim($campo);
        $campo = str_replace("'", "", $campo);
        return $campo;
    }

    public function cadastrar(mysqli $link, Array $listaProdutos)
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
                        $query = $query."(".$listaProdutos[$i].", ". $idEntrada.", ". 3 .");";
                    }
                    else
                    {
                        $query = $query."(".$listaProdutos[$i].", ". $idEntrada.", ". 3 ."),";
                    }
                    
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

    public static function alterar(mysqli $link, $id, $novoNome)
    {
        $novoNome = Categoria::formatar($novoNome);
        if(Categoria::validar($novoNome))
        {
            mysqli_query($link, 'update categoria set nome = "'. $novoNome . '" where id = ' . $id . ';');
            header('location:../categoria/cadastrarCategoria.php');
            
            if (mysqli_error($link)>0)
                {
                    header('location:../categoria/visualizarCategorias.php?resultado=' . mysqli_error($link));
                } else
                {
                    header('location:../categoria/visualizarCategorias.php?resultado=alteradosucesso');
                }
        }
        else
        {
            header('location:../categoria/alterarCategoria.php?id='.$id.'&?resultado=Verifique todos os campos!');
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