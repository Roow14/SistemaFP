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
if (empty($_POST['PesquisaPaciente'])) {
	unset($_SESSION['PesquisaPaciente']);
} else {
	$_SESSION['PesquisaPaciente'] = $_POST['PesquisaPaciente'];
}

// voltar
header("Location: index.php");
exit;
?>