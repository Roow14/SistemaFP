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
$id_exame = $_GET['id_exame'];
$Origem = $_GET['Origem'];
$NomeExame = $_POST['NomeExame'];

// atualizar
$sql = "UPDATE exame SET NomeExame = '$NomeExame' WHERE id_exame = '$id_exame' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
if (empty($_GET['Origem'])) {
	header("Location: configurar-exame.php");
} else {
	$Origem = $_GET['Origem'];
	header("Location: configurar-exame.php?Origem=$Origem");
}
exit;
?>
