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
$Status = $_POST['Status'];

if (empty($Status)) {
	unset($_SESSION['Status']);
} else {
	$_SESSION['Status'] = $Status;
}

// voltar
header("Location: relatorio-agenda-do-dia.php");
exit;
?>
