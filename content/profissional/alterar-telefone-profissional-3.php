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
$id_profissional = $_GET['id_profissional'];
$id_telefone_profissional = $_GET['id_telefone_profissional'];
$ClasseTel = 1;
$NumeroTel = $_POST['NumeroTel'];
$Tipo = $_POST['Tipo'];
$NotaTel = $_POST['NotaTel'];

if (empty($_POST['NumeroTel'])) {
} else {
	// atualizar
	$sql = "UPDATE telefone_profissional SET NumeroTel = '$NumeroTel' WHERE id_telefone_profissional = '$id_telefone_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Tipo'])) {
} else {
	// atualizar
	$sql = "UPDATE telefone_profissional SET Tipo = '$Tipo' WHERE id_telefone_profissional = '$id_telefone_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['NotaTel'])) {
} else {
	// atualizar
	$sql = "UPDATE telefone_profissional SET NotaTel = '$NotaTel' WHERE id_telefone_profissional = '$id_telefone_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: profissional.php?id_profissional=$id_profissional");
exit;
?>
