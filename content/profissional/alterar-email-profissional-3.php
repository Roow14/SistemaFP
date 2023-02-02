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
$id_email_profissional = $_GET['id_email_profissional'];
$EmailProfissional = $_POST['EmailProfissional'];
$NotaEmail = $_POST['NotaEmail'];

if (empty($_POST['EmailProfissional'])) {
} else {
	// atualizar
	$sql = "UPDATE email_profissional SET EmailProfissional = '$EmailProfissional' WHERE id_email_profissional = '$id_email_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['NotaEmail'])) {
} else {
	// atualizar
	$sql = "UPDATE email_profissional SET NotaEmail = '$NotaEmail' WHERE id_email_profissional = '$id_email_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: profissional.php?id_profissional=$id_profissional");
exit;
?>
