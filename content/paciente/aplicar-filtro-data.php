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
$id_paciente = $_GET['id_paciente'];
$_SESSION['DataAgenda'] = $_POST['DataAgenda'];

// voltar
header("Location: agendar-sessao.php?id_paciente=$id_paciente");
exit;
?>
