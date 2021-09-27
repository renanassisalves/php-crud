<?php
require "Banco.php";

if(isset($_POST['cadastrar']))
{
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $lucro_liquido = $_POST['lucro_liquido'];
    $id_categoria = $_POST['id_categoria'];
    $produto = new Produto($nome, $preco, $quantidade, $lucro_liquido, $id_categoria);
    $produto->cadastrar($link);
}

if(isset($_POST['alterar']))
{
    $id = $_POST['id'];
    header('location:../produto/alterarProduto.php?id=' . $id);   
}

if(isset($_POST['alterarconfirma']))
{
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $lucro_liquido = $_POST['lucro_liquido'];
    $id_categoria = $_POST['id_categoria'];

    Produto::alterar($link, $id, $nome, $preco, $quantidade, $lucro_liquido, $id_categoria);
}

if(isset($_POST['excluir']))
{
    $id = $_POST['id'];
    Produto::excluir($link, $id);
}

if(isset($_POST['pesquisar']))
{
    $pesquisa = $_POST['pesquisarSearch'];
    header('location:../produto/visualizarProdutos.php?pesquisa=' . $pesquisa);
}

if(isset($_POST['pesquisarSelecionar']))
{
    $pesquisa = $_POST['pesquisarSearch'];
    header('location:../produto/selecionarProdutos.php?pesquisa=' . $pesquisa);
}

if(isset($_POST['selecionarcategoriaproduto']))
{
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $lucro_liquido = $_POST['lucro_liquido'];
   header('location:../categoria/selecionarCategoria.php?nome_produto='.$nome.'&preco_produto='.$preco.'&quantidade_produto='.$quantidade.'&lucro_liquido_produto='.$lucro_liquido);
}

if(isset($_POST['adicionar']))
{
    $id_novo = $_POST['id_novo'];
    $lista_id = $_POST['lista_id'];
    if(isset($_POST['lista_id']))
    {
        $lista_id= $lista_id.','.$id_novo;
    }
    else
    {
        $lista_id = $id_novo;
    }

    header('location:../produto/selecionarProdutos.php?lista_id='.$lista_id);
}

class Produto
{
    private $id;
    private $nome;
    private $preco;
    private $quantidade;
    private $lucro_liquido;
    private $id_categoria;
    private $inativado;

    public function __construct(string $nome, float $preco, int $quantidade, float $lucro_liquido, int $id_categoria)
    {
        $this->nome = $nome;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
        $this->lucro_liquido = $lucro_liquido;
        $this->id_categoria = $id_categoria;
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
        $preco = $this::formatar($this->preco);
        $preco = str_replace(",", ".", $preco);
        $quantidade = $this::formatar($this->quantidade);
        $lucro_liquido = $this::formatar($this->lucro_liquido);
        $id_categoria = $this::formatar($this->id_categoria);


        if ($this::validar($nome) and $this::validar($preco) and $this::validar($quantidade) and $this::validar($lucro_liquido) and $this::validar($id_categoria))
        {
            mysqli_query($link, "insert into produto(nome, preco, quantidade, lucro_liquido, id_categoria, inativado)
            values('$nome', $preco, $quantidade, $lucro_liquido, $id_categoria, false);");
            
            
            if (mysqli_error($link)>0)
            {
                header('location:../produto/cadastrarProduto.php?resultado=' . mysqli_error($link));
            } else
            {
                header('location:../produto/cadastrarProduto.php?resultado=sucesso');
            }
        }
        else
        {
            header('location:../produto/cadastrarProduto.php?resultado=Verifique todos os campos!');
        }

        
    }

    public static function alterar(mysqli $link, $id, $novoNome, $novoPreco, $novaQuantidade, $novoLucroLiquido, $novaCategoria)
    {
        $nome = Produto::formatar($novoNome);
        $preco = Produto::formatar($novoPreco);
        $quantidade = Produto::formatar($novaQuantidade);
        $lucro_liquido = Produto::formatar($novoLucroLiquido);
        $id_categoria = Produto::formatar($novaCategoria);


        if (Produto::validar($nome) and Produto::validar($preco) and Produto::validar($quantidade) and Produto::validar($lucro_liquido) and Produto::validar($id_categoria))
        {
            mysqli_query($link, 'update produto set nome = "'. $novoNome . '", preco = '.$novoPreco.', quantidade='.$novaQuantidade.', lucro_liquido='.$novoLucroLiquido.', id_categoria='.$novaCategoria.' where id = ' . $id . ';');
            
            
            if (mysqli_error($link)>0)
            {
                header('location:../produto/visualizarProdutos.php?resultado=' . mysqli_error($link));
            } else
            {
                header('location:../produto/visualizarProdutos.php?resultado=alteradosucesso');
            }
        }
        else
        {
            header('location:../produto/cadastrarProduto.php?id='.$id.'&?resultado=Verifique todos os campos!');
        }
        
    }

    public static function excluir(mysqli $link, int $id)
    {
        mysqli_query($link, "delete from produto where id=" . $id . ";" );
        if (mysqli_error($link)>0)
            {
                header('location:../produto/visualizarProdutos.php?resultado=' . mysqli_error($link));
            } else
            {
                header('location:../produto/visualizarProdutos.php?resultado=excluidosucesso');
            }
    }

    public static function pegarProduto(mysqli $link, int $id)
    {
        $sql = mysqli_query($link, "select * from produto where id=$id;");
        $resultado = mysqli_fetch_row($sql);
        return $resultado;
    }

    public static function listarTodos(mysqli $link)
    {
        $sql = mysqli_query($link, "select * from produto;");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }

    public static function listarPesquisa(mysqli $link, $pesquisa)
    {
        $sql = mysqli_query($link, "select * from produto where nome like '%$pesquisa%';");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }
}
?>