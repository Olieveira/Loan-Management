<?php
session_start();

function return_erro(string $erro)
{
    setcookie('ERRO', $erro, time() + 1);
    $url = "http://localhost/lended/login.php";
    echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=$url'>
    ";
}

function verifyAccount($mail, $pass)
{
    include 'conection.php'; // arquivo que estabelece a conexão

    $sql = "SELECT ID, nome, email, senha from users WHERE email='" . $mail . "'";
    $result = mysqli_query($con, $sql);

    if ($result->num_rows > 0) { // verifica se o email esta cadastrado
        $dataArray = mysqli_fetch_assoc($result); // converte o resultado em um array associativo

        if ($pass == $dataArray['senha']) { // verifica se a senha está correta
            $_SESSION['id'] =  $dataArray['ID'];
            $_SESSION['name'] = $dataArray['nome'];
            $_SESSION['mail'] = $dataArray['email'];
            header("Location: coisasEmprestadas.php"); // redireciona para a pagina inicial
        } else {
            return_erro("Email ou Senha incorreta!");
        }
    } else {
        return_erro("Usuário não encontrado!");
    };

    mysqli_close($con); // encerra a conexão com o banco de dados
}

if (!isset($_POST["mail"]) || empty($_POST)) {
    header('Location: login.html');
    exit;
} else {
    verifyAccount($_POST['mail'], md5($_POST['pass']));
}
