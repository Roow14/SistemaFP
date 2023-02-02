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
$id_telefone_paciente = $_GET['id_telefone_paciente'];
$ClasseTel = 1;
$NumeroTel = $_POST['NumeroTel'];
$Tipo = $_POST['Tipo'];
$NotaTel = $_POST['NotaTel'];

if (empty($_POST['NumeroTel'])) {
} else {
	// atualizar
	$sql = "UPDATE telefone_paciente SET NumeroTel = '$NumeroTel' WHERE id_telefone_paciente = '$id_telefone_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Tipo'])) {
} else {
	// atualizar
	$sql = "UPDATE telefone_paciente SET Tipo = '$Tipo' WHERE id_telefone_paciente = '$id_telefone_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['NotaTel'])) {
} else {
	// atualizar
	$sql = "UPDATE telefone_paciente SET NotaTel = '$NotaTel' WHERE id_telefone_paciente = '$id_telefone_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: paciente.php?id_paciente=$id_paciente");
exit;
?>
