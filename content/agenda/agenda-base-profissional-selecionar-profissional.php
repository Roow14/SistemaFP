<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
$id_profissional = $_POST['id_profissionalPesq'];

// voltar
header("Location: agenda-base-profissional.php?id_profissional=$id_profissional");
exit;
?>
