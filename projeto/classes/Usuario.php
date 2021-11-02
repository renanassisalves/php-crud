<?php
require "Banco.php";

if(isset($_POST['cadastrar']))
{
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $senhaConfirma = $_POST['senhaConfirma'];
    $senha = md5($senha);
    $senhaConfirma = md5($senhaConfirma);

    
    $nivel_de_acesso = $_POST['nivel_de_acesso'];

    if ($nivel_de_acesso == "administrador") {
        $nivel_de_acesso = 1;
    }
    else if ($nivel_de_acesso == "funcionario")
    {
        $nivel_de_acesso = 0;
    }

    if ($senha == $senhaConfirma)
    {
        $usuario = new Usuario($nome, $login, $senha, $nivel_de_acesso);
        $usuario->cadastrar($link);
    }
    else
    {
        header('location:../usuario/cadastrarUsuario.php?resultado=Verifique se as senhas são iguais em ambos os campos!');
    }
}

if(isset($_POST['alterar']))
{
    $id = $_POST['id'];
    header('location:../usuario/alterarUsuario.php?id=' . $id);   
}

if(isset($_POST['alterarconfirma']))
{
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $senhaConfirma = $_POST['senhaConfirma'];
    $senha = md5($senha);
    $senhaConfirma = md5($senhaConfirma);
    $nivel_de_acesso = $_POST['nivel_de_acesso'];

    if ($nivel_de_acesso == "administrador") {
        $nivel_de_acesso = 2;
    }
    else if ($nivel_de_acesso == "funcionario")
    {
        $nivel_de_acesso = 1;
    }

    if ($senha == $senhaConfirma)
    {
        Usuario::alterar($link, $id, $nome, $login, $senha, $nivel_de_acesso);
        $usuario->cadastrar($link);
    }
    else
    {
        header('location:../usuario/alterarUsuario.php?resultado=Verifique se as senhas são iguais em ambos os campos!');
    }
}

if(isset($_POST['excluir']))
{
    $id = $_POST['id'];
    Usuario::excluir($link, $id);
}

if(isset($_POST['pesquisar']))
{
    $pesquisa = $_POST['pesquisarSearch'];
    header('location:../usuario/visualizarUsuarios.php?pesquisa=' . $pesquisa);
}

if(isset($_POST['entrar']))
{
    session_start();

    $login = $_POST['login'];
    $senha = md5($_POST['senha']);
    
    $busca = mysqli_query($link, 'SELECT * FROM usuario 
    WHERE login = "'.$login.'" AND senha = "'.$senha.'";');
    $resultado = mysqli_fetch_row($busca);

    if(mysqli_num_rows ($busca) > 0 )
    {
        $_SESSION['nome'] = $resultado[1];
        $_SESSION['login'] = $resultado[2];
        $_SESSION['senha'] = $resultado[3];
        $_SESSION['nivel_de_acesso'] = $resultado[4];
        
        header('location:../inicio.php');
    }
    else{
        unset ($_SESSION['nome']);
        unset ($_SESSION['login']);
        unset ($_SESSION['senha']);
        unset ($_SESSION['nivel_de_acesso']);
        header('location:../index.php');
    }

}

if(isset($_GET['deslogar']))
{
    unset ($_SESSION['nome']);
    unset ($_SESSION['login']);
    unset ($_SESSION['senha']);
    unset ($_SESSION['nivel_de_acesso']);
    header('location:../index.php');


}

class Usuario
{
    private $id;
    private $nome;
    private $login;
    private $senha;
    private $nivel_de_acesso;
    private $inativado;

    public function __construct(string $nome, $login, $senha, $nivel_de_acesso)
    {
        $this->nome = $nome;
        $this->login = $login;
        $this->senha = $senha;
        $this->nivel_de_acesso = $nivel_de_acesso;
        $this->inativado = false;
    }

    public static function validar(string $campo)
    {
       
        $validacao = false;

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

    public function cadastrar(mysqli $link)
    {
        $nome = $this::formatar($this->nome);
        $login = $this::formatar($this->login);
        $senha = $this::formatar($this->senha);
        $nivel_de_acesso = $this::formatar($this->nivel_de_acesso);
        if ($this::validar($nome) and $this::validar($login) and $this::validar($senha) and $this::validar($nivel_de_acesso))
        {
            mysqli_query($link, "insert into usuario(nome, login, senha, nivel_de_acesso, inativado)
            values('$nome', '$login', '$senha', $nivel_de_acesso, false)");
    
            if (mysqli_error($link)>0)
            {
                header('location:../usuario/cadastrarUsuario.php?resultado=' . mysqli_error($link));
            } else
            {
                header('location:../usuario/cadastrarUsuario.php?resultado=sucesso');
            }
        }
        else
        {
            header('location:../usuario/cadastrarUsuario.php?resultado=Verifique todos os campos!');
        }
    }

    public static function alterar(mysqli $link, $id, $novoNome, $novoLogin, $novaSenha, $novoNivelDeAcesso)
    {
        $novoNome = Usuario::formatar($novoNome);
        $novoLogin = Usuario::formatar($novoLogin);
        $novaSenha = Usuario::formatar($novaSenha);
        $novoNivelDeAcesso = Usuario::formatar($novoNivelDeAcesso);
        if(Usuario::validar($novoNome) and (Usuario::validar($novoLogin) and (Usuario::validar($novaSenha) and Usuario::validar($novoNivelDeAcesso))))
        {
            mysqli_query($link, 'update usuario set nome = "'. $novoNome . '", login = "'.$novoLogin.'", senha="'.$novaSenha.'", nivel_de_acesso="'.$novoNivelDeAcesso.'" where id = ' . $id . ';');
            
            if (mysqli_error($link)>0)
                {
                    header('location:../usuario/visualizarUsuarios.php?resultado=' . mysqli_error($link));
                } else
                {
                    header('location:../usuario/visualizarUsuarios.php?resultado=alteradosucesso');
                }
        }
        else
        {
            header('location:../usuario/alterarUsuario.php?id='.$id.'&resultado=Verifique todos os campos!');
        }
        
    }

    public static function excluir(mysqli $link, int $id)
    {
        mysqli_query($link, "delete from usuario where id=" . $id . ";" );
        header('location:../usuario/visualizarUsuarios.php');

        if (mysqli_error($link)>0)
            {
                header('location:../usuario/visualizarUsuarios.php?resultado=' . mysqli_error($link));
            } else
            {
                header('location:../usuario/visualizarUsuarios.php?resultado=excluidosucesso');
            }
    }

    public static function pegarusuario(mysqli $link, int $id)
    {
        $sql = mysqli_query($link, "select * from usuario where id=$id;");
        $resultado = mysqli_fetch_row($sql);
        return $resultado;
    }

    public static function listarTodos(mysqli $link)
    {
        $sql = mysqli_query($link, "select * from usuario;");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }

    public static function listarPesquisa(mysqli $link, $pesquisa)
    {
        $sql = mysqli_query($link, "select * from usuario where nome like '%$pesquisa%';");
        $resultado = mysqli_fetch_all($sql);
        return $resultado;
    }
}
?>