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

    public function __construct(string $usuario, string $entidade_banco, string $valor_anterior, string $valor_novo)
    {
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

    public static function cadastrar(mysqli $link, Log $log)
    {
        $usuario = Log::formatar($log->usuario);
        $entidade_banco = Log::formatar($log->entidade_banco);
        $valor_anterior = Log::formatar($log->valor_anterior);
        $valor_novo = Log::formatar($log->valor_novo);

        if ((Log::validar($usuario)) and (Log::validar($entidade_banco)) and (Log::validar($valor_anterior)) and (Log::validar($valor_novo)))
        {
            mysqli_query($link, "insert into logs_alteracoes(data_hora, usuario, entidade_banco, valor_anterior, valor_novo) 
            values(now(), '$usuario', '$entidade_banco', '$valor_anterior', '$valor_novo');");
        }
        if (mysqli_error($link)>0)
                {
                    header('location:../categoria/visualizarCategorias.php?resultado=' . mysqli_error($link));
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
        $sql = mysqli_query($link, "select * from logs_alteracoes where usuario like '%$pesquisa%';");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }
}
?>