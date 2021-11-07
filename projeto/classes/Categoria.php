<?php
require "Banco.php";
require "Log.php";

session_start();

if(isset($_POST['cadastrar']))
{
    $nome = $_POST['nome'];
    $categoria = new Categoria($nome);
    $categoria->cadastrar($link);
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
    Categoria::alterar($link, $id, $nome);
}

if(isset($_POST['excluir']))
{
    $id = $_POST['id'];
    Categoria::excluir($link, $id);
}

if(isset($_POST['pesquisar']))
{
    $pesquisa = $_POST['pesquisarSearch'];
    if(isset($_POST['origem']))
    {
        $origem = $_POST['origem'];    
        header('location: ' . $origem . '&pesquisa=' . $pesquisa);
    }
    else
    {
        header('location:../fornecedor/visualizarCategorias.php?pesquisa=' . $pesquisa);
    }
}    

if(isset($_POST['selecionadoproduto']))
{
    $id_categoria = $_POST['id_categoria'];
    $nome_categoria = $_POST['nome_categoria'];
    $nome_produto = $_POST['nome_produto'];
    $preco_produto = $_POST['preco_produto'];
    $quantidade_produto = $_POST['quantidade_produto'];
    $lucro_liquido_produto = $_POST['lucro_liquido_produto'];
    if(isset($_POST['origem']))
    {
        header('location:../produto/cadastrarProduto.php?id_categoria='.$id_categoria.'&nome_categoria='.$nome_categoria.'&nome_produto='.$nome_produto.'&preco_produto='.$preco_produto.'&quantidade_produto='.$quantidade_produto.'&lucro_liquido_produto='.$lucro_liquido_produto.'&origem='.$_POST['origem']);
    }
    else 
    {
        header('location:../produto/cadastrarProduto.php?id_categoria='.$id_categoria.'&nome_categoria='.$nome_categoria.'&nome_produto='.$nome_produto.'&preco_produto='.$preco_produto.'&quantidade_produto='.$quantidade_produto.'&lucro_liquido_produto='.$lucro_liquido_produto);
    }
    
}

class Categoria
{
    private $id;
    private $nome;
    private $inativado;

    public function __construct(string $nome)
    {
        $this->nome = $nome;
        $this->inativado = false;
    }

    public static function validar(string $campo)
    {
       
        $validacao = false;

        if (empty($campo)) {
            header('location:../categoria/cadastrarCategoria.php?resultado=Verifique todos os campos!');
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

    public function cadastrar(mysqli $link)
    {
        $nome = $this::formatar($this->nome);
        if ($this::validar($nome))
        {
            mysqli_query($link, "insert into categoria(nome, inativado)
            values('$nome', false)");
    
            if (mysqli_error($link)>0)
            {
                header('location:../categoria/cadastrarCategoria.php?resultado=' . mysqli_error($link));
            } else
            {
                header('location:../categoria/cadastrarCategoria.php?resultado=sucesso');
                $log = new log($_SESSION['nome'], "Categoria", "Cadastro de nova categoria", "$nome");
                Log::cadastrar($link, $log);
            }
        }
        else
        {
            header('location:../categoria/cadastrarCategoria.php?resultado=Verifique todos os campos!');
        }
    }

    public static function alterar(mysqli $link, $id, $novoNome)
    {
        $novoNome = Categoria::formatar($novoNome);
        if(Categoria::validar($novoNome))
        {
            $categoriaAtual = Categoria::pegarCategoria($link, $id);
            mysqli_query($link, 'update categoria set nome = "'. $novoNome . '" where id = ' . $id . ';');
            
            if (mysqli_error($link)>0)
                {
                    header('location:../categoria/visualizarCategorias.php?resultado=' . mysqli_error($link));
                } else
                {
                    header('location:../categoria/visualizarCategorias.php?resultado=alteradosucesso');
                    $log = new log($_SESSION['nome'], "Categoria", "$categoriaAtual[1]", "$novoNome");
                    Log::cadastrar($link, $log);
                }
        }
        else
        {
            header('location:../categoria/alterarCategoria.php?id='.$id.'&?resultado=Verifique todos os campos!');
        }
        
    }

    public static function excluir(mysqli $link, int $id)
    {
        mysqli_query($link, "delete from categoria where id=" . $id . ";" );
        header('location:../categoria/visualizarCategorias.php');
        $categoriaAtual = Categoria::pegarCategoria($link, $id);
        if (mysqli_error($link)>0)
            {
                header('location:../categoria/visualizarCategorias.php?resultado=' . mysqli_error($link));
            } else
            {
                header('location:../categoria/visualizarCategorias.php?resultado=excluidosucesso');

                $log = new log($_SESSION['nome'], "Categoria", "Exclusão de categoria", "$categoriaAtual[1]");
                    Log::cadastrar($link, $log);
            }
    }

    public static function pegarCategoria(mysqli $link, int $id)
    {
        $sql = mysqli_query($link, "select * from categoria where id=$id;");
        $resultado = mysqli_fetch_row($sql);
        return $resultado;
    }

    public static function contarProdutosCategoria(mysqli $link, int $id)
    {

    $sql = mysqli_query($link, "SELECT SUM(quantidade) from produto as quantidade_total where id_categoria = $id;");
        $resultado = mysqli_fetch_all($sql);

        return $resultado;
    }

    public static function contarProdutosCategoriaTotal(mysqli $link)
    {

        $sql = mysqli_query($link, "SELECT SUM(quantidade) from produto as quantidade_total;");
        $resultado = mysqli_fetch_all($sql);

        return $resultado;
    }

    public static function listarTodos(mysqli $link)
    {
        $sql = mysqli_query($link, "select * from categoria;");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }

    public static function listarPesquisa(mysqli $link, $pesquisa)
    {
        $sql = mysqli_query($link, "select * from categoria where nome like '%$pesquisa%';");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }
}
?>