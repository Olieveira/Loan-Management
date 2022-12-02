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

function userCadastrado($nome, $email, $pass)
{
    include "conection.php"; // arquivo que estabelece a conexão

    $sql = "SELECT * from users WHERE email='" . $email . "'"; // consulta para verificar se o email já esta cadastrado na base de dados
    $result = mysqli_query($con, $sql); // realiza a consulta

    if ($result->num_rows > 0) { // se obteve algum retorno
        return_erro("Email já cadastrado!");
    } else {
        $sql = "INSERT INTO users (nome, email, senha) VALUES ('" . $nome . "','" . $email . "','" . $pass . "')"; // query para cadastrar o user
        $result = mysqli_query($con, $sql);

        if (!$result) {
            echo "<br>Falha ao cadastrar usuário: " . mysqli_error($con);
        } else {
            $sql = "SELECT ID FROM users WHERE email='" . $email . "'"; // query para consultar o ID do novo usuario
            $result = mysqli_query($con, $sql); // realiza a consulta

            if ($result->num_rows > 0) { // se retornou resultado
                $dataArray = mysqli_fetch_assoc($result); // transforma o retorno da consulta em um array associativo
                $id = $dataArray["ID"];
            }

            // inicia a sessão
            $_SESSION['id'] = $id;
            $_SESSION['name'] = $nome;
            $_SESSION['mail'] = $email;

            header("Location: coisasEmprestadas.php"); // redireciona para a página inicial
        };
    };

    mysqli_close($con);
}

if (!isset($_POST["name"]) || !isset($_POST["email"]) || !isset($_POST["pass"]) || !isset($_POST["repeat-pass"])) {
    header("Location: cadastro.php");
    exit;
};

$nome = $_POST["name"];
$email = $_POST["email"];
$senha = md5($_POST["pass"]);
$confirmacao_senha = md5($_POST["repeat-pass"]);

if ($senha != $confirmacao_senha) {
    return_erro('As senhas devem ser iguais!');
} else {
    userCadastrado($nome, $email, $senha);
};
