<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Login</title>
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
                <h1>Login</h1>
            </div>
            <div>
                <div class="error">
                    <?php
                    if (isset($_COOKIE['ERRO'])) {
                        echo "<br>" . $_COOKIE['ERRO'];
                        echo "<br>";
                    }
                    ?>
                </div>
                <form method="post" action="setLogin.php">
                    <label for="mail">Email</label>
                    <input id="mail" name="mail" type="email" placeholder="Ex.: Fulano@email.com" required />

                    <label for="pass">Senha</label>
                    <input id="pass" name="pass" type="password" required />

                    <input type="submit" value="LOGIN" />
                </form>
                Não possui conta? <a href="cadastro.php">Clique aqui</a> e cadastre-se.
            </div>
        </div>
    </div>
</body>