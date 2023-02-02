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
$EmailPaciente = $_POST['EmailPaciente'];
$NotaEmail = $_POST['NotaEmail'];
$id_email_paciente = $_GET['id_email_paciente'];

// atualizar
$sql = "UPDATE email_paciente SET EmailPaciente = '$EmailPaciente' WHERE id_email_paciente = '$id_email_paciente' ";
if ($conn->query($sql) === TRUE) {
} else {
}

if (empty($_POST['NotaEmail'])) {
	// atualizar
	$sql = "UPDATE email_paciente SET NotaEmail = NULL WHERE id_email_paciente = '$id_email_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE email_paciente SET NotaEmail = '$NotaEmail' WHERE id_email_paciente = '$id_email_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: alterar-email-novo.php?id_email_paciente=$id_email_paciente");
exit;
?>
