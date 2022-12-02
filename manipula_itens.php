<?php

class itens
{

    public function criar($item, $emprestimo, $contato, $devolucao, $id_conta)
    {
        require_once("conection.php"); // realiza conexão com db

        // query para cadastrar o item
        $sql = "INSERT INTO itens 
        (ITEM, EMPRESTIMO, CONTATO, DEVOLUCAO, ID_CONTA) VALUES 
        ('" . $item . "','" . $emprestimo . "','" . $contato . "','" . $devolucao . "','" . $id_conta . "')";

        $result = mysqli_query($con, $sql); // realiza a consulta
        mysqli_close($con); // encerra a conexão com o banco de dados

        if ($result) { // se foi cadastrado com sucesso
            return 1;
        } else {
            return 0;
        }
    }

    public function consultar($id_conta)
    {
        require_once("conection.php"); // realiza conexão com db

        $sql = "SELECT * FROM itens WHERE ID_CONTA='" . $id_conta . "'"; // query para consultar os itens da conta
        $result = mysqli_query($con, $sql); // realiza a consulta
        mysqli_close($con); // encerra a conexão com o banco de dados

        if ($result->num_rows > 0) { // se retornou resultado
            return mysqli_fetch_all($result); // transforma o retorno da consulta em um array
        } else {
            return [];
        }
    }

    public function excluir($id_item, $id_conta)
    {
        require_once("conection.php"); // realiza conexão com db

        $query = "SELECT * FROM itens WHERE ID=$id_item AND ID_CONTA=$id_conta";
        $resultado1 = mysqli_query($con, $query);

        if ($resultado1->num_rows > 0) { // se retornou algum resultado

            $sql = "DELETE FROM itens WHERE ID=$id_item AND ID_CONTA=$id_conta";
            $result = mysqli_query($con, $sql); // executa a query
            mysqli_close($con); // encerra a conexão com o banco de dados

            if ($result) { // se foi excluido com sucesso
                return 1;
            } else {
                return 0;
            }
        } else {
            return 2;
        }
    }

    public function buscar($busca, $id_conta)
    {
        require_once("conection.php"); // realiza conexão com db

        $sql = "SELECT * FROM itens WHERE ID_CONTA='$id_conta' and ITEM LIKE '%$busca%' OR CONTATO LIKE '%$busca%' OR ID='$busca'"; // query para consultar os itens da conta
        $result = mysqli_query($con, $sql); // realiza a consulta
        mysqli_close($con); // encerra a conexão com o banco de dados

        if ($result->num_rows > 0) { // se retornou resultado
            return mysqli_fetch_all($result); // transforma o retorno da consulta em um array
        } else {
            return [];
        }
    }

    public function editar($id_item, $n_item, $n_emprestimo, $n_contato, $n_devolucao, $id_conta)
    {
        require_once("conection.php"); // realiza conexão com db

        $sql = "UPDATE itens SET 
        ITEM='$n_item', EMPRESTIMO='$n_emprestimo', CONTATO='$n_contato', DEVOLUCAO='$n_devolucao' WHERE ID=$id_item AND ID_CONTA=$id_conta";

        $result = mysqli_query($con, $sql); // realiza a consulta
        mysqli_close($con); // encerra a conexão com o banco de dados

        if ($result) { // se foi cadastrado com sucesso
            return true;
        } else {
            return false;
        }
    }
}
