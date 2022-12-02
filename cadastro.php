<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Cadastro</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles.css" />
    <link rel="icon" type="imagem/png" href="https://cdn.icon-icons.com/icons2/1153/PNG/512/1486564172-finance-loan-money_81492.png" />
</head>

</html>

<body>
    <div class="login-content">
        <div class="center-content">
            <div class="login-nav">
                <img alt="logo usuario" src="https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png" />
                <h1>Cadastro</h1>
            </div>
            <div>
                <div class='error'>
                    <?php
                    if (isset($_SESSION["erro_cadastro"])) {
                        echo "<br>" . $_SESSION["erro_cadastro"];
                        echo "<br>";
                    }
                    ?>
                </div>

                <form method="POST" action="register.php">

                    <label for="name">Nome</label>
                    <input id="name" name="name" type="text" placeholder="Ex.: Fulano" required minlength="3" />

                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" placeholder="Ex.: Fulano@email.com" required />

                    <label for="pass">Senha</label>
                    <input id="pass" name="pass" type="password" required minlength="5" />

                    <label for="repeat-pass">Repita a senha</label>
                    <input id="repeat-pass" name="repeat-pass" type="password" required minlength="5" />

                    <input type="submit" value="CADASTRAR" />
                </form>
                Já tem conta? <a href="login.php">Clique aqui.</a>
            </div>
        </div>
    </div>
</body>