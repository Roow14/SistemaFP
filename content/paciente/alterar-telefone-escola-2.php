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
$id_telefone_escola = $_GET['id_telefone_escola'];
$Tipo = $_POST['Tipo'];
$Telefone = $_POST['Telefone'];
$NotaTel = $_POST['NotaTel'];

if (empty($_POST['Telefone'])) {
} else {
	// atualizar
	$sql = "UPDATE telefone_escola SET NumeroTel = '$Telefone' WHERE id_telefone_escola = '$id_telefone_escola' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}
echo $sql.'<br>';

if (empty($_POST['Tipo'])) {
} else {
	// atualizar
	$sql = "UPDATE telefone_escola SET Tipo = '$Tipo' WHERE id_telefone_escola = '$id_telefone_escola' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['NotaTel'])) {
} else {
	// atualizar
	$sql = "UPDATE telefone_escola SET NotaTel = '$NotaTel' WHERE id_telefone_escola = '$id_telefone_escola' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: cadastrar-telefone-email-escola.php?id_escola=$id_escola");
exit;
?>
