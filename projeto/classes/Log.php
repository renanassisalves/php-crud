<?php
require "Banco.php";

// if(isset($_POST['cadastrar']))
// {
//     $nome = $_POST['nome'];
//     date_default_timezone_set('America/Sao_Paulo');
//     $data = date('d/m/Y h:i:s', time());


//     $log = new Log($nome);
//     $log->cadastrar($link);
// }

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
        header('location:../fornecedor/visualizarLogs.php?pesquisa=' . $pesquisa);
    }
}

class Log
{
    private $id;
    private $data_hora;
    private $usuario;
    private $entidade_banco;
    private $valor_anterior;
    private $valor_novo;

    public function __construct(string $data_hora, string $usuario, string $entidade_banco, string $valor_anterior, string $valor_novo)
    {
        $this->data_hora = $data_hora;
        $this->usuario = $usuario;
        $this->entidade_banco = $entidade_banco;
        $this->valor_anterior = $valor_anterior;
        $this->valor_novo = $valor_novo;
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

    public function cadastrar(mysqli $link, Log $log)
    {
        $data_hora = $log->data_hora;
        $usuario = $this::formatar($log->usuario);
        $entidade_banco = $this::formatar($log->entidade_banco);
        $valor_anterior = $this::formatar($log->valor_anterior);
        $valor_novo = $this::formatar($log->valor_novo);

        if (($this::validar($usuario)) and ($this::validar($entidade_banco)) and ($this::validar($valor_anterior)) and ($this::validar($valor_novo)))
        {
            mysqli_query($link, "insert into logs_alteracoes(data_hora, usuario, entidade_banco, valor_anterior, valor_novo) 
            values($data_hora, '$usuario', '$entidade_banco', '$valor_anterior', '$valor_novo');");
        }
    }

    public static function pegarLog(mysqli $link, int $id)
    {
        $sql = mysqli_query($link, "select * from logs_alteracoes where id=$id;");
        $resultado = mysqli_fetch_row($sql);
        return $resultado;
    }

    public static function listarTodos(mysqli $link)
    {
        $sql = mysqli_query($link, "select * from logs_alteracoes;");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }

    public static function listarPesquisa(mysqli $link, $pesquisa)
    {
        $sql = mysqli_query($link, "select * from logs_alteracoes where nome like '%$pesquisa%';");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }
}
?>