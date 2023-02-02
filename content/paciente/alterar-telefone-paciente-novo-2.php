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
$id_paciente = $_SESSION['id_paciente'];
$NumeroTel = $_POST['NumeroTel'];
$NumeroTel = $_POST['NumeroTel'];
$NotaTel = $_POST['NotaTel'];
$ClasseTel = $_POST['ClasseTel'];
$id_telefone_paciente = $_GET['id_telefone_paciente'];

// atualizar
$sql = "UPDATE telefone_paciente SET NumeroTel = '$NumeroTel' WHERE id_telefone_paciente = '$id_telefone_paciente' ";
if ($conn->query($sql) === TRUE) {
} else {
}

if (empty($_POST['NotaTel'])) {
	// atualizar
	$sql = "UPDATE telefone_paciente SET NotaTel = NULL WHERE id_telefone_paciente = '$id_telefone_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE telefone_paciente SET NotaTel = '$NotaTel' WHERE id_telefone_paciente = '$id_telefone_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: alterar-telefone-novo.php?id_telefone_paciente=$id_telefone_paciente");
exit;
?>
