<?php
require "Banco.php";

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
    header('location:../categoria/visualizarCategorias.php?pesquisa=' . $pesquisa);
}

if(isset($_POST['selecionado']))
{
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    
    header('location:../produto/cadastrarProduto.php?id='.$id.'&nome='.$nome);
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
        mysqli_query($link, "delete from categoria where id=" . $id . ";" );
        header('location:../categoria/visualizarCategorias.php');

        if (mysqli_error($link)>0)
            {
                header('location:../categoria/visualizarCategorias.php?resultado=' . mysqli_error($link));
            } else
            {
                header('location:../categoria/visualizarCategorias.php?resultado=excluidosucesso');
            }
    }

    public static function pegarCategoria(mysqli $link, int $id)
    {
        $sql = mysqli_query($link, "select * from categoria where id=$id;");
        $resultado = mysqli_fetch_row($sql);
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