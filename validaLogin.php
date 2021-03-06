<?php
session_start();
include_once("conexao.php");
$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);

if ($btnLogin) { //se o botão for acionado...
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    if ((!empty($email)) and (!empty($senha))) {
        //************* QUERY de pesquisa de usuário *****************
        $result_usuario = "SELECT id, nome, email, senha from cad_cuidador where email = '$email' LIMIT 1";
        $resultado = mysqli_query($conn, $result_usuario);
        //echo password_hash($senha, PASSWORD_DEFAULT);

        if ($resultado) { //se for TRUE
            $row_usuario = mysqli_fetch_assoc($resultado);

            if (password_verify($senha, $row_usuario['senha'])) { //lê-se: SE A SENHA DIGITADA FOR IGUAL A DO BANCO, FAÇA...
                $_SESSION['id'] = $row_usuario['id'];
                $_SESSION['nome'] = $row_usuario['nome'];
                $_SESSION['email'] =  $row_usuario['email'];
                header("Location: perfilPro.php");
            } else {
                $_SESSION['msg'] = "<p style='color: red'>A senha informada não é a correta.</p><br>";
                header("Location: loginPro.php");
            }

        } else {
            $_SESSION['msg'] = "<p style='color: red'>Login ou senha incorretos.</p><br>"; //cria a variavel global 
            header("Location: loginPro.php");
        }
        
    //******* TRATAMENTO DE ERROS

    } else if ((empty($email)) and (!empty($senha))) {
        $_SESSION['msg'] = "<p style='color: red'>Preencha o campo de e-mail.</p><br>"; //cria a variavel global 
        header("Location: loginPro.php");

    } else if ((!empty($email)) and (empty($senha))) {
        $_SESSION['msg'] = "<p style='color: red'>Preencha o campo de senha.</p><br>"; //cria a variavel global 
        header("Location: loginPro.php");
    } else if ((empty($email)) and (empty($senha))) {
        $_SESSION['msg'] = "<p style='color: red'>Preencha os campos de login e senha.</p><br>"; //cria a variavel global 
        header("Location: loginPro.php");
    }

} else { //caso não...
    $_SESSION['msg'] = "Página não encontrada."; //cria a variavel global 
    header("Location: loginPro.php");
}
