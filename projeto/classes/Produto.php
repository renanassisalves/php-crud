<?php
require "Banco.php";

if(isset($_POST['cadastrar']))
{
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $lucro_liquido = $_POST['lucro_liquido'];
    $id_categoria = $_POST['id_categoria'];
    $id_fornecedor = $_POST['id_fornecedor'];
    $produto = new Produto($nome, $preco, $quantidade, $lucro_liquido, $id_categoria, $id_fornecedor);
    $produto->cadastrar($link);
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
    Produto::alterar($link, $id, $nome);
}

if(isset($_POST['excluir']))
{
    $id = $_POST['id'];
    Produto::excluir($link, $id);
}

class Produto
{
    private $id;
    private $nome;
    private $preco;
    private $quantidade;
    private $lucro_liquido;
    private $id_categoria;
    private $id_fornecedor;
    private $inativado;

    public function __construct(string $nome, float $preco, int $quantidade, float $lucro_liquido, int $id_categoria, int $id_fornecedor)
    {
        $this->nome = $nome;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
        $this->lucro_liquido = $lucro_liquido;
        $this->id_categoria = $id_categoria;
        $this->id_fornecedor = $id_fornecedor;
        $this->inativado = false;
    }

    public function cadastrar(mysqli $link)
    {
        mysqli_query($link, "insert into produto(nome, preco, quantidade, lucro_liquido, id_categoria, id_fornecedor, inativado)
        values('$this->nome', $this->preco, $this->quantidade, $this->lucro_liquido, $this->id_categoria, $this->id_fornecedor, false);");
        header('location:../categoria/cadastrarProduto.php');
    }

    public static function alterar(mysqli $link, $id, $novoNome)
    {
        mysqli_query($link, 'update categoria set nome = "'. $novoNome . '" where id = ' . $id . ';');
        header('location:../categoria/visualizarCategorias.php');
    }

    public static function excluir(mysqli $link, int $id)
    {
        mysqli_query($link, "delete from produto where id=" . $id . ";" );
        header('location:../categoria/visualizarCategorias.php');
    }

    public static function listarTodos(mysqli $link)
    {
        $sql = mysqli_query($link, "select * from produto;");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }
}
?>