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
$id_terapia = $_GET['id_terapia'];
$Origem = $_GET['Origem'];
$NomeTerapia = $_POST['NomeTerapia'];

// atualizar
$sql = "UPDATE terapia SET NomeTerapia = '$NomeTerapia' WHERE id_terapia = '$id_terapia' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
if (empty($_GET['Origem'])) {
	header("Location: configurar-terapia.php");
} else {
	$Origem = $_GET['Origem'];
	header("Location: configurar-terapia.php?Origem=$Origem");
}
exit;
?>
