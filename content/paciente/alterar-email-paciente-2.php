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
$id_email_paciente = $_GET['id_email_paciente'];
$EmailPaciente = $_POST['EmailPaciente'];
$NotaEmail = $_POST['NotaEmail'];

if (empty($_POST['NotaEmail'])) {
} else {
	// atualizar
	$sql = "UPDATE email_paciente SET NotaEmail = '$NotaEmail' WHERE id_email_paciente = '$id_email_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}
echo $sql.'<br>';

if (empty($_POST['EmailPaciente'])) {
} else {
	// atualizar
	$sql = "UPDATE email_paciente SET EmailPaciente = '$EmailPaciente' WHERE id_email_paciente = '$id_email_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: cadastrar-alterar-telefone-email-paciente.php?id_paciente=$id_paciente");
exit;
?>
