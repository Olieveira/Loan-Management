<?php

class items
{
    // cria um novo item
    public function criarItem($item, $contato, $devolucao, $id_conta)
    {
        include_once "conection.php"; // inicia a conexão com o banco de dados

        $sql = "INSERT INTO itens (ITEM, NOME, DEVOLUCAO, ID_CONTA)
         VALUES ('" . $item . "','" . $contato . "','" . $devolucao . "','" . $id_conta . "')"; // query para cadastrar o user
        $result = mysqli_query($con, $sql); // executa a query

        // verifica se deu erro
        if (!$result) {
            return false;
        } else {
            return true;
        };

        mysqli_close($con); // encerra a conexão com o banco de dados
    }

    // consulta todos os itens
    public function consultarItens($id_conta)
    {
        include_once "conection.php"; // inicia a conexão com o banco de dados
        $query = "SELECT * FROM itens WHERE ID_CONTA=" . $id_conta;
        $result = mysqli_query($con, $query);

        if ($result->num_rows > 0) { // verifica se o email esta cadastrado
            $dataArray = mysqli_fetch_all($result); // converte o resultado em um array associativo
            return $dataArray;
        } else {
            return [];
        }
        mysqli_close($con); // encerra a conexão com o banco de dados
    }
}
