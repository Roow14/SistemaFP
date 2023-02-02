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
$id_escola = $_GET['id_escola'];
$id_email_escola = $_GET['id_email_escola'];
$EmailEscola = $_POST['EmailEscola'];
$NotaEmail = $_POST['NotaEmail'];

if (empty($_POST['NotaEmail'])) {
	// atualizar
	$sql = "UPDATE email_escola SET NotaEmail = NULL WHERE id_email_escola = '$id_email_escola' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE email_escola SET NotaEmail = '$NotaEmail' WHERE id_email_escola = '$id_email_escola' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}
echo $sql.'<br>';

if (empty($_POST['EmailEscola'])) {

} else {
	// atualizar
	$sql = "UPDATE email_escola SET EmailEscola = '$EmailEscola' WHERE id_email_escola = '$id_email_escola' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: cadastrar-telefone-email-escola.php?id_escola=$id_escola");
exit;
?>
