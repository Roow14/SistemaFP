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
unset($_SESSION['id_categoria']);
unset($_SESSION['id_unidade']);
unset($_SESSION['id_hora']);
unset($_SESSION['id_periodo']);

// voltar
header("Location: agenda-paciente.php");
exit;
?>
