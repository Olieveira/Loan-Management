<?php
session_start();
require_once('manipula_itens.php');

function chamaExclusao()
{
    // variaveis
    $id_item = $_POST['del_item'];

    unset($_POST['del_item']); // exlcui a variavel global


    $excluir = new itens();
    $resultado = $excluir->excluir($id_item, $_SESSION['id']);

    if ($resultado == 1) { // se a exclusão deu certo
        setcookie("msg_exclusao", "Item excluido com sucesso!", time() + 1); // cookie de mensagem
        header('Location: coisasEmprestadas.php');
    } else if ($resultado == 0) {
        setcookie("msg_exclusao", "Falha ao tentar excluir item!", time() + 1); // cookie de mensagem
        header('Location: coisasEmprestadas.php');
    } else {
        setcookie("msg_exclusao", "Insira um ID válido!!", time() + 1); // cookie de mensagem
        header('Location: coisasEmprestadas.php');
    }
}

function chamaEdicao()
{
    // variaveis
    $idItem = $_POST['edit'];
    $item = $_POST['editItem'];
    $emprestimo = $_POST['editEmprestimo'];
    $contato = $_POST['editContato'];
    $devolucao = $_POST['editDevolucao'];

    unset($_POST['edit']); // exlcui a variavel global

    $editar = new itens(); // instancia a classe
    $resultado = $editar->editar($idItem, $item, $emprestimo, $contato, $devolucao, $_SESSION['id']); // chama o método de edição da classe

    if ($resultado) { // se deu certo
        setcookie('msgEdicao', "Item $idItem - $item atualizado com sucesso!", time() + 1); // cookie de mensagem
    } else {
        setcookie('msgEdicao', "Item $idItem - $item atualizado com sucesso!", time() + 1); // cookie de mensagem
    }

    header('Location: coisasEmprestadas.php'); // Redireciona para a página principal

}

function chamaBusca()
{
    $busca = $_GET['search']; // pega a string de busca do input texto da pagina
    $item = new itens(); // instancia a classe
    $resultado = $item->buscar($busca, $_SESSION['id']); // chama o método de busca da classe e atribui o resultado na variavel

    unset($_GET['search']); // exlcui a variavel global

    if (sizeof($resultado) > 0) { // se obteve resultado

        // converte o array para JSON e envia o array via cookie
        setcookie("buscou", json_encode($resultado), time() + 1);
        header('Location: coisasEmprestadas.php'); // volta para a pagina principal
    } else {
        setcookie("buscou", json_encode([]), time() + 1);
        header('Location: coisasEmprestadas.php'); // volta para a pagina principal
    }
}

// chama o método de cadastro da classe itens
function chamaCadastro()
{
    // pega as variaveis
    $item = $_POST['item'];
    $emprestimo = date('Y-m-d'); // pega a data atual
    $contato = $_POST['contato'];
    $devolucao = $_POST['devolucao'];
    $id_conta = $_SESSION['id'];

    unset($_POST['cadastrar']); // exlcui a variavel global

    $classe = new itens(); // instancia a classe dos itens
    $resultado = $classe->criar($item, $emprestimo, $contato, $devolucao, $id_conta); // cria os itens pelo método da classe

    if ($resultado) {
        setcookie("msg_cadastro", "Item cadastrado com sucesso!", time() + 1); // define um cookie
        header("Location: coisasEmprestadas.php"); // redireciona para a pagina inicial
    } else {
        setcookie("msg_cadastro", "Erro ao tentar cadastrar item!", time() + 1); // define um cookie
        header("Location: coisasEmprestadas.php"); // redireciona para a pagina inicial
    }
};

if (isset($_POST['cadastrar'])) {

    chamaCadastro(); // chama o método de cadastro da classe itens

} else if (isset($_GET['search'])) {

    chamaBusca(); // chama o método de cadastro da classe itens

} else if (isset($_POST['edit'])) {

    chamaEdicao(); // chama o método de edição da classe itens

} else if (isset($_POST['del_item'])) {

    chamaExclusao(); // chama o método de exclusao da classe itens

}
