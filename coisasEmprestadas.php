<?php
session_start();

// verifica se tem uma sessão aberta
if (!isset($_SESSION["mail"]) || empty($_SESSION)) {
    header('Location: login.php');
} else {
    $id = $_SESSION['id'];
    $nome = $_SESSION['name'];
    $email = $_SESSION['mail'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Loan Management</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles.css" />
    <link rel="icon" type="imagem/png" href="https://cdn.icon-icons.com/icons2/1153/PNG/512/1486564172-finance-loan-money_81492.png" />
</head>

<body>
    <header>
        <h1 class="tt">Loan Management</h1>
        <div class="profile">
            <?php echo "<div class='userName'>$nome#$id</div>" ?>
            <a href="logout.php">
                <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" d="M2 13H14V11H2V13Z" fill="black" fill-rule="evenodd" />
                    <path clip-rule="evenodd" d="M4.79282 7.79289L1.29282 11.2929C0.902294 11.6834 0.902294 12.3166 1.29282 12.7071L4.79282 16.2071L6.20703 14.7929L3.41414 12L6.20703 9.20711L4.79282 7.79289Z" fill="black" fill-rule="evenodd" />
                    <path clip-rule="evenodd" d="M14.5954 5.5C12.1159 5.5 9.95745 6.93099 8.89246 9.03855L7.10742 8.13653C8.49483 5.39092 11.3226 3.5 14.5954 3.5C19.2491 3.5 22.9999 7.31769 22.9999 12C22.9999 16.6823 19.2491 20.5 14.5954 20.5C11.3226 20.5 8.49483 18.6091 7.10742 15.8635L8.89246 14.9615C9.95745 17.069 12.1159 18.5 14.5954 18.5C18.1205 18.5 20.9999 15.602 20.9999 12C20.9999 8.39803 18.1205 5.5 14.5954 5.5Z" fill="black" fill-rule="evenodd" />
                </svg>
            </a>
        </div>
    </header>
    <section class="corpo">
        <div class="itens">
            <table>
                <thead>
                    <tr>
                        <th class="tt-table" colspan="6">ITENS EMPRESTADOS</th>
                    </tr>
                    <?php
                    if (isset($_COOKIE['msg_cadastro'])) {
                        echo "<p style='color: #1d8320'>" . $_COOKIE['msg_cadastro'] . "</p>";
                    };
                    if (isset($_COOKIE['msg_exclusao'])) {
                        echo $_COOKIE['msg_exclusao'];
                    }
                    ?>
                    <tr class="tt-columns">
                        <th>ID</th>
                        <th>ITEM</th>
                        <th>EMPRÉSTIMO</th>
                        <th>CONTATO</th>
                        <th>DEVOLUÇÃO</th>
                        <th>EDITAR</th>
                    </tr>
                </thead>
                <tbody class="itens-table">
                    <form method="POST" action='chamaFuncao.php'>
                        <?php

                        // verifica se houve alguma busca
                        if (isset($_COOKIE['buscou'])) {
                            $array_itens = [];
                            $jsonToArray = [];

                            foreach (json_decode($_COOKIE['buscou']) as $item) {
                                array_push($array_itens, $item);
                            }

                            if (sizeof($array_itens) <= 0) {
                                echo "Nenhum item encontrado!";
                            }
                        } else {
                            require_once('manipula_itens.php');
                            $itens = new itens();
                            $array_itens = $itens->consultar($_SESSION['id']);
                        }

                        // se retornou algum resultado e não foi de busca
                        if (sizeof($array_itens) > 0) {
                            for ($index = count($array_itens) - 1; $index >= 0; $index--) { // iteração inversa no array dos itens

                                // variaveis de controle de data
                                $data_emprestimo = $array_itens[$index][2];
                                $data_prevista = $array_itens[$index][4];
                                $hoje = date('Y-m-d');

                                if (strtotime($data_prevista) > strtotime($hoje)) {
                        ?>
                                    <tr class="pendente">
                                    <?php
                                } else {
                                    ?>
                                    <tr class="devolvido">
                                    <?php
                                }
                                    ?>

                                    <td><?php echo $array_itens[$index][0] ?></td>
                                    <td><?php echo $array_itens[$index][1] ?></td>
                                    <td><?php echo $array_itens[$index][2] ?></td>
                                    <td><?php echo $array_itens[$index][3] ?></td>
                                    <td><?php echo $array_itens[$index][4] ?></td>
                                    <td><input type="radio" name="edit" value="<?php echo $array_itens[$index][0] ?>"></td>
                                    </tr>
                            <?php
                            };
                        } else {
                            !isset($_COOKIE['buscou']) ? "Nenhum item cadastrado!" : null;
                        }
                            ?>
                            <tr>
                                <td colspan="6"><?php
                                                if (isset($_COOKIE['msgEdicao'])) {
                                                    echo $_COOKIE['msgEdicao'];
                                                };
                                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1"></td>
                                <td colspan="1">
                                    <!-- campo de texto de edição do item -->
                                    <input type="text" name="editItem" required placeholder="ex.: caneta">
                                </td>
                                <td colspan="1">
                                    <!-- campo de texto de edição do emprestimo -->
                                    <input type="date" name="editEmprestimo" required placeholder="ex.: 2010-10-10">
                                </td>
                                <td colspan="1">
                                    <!-- campo de texto de edição do contato -->
                                    <input type="text" name="editContato" required placeholder="ex.: João">
                                </td>
                                <td colspan="1">
                                    <!-- campo de texto da devolução -->
                                    <input type="date" name="editDevolucao" required placeholder="ex.: 2010-10-10">
                                </td>
                                <td colspan="1">
                                    <!-- botao de edição -->
                                    <input class="btnEdit" value="Editar" type="submit" name="editar">
                                </td>
                            </tr>
                    </form>
                </tbody>
                <tfoot>
                    <tr>
                        <!-- form que chama funcao de busca -->
                        <form method="GET" action="chamaFuncao.php">
                            <td colspan="1"></td>
                            <td colspan="1">
                                <!-- input texto -->
                                <input placeholder="Item, ID ou Contato" type="search" required name="search">
                            </td>
                            <td colspan="1">
                                <!-- botao de busca -->
                                <input class="btnBuscar" value="Buscar" type="submit" name="buscar">
                            </td>
                        </form>
                        <form method="POST" action="chamaFuncao.php">
                            <td colspan="2">
                                <input type="number" min="0" placeholder="ID do Item" required name="del_item">
                            </td>
                            <td colspan="1">
                                <input class="btnExcluir" type="submit" value="Excluir">
                            </td>
                        </form>
                    </tr>
                    <tr>
                        <!-- form que chama funcao de cadastro -->
                        <form method="POST" action="chamaFuncao.php">
                            <td colspan="2">
                                <!-- campo de texto do item -->
                                <label for="item">Item</label>
                                <input type="text" name="item" required placeholder="ex.: caneta">
                            </td>
                            <td colspan="1">
                                <!-- campo de texto do contato -->
                                <label for="contato">Contato</label>
                                <input type="text" name="contato" required placeholder="ex.: João">
                            </td>
                            <td colspan="2">
                                <!-- campo de texto da devolução -->
                                <label for="devolucao">Devolução</label>
                                <input type="date" name="devolucao" required placeholder="ex.: 10/10/2010">
                            </td>
                            <td colspan="1">
                                <!-- botao de cadastro -->
                                <input class="btnCadastro" value="Cadastrar" type="submit" name="cadastrar">
                            </td>
                        </form>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
</body>

</html>