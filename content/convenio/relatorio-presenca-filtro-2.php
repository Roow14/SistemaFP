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
$DataAgenda = $_POST['DataAgenda'];
$PesquisaPaciente = $_POST['PesquisaPaciente'];
$id_convenio = $_POST['id_convenio'];
$Presenca = $_POST['Presenca'];

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

if (empty($id_convenio)) {
	unset($_SESSION['id_convenio']);
} else {
	$_SESSION['id_convenio'] = $id_convenio;
}

if (empty($Presenca)) {
	unset($_SESSION['Presenca']);
} else {
	$_SESSION['Presenca'] = $Presenca;
}

// voltar
header("Location: relatorio-presenca.php");
exit;
?>
