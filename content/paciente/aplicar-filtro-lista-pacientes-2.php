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

if (empty($_POST['StatusPaciente'])) {
	unset($_SESSION['StatusPaciente']);
} else {
	$_SESSION['StatusPaciente'] = $_POST['StatusPaciente'];
}

if (empty($_POST['id_unidade'])) {
	unset($_SESSION['id_unidade']);
} else {
	$_SESSION['id_unidade'] = $_POST['id_unidade'];
}

// remover sessão paginação e voltar para a página inicial 
unset($_SESSION['PageOffset']);

// voltar
header("Location: index.php");
exit;
?>
