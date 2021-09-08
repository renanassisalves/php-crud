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

    public function cadastrar(mysqli $link)
    {
        mysqli_query($link, "insert into categoria(nome, inativado)
        values('$this->nome', false)");
        header('location:../categoria/cadastrarCategoria.php');
    }

    public static function alterar(mysqli $link, $id, $novoNome)
    {
        mysqli_query($link, 'update categoria set nome = "'. $novoNome . '" where id = ' . $id . ';');
        header('location:../categoria/visualizarCategorias.php');
    }

    public static function excluir(mysqli $link, int $id)
    {
        mysqli_query($link, "delete from categoria where id=" . $id . ";" );
        header('location:../categoria/visualizarCategorias.php');
    }

    public static function listarTodos(mysqli $link)
    {
        $sql = mysqli_query($link, "select * from categoria;");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }
}
?>