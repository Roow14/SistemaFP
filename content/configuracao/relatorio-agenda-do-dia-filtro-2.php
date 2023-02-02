<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

$DataAgenda = $_POST['DataAgenda'];
$PesquisaPaciente = $_POST['PesquisaPaciente'];
$PesquisaTerapeuta = $_POST['PesquisaTerapeuta'];
$id_unidade = $_POST['id_unidade'];
$id_hora = $_POST['id_hora'];

if (empty($DataAgenda)) {
	unset($_SESSION['DataAgenda']);
} else {
	$_SESSION['DataAgenda'] = $DataAgenda;
}

if (empty($PesquisaPaciente)) {
	unset($_SESSION['PesquisaPaciente']);
} else {
	$_SESSION['PesquisaPaciente'] = $PesquisaPaciente;
}

if (empty($PesquisaTerapeuta)) {
	unset($_SESSION['PesquisaTerapeuta']);
} else {
	$_SESSION['PesquisaTerapeuta'] = $PesquisaTerapeuta;
}

if (empty($id_unidade)) {
	unset($_SESSION['id_unidade']);
} else {
	$_SESSION['id_unidade'] = $id_unidade;
}

if (empty($id_hora)) {
	unset($_SESSION['id_hora']);
} else {
	$_SESSION['id_hora'] = $id_hora;
}

// voltar
header("Location: relatorio-agenda-do-dia.php");
exit;
?>