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
$Mes = $_POST['Mes'];
if (!empty($Mes)) {
	$_SESSION['Mes'] = $Mes;
} else {
	unset($_SESSION['Mes']);
}

$Presenca = $_POST['Presenca'];
if (!empty($Mes)) {
	$_SESSION['Presenca'] = $Presenca;
} else {
	unset($_SESSION['Presenca']);
}

// voltar
header("Location: relatorio-convenio-paciente.php");
exit;
?>