<?php
require "Banco.php";

if(isset($_POST['cadastrar']))
{
    $nome = $_POST['nome'];
    $responsavel = $_POST['responsavel'];
    $tel_responsavel = $_POST['tel_responsavel'];
    $longradouro = $_POST['longradouro'];
    $bairro = $_POST['bairro'];
    $numero = $_POST['numero'];
    $cep = $_POST['cep'];
    $endereco = new Endereco($longradouro, $bairro, $numero, $cep);
    $endereco->cadastrar($link);
    $fornecedor = new Fornecedor($nome, $responsavel, $tel_responsavel, $endereco->getId());
    $fornecedor->cadastrar($link);
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
    Fornecedor::alterar($link, $id, $nome);
}

if(isset($_POST['excluir']))
{
    $id = $_POST['id'];
    Fornecedor::excluir($link, $id);
}

class Fornecedor
{
    private $id;
    private $nome;
    private $responsavel;
    private $tel_responsavel;
    private $id_endereco;
    private $inativado;

    public function __construct(string $nome, string $responsavel, string $tel_responsavel, int $id_endereco)
    {
        $this->nome = $nome;
        $this->responsavel = $responsavel;
        $this->tel_responsavel = $tel_responsavel;
        $this->id_endereco = $id_endereco;
        $this->inativado = false;
    }

    public function cadastrar(mysqli $link)
    {
        mysqli_query($link, "insert into fornecedor(nome, responsavel, tel_responsavel, id_endereco, inativado)
        values('$this->nome', '$this->responsavel', '$this->tel_responsavel', $this->id_endereco, false);");
        echo $this->nome, $this->responsavel, $this->tel_responsavel, $this->id_endereco;
        // header('location:../fornecedor/cadastrarFornecedor.php');
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
        $sql = mysqli_query($link, "select * from fornecedor;");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }
}

class Endereco {
    private $id;
    private $longradouro;
    private $bairro;
    private $numero;
    private $inativado;
    private $cep;

    public function __construct(string $longradouro, string $bairro, string $numero, string $cep)
    {
        $this->longradouro = $longradouro;
        $this->bairro = $bairro;
        $this->numero = $numero;
        $this->cep = $cep;
        $this->inativado = false;
    }

    public function cadastrar(mysqli $link)
    {
        mysqli_query($link, "insert into endereco(longradouro, bairro, numero, inativado, cep)
        values('$this->longradouro', '$this->bairro', $this->numero, false, '$this->cep');");
        $this->id = mysqli_insert_id($link);
      
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
        $sql = mysqli_query($link, "select * from endereco;");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }
    public function getId()
    {
        return $this->id;
    }
}
?>