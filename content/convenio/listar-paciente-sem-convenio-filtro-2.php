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
$PesquisaPaciente = $_POST['PesquisaPaciente'];
$Status = $_POST['Status'];
$id_unidade = $_POST['id_unidade'];

if (empty($PesquisaPaciente)) {
	unset($_SESSION['PesquisaPaciente']);
} else {
	$_SESSION['PesquisaPaciente'] = $PesquisaPaciente;
}

if (empty($Status)) {
	unset($_SESSION['Status']);
} else {
	$_SESSION['Status'] = $Status;
}

if (empty($id_unidade)) {
	unset($_SESSION['id_unidade']);
} else {
	$_SESSION['id_unidade'] = $id_unidade;
}

// voltar
header("Location: listar-paciente-sem-convenio.php");
exit;
?>
