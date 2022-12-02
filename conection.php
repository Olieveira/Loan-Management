<?php
$host = 'localhost';
$username = 'root';
$password = '';

$con = mysqli_connect($host, $username, $password);
if (!$con)
    exit('Não foi possível estabelecer conexão com o bando de dados!');

$db_selected = mysqli_select_db($con, 'lended'); // seleciona a base de dados

if (!$db_selected) // verifica se foi selecionado com sucesso
    exit("Não foi possível conectar a base de dados: " . mysqli_error($con));
