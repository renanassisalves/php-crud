<?php
require "Banco.php";
include_once "Log.php";

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $responsavel = $_POST['responsavel'];
    $tel_responsavel = $_POST['tel_responsavel'];
    $longradouro = $_POST['longradouro'];
    $bairro = $_POST['bairro'];
    $numero = $_POST['numero'];
    $cep = $_POST['cep'];

    if (isset($_POST['origem'])) {
        $origem = $_POST['origem'];
        $origem = str_replace("|||", "&", $origem);
    } else {
        $origem = "0";
    }


    $endereco = new Endereco($longradouro, $bairro, $numero, $cep);
    $endereco->cadastrar($link, $origem);
    $fornecedor = new Fornecedor($nome, $responsavel, $tel_responsavel, $endereco->getId());
    $fornecedor->cadastrar($link, $origem);
}

if (isset($_POST['alterar'])) {
    $id = $_POST['id_fornecedor'];
    header('location:../fornecedor/alterarFornecedor.php?id=' . $id);
}

if (isset($_POST['alterarconfirma'])) {

    $idFornecedor = $_POST['id_fornecedor'];
    $fornecedor = Fornecedor::pegarFornecedor($link, $idFornecedor);
    $idEndereco = $fornecedor[4];

    $nome = $_POST['nome'];
    $responsavel = $_POST['responsavel'];
    $tel_responsavel = $_POST['tel_responsavel'];
    $longradouro = $_POST['longradouro'];
    $bairro = $_POST['bairro'];
    $numero = $_POST['numero'];
    $cep = $_POST['cep'];
    Fornecedor::alterar($link, $idFornecedor, $idEndereco, $nome, $responsavel, $tel_responsavel, $longradouro, $bairro, $numero, $cep);
}

if (isset($_POST['pesquisar'])) {
    $pesquisa = $_POST['pesquisarSearch'];
    if (isset($_POST['origem'])) {
        $origem = $_POST['origem'];
        header('location: ' . $origem . '&pesquisa=' . $pesquisa);
    } else {
        header('location:../fornecedor/visualizarFornecedores.php?pesquisa=' . $pesquisa);
    }
}


if (isset($_POST['excluir'])) {
    $id = $_POST['id_fornecedor'];
    Fornecedor::excluir($link, $id);
}

if (isset($_POST['visualizarEndereco'])) {
    $id = $_POST['id_endereco'];
    header('location:../fornecedor/visualizarEndereco.php?id_endereco=' . $id);
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

    public static function validar(string $campo)
    {

        $validacao = false;

        if (empty($campo)) {
            $validacao = false;
        } else {
            $validacao = true;
        }

        if ($validacao) {
            return true;
        } else {
            return false;
        }
    }

    public static function formatar(string $campo)
    {
        $campo = trim($campo);
        $campo = str_replace("'", "", $campo);
        return $campo;
    }

    public function cadastrar(mysqli $link, string $origem)
    {
        $nome = $this::formatar($this->nome);
        $responsavel = $this::formatar($this->responsavel);
        $tel_responsavel = $this::formatar($this->tel_responsavel);
        $id_endereco = $this::formatar($this->id_endereco);
        $enderecoAtual = Endereco::pegarEndereco($link, $id_endereco);

        if ($origem == "0") {
            if ($this::validar($nome) and $this::validar($responsavel) and $this::validar($tel_responsavel) and $this::validar($id_endereco)) {
                mysqli_query($link, "insert into fornecedor(nome, responsavel, tel_responsavel, id_endereco, inativado)
            values('$nome', '$responsavel', '$tel_responsavel', $id_endereco, false);");

                if (mysqli_error($link) > 0) {
                    header('location:../fornecedor/cadastrarFornecedor.php?resultado=' . mysqli_error($link));
                } else {
                    $log = new log($_SESSION['nome'], "Fornecedor", "Cadastro de novo fornecedor", "Nome: $nome, Respons??vel: $responsavel, Telefone Respons??vel: $tel_responsavel, Longradouro: $enderecoAtual[1], Bairro: $enderecoAtual[2], Numero: $enderecoAtual[3], CEP: $enderecoAtual[4]");
                    Log::cadastrar($link, $log);
                    header('location:../fornecedor/cadastrarFornecedor.php?resultado=sucesso');
                }
            } else {
                header('location:../fornecedor/cadastrarFornecedor.php?resultado=Verifique todos os campos!');
            }
        }
        else
        {
            $linkNovo = $origem;
            $linkNovo = str_replace("&resultado=Verifique%20todos%20os%20campos!", "", $linkNovo);
            $linkNovo = str_replace("&resultado=sucesso", "", $linkNovo);

            if ($this::validar($nome) and $this::validar($responsavel) and $this::validar($tel_responsavel) and $this::validar($id_endereco)) {
                mysqli_query($link, "insert into fornecedor(nome, responsavel, tel_responsavel, id_endereco, inativado)
            values('$nome', '$responsavel', '$tel_responsavel', $id_endereco, false);");

                if (mysqli_error($link) > 0) {
                    header('location: ' . $linkNovo . '&resultado='.mysqli_error($link));
                } else {
                    $log = new log($_SESSION['nome'], "Fornecedor", "Cadastro de novo fornecedor", "Nome: $nome, Respons??vel: $responsavel, Telefone Respons??vel: $tel_responsavel, Longradouro: $enderecoAtual[1], Bairro: $enderecoAtual[2], Numero: $enderecoAtual[3], CEP: $enderecoAtual[4]");
                    Log::cadastrar($link, $log);
                    header('location: ' . $linkNovo . '&resultado=sucesso');
                }
            } else {
                header('location: ' . $linkNovo . '&resultado=Verifique todos os campos!');
            }


        }


    }

    public static function alterar(mysqli $link, $idFornecedor, $idEndereco, $novoNome, $novoResponsavel, $novoTel_Responsavel, $novoLongradouro, $novoBairro, $novoNumero, $novoCep)
    {
        
        $fornecedorAtual = Fornecedor::pegarFornecedor($link, $idFornecedor);
        $enderecoAtual = Endereco::pegarEndereco($link, $fornecedorAtual[4]);
        $novoNome = Fornecedor::formatar($novoNome);
        $novoResponsavel = Fornecedor::formatar($novoResponsavel);
        $novoTel_Responsavel = Fornecedor::formatar($novoTel_Responsavel);
        $novoLongradouro = Fornecedor::formatar($novoLongradouro);
        $novoBairro = Fornecedor::formatar($novoBairro);
        $novoNumero = Fornecedor::formatar($novoNumero);
        $novoCep = Fornecedor::formatar($novoCep);

        if (Fornecedor::validar($novoNome) and Fornecedor::validar($novoResponsavel) and Fornecedor::validar($novoTel_Responsavel)) {
            mysqli_query($link, 'update fornecedor set nome = "' . $novoNome . '", responsavel = "' . $novoResponsavel . '", tel_responsavel = "' . $novoTel_Responsavel . '" where id = ' . $idFornecedor . ';');
            if (mysqli_error($link) > 0) {
                header('location:../fornecedor/visualizarFornecedores.php?resultado=' . mysqli_error($link));
            } else {
                $log = new log($_SESSION['nome'], "Fornecedor", "Nome: $fornecedorAtual[1], Respons??vel: $fornecedorAtual[2], Telefone Respons??vel: $fornecedorAtual[3], Longradouro: $enderecoAtual[1], Bairro: $enderecoAtual[2], Numero: $enderecoAtual[3], CEP: $enderecoAtual[4]", "Nome: $novoNome, Respons??vel: $novoResponsavel, Telefone Respons??vel: $novoTel_Responsavel, Longradouro: $novoLongradouro, Bairro: $novoBairro, Numero: $novoNumero, CEP: $novoCep");
                    Log::cadastrar($link, $log);
                header('location:../fornecedor/visualizarFornecedores.php?resultado=alteradosucesso');
            }
        } else {
            header('location:../fornecedor/alterarFornecedor.php?id=' . $idFornecedor . '?resultado=Verifique todos os campos!');
        }

        if (Fornecedor::validar($novoLongradouro) and Fornecedor::validar($novoBairro) and Fornecedor::validar($novoTel_Responsavel) and Fornecedor::validar($novoCep)) {
            mysqli_query($link, 'update endereco set longradouro = "' . $novoLongradouro . '", bairro = "' . $novoBairro . '", numero = "' . $novoNumero . '", cep = "' . $novoCep . '" where id = ' . $idEndereco . ';');
            if (mysqli_error($link) > 0) {
                header('location:../fornecedor/visualizarFornecedores.php?resultado=' . mysqli_error($link));
            } else {
                header('location:../fornecedor/visualizarFornecedores.php?resultado=alteradosucesso');
            }
        } else {
            header('location:../fornecedor/alterarFornecedor.php?id=' . $idFornecedor . '&resultado=Verifique todos os campos!');
        }
    }

    public static function excluir(mysqli $link, int $id)
    {
        mysqli_query($link, "delete from fornecedor where id=" . $id . ";");
        header('location:../fornecedor/visualizarFornecedor.php');
        $fornecedorAtual = Fornecedor::pegarFornecedor($link, $id);
        $enderecoAtual = Endereco::pegarEndereco($link, $fornecedorAtual[4]);
        if (mysqli_error($link) > 0) {
            header('location:../fornecedor/visualizarFornecedores.php?resultado=' . mysqli_error($link));
        } else {
            $log = new log($_SESSION['nome'], "Fornecedor", "Exclus??o de fornecedor", "Nome: $fornecedorAtual[1], Respons??vel: $fornecedorAtual[2], Telefone Respons??vel: $fornecedorAtual[3], Longradouro: $enderecoAtual[1], Bairro: $enderecoAtual[2], Numero: $enderecoAtual[3], CEP: $enderecoAtual[4]");
                    Log::cadastrar($link, $log);
            header('location:../fornecedor/visualizarFornecedores.php?resultado=excluidosucesso');
        }
    }

    public static function pegarFornecedor(mysqli $link, int $id)
    {
        $sql = mysqli_query($link, "select * from fornecedor where id=$id;");
        $resultado = mysqli_fetch_row($sql);
        return $resultado;
    }

    public static function pegarEnderecoFornecedor(mysqli $link, int $id)
    {
        $sql = mysqli_query($link, "select * from endereco where id=$id;");
        $resultado = mysqli_fetch_row($sql);
        return $resultado;
    }

    public static function listarTodos(mysqli $link)
    {
        $sql = mysqli_query($link, "select * from fornecedor;");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }

    public static function listarPesquisa(mysqli $link, $pesquisa)
    {
        $sql = mysqli_query($link, "select * from fornecedor where nome like '%$pesquisa%';");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }
}

class Endereco
{
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

    public static function validar(string $campo)
    {

        $validacao = false;

        if (empty($campo)) {
            header('location:../categoria/cadastrarFornecedor.php?resultado=Verifique todos os campos!');
            $validacao = false;
        } else {
            $validacao = true;
        }

        if ($validacao) {
            return true;
        } else {
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

        $longradouro = $this::formatar($this->longradouro);
        $bairro = $this::formatar($this->bairro);
        $numero = $this::formatar($this->numero);
        $cep = $this::formatar($this->cep);

        mysqli_query($link, "insert into endereco(longradouro, bairro, numero, inativado, cep)
        values('$longradouro', '$bairro', $numero, false, '$cep');");
        $this->id = mysqli_insert_id($link);

        if (mysqli_error($link) > 0) {
            header('location:../categoria/cadastrarFornecedor.php?resultado=' . mysqli_error($link));
        } else {
            header('location:../categoria/cadastrarFornecedor.php?resultado=sucesso');
        }
    }

    public static function alterar(mysqli $link, $id, $novoLongradouro, $novoBairro, $novoNumero, $novoCep)
    {
        $novoLongradouro = Endereco::formatar($novoLongradouro);
        $novoBairro = Endereco::formatar($novoBairro);
        $novoNumero = Endereco::formatar($novoNumero);
        $novoCep = Endereco::formatar($novoCep);

        mysqli_query($link, 'update endereco set longradouro = "' . $novoLongradouro . '" where id = ' . $id . ';');
        header('location:../categoria/visualizarCategorias.php');
    }

    public static function excluir(mysqli $link, int $id)
    {
        mysqli_query($link, "delete from endereco where id=" . $id . ";");
        header('location:../endereco/visualizarEndereco.php');
    }

    public static function pegarEndereco(mysqli $link, int $id)
    {
        $sql = mysqli_query($link, "select * from endereco where id=$id;");
        $resultado = mysqli_fetch_row($sql);
        return $resultado;
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
