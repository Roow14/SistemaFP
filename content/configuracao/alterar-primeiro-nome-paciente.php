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
$NomeCompleto = $_POST['NomeCompleto'];
$NomeCurto = $_POST['NomeCurto'];

if (empty($_POST['NomeCompleto'])) {
} else {
	// atualizar
	$sql = "UPDATE paciente SET NomeCompleto = '$NomeCompleto' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['NomeCurto'])) {
} else {
	// atualizar
	$sql = "UPDATE paciente SET NomeCurto = '$NomeCurto' WHERE id_paciente = '$id_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: configurar-primeiro-nome-pacientes.php");
exit;
?>
