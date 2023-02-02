<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
$DataAgenda = $_POST['DataAgenda'];
$PesquisaPaciente = $_POST['PesquisaPaciente'];
$id_convenio = $_POST['id_convenio'];
$id_categoria = $_POST['id_categoria'];
$Presenca = $_POST['Presenca'];
$id_hora = $_POST['id_hora'];

if (empty($Presenca)) {
	unset($_SESSION['Presenca']);
} else {
	$_SESSION['Presenca'] = $Presenca;
}

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

if (empty($id_categoria)) {
	unset($_SESSION['id_categoria']);
} else {
	$_SESSION['id_categoria'] = $id_categoria;
}

if (empty($id_convenio)) {
	unset($_SESSION['id_convenio']);
} else {
	$_SESSION['id_convenio'] = $id_convenio;
}

if (empty($id_hora)) {
	unset($_SESSION['id_hora']);
} else {
	$_SESSION['id_hora'] = $id_hora;
}

// limpar a paginação e voltar para a primeira página
unset($_SESSION['PageOffset']);

// voltar
header("Location: index.php");
exit;
?>
