<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}
    
include "../conexao/conexao.php";

// input
$Page = $_GET['Page'];
$PageOffset = $_GET['PageOffset'];
$Soma = $_GET['Soma'];
$ItensPorPagina = $_GET['ItensPorPagina']; 

if ($Page == 3) {
	unset($_SESSION['PageOffset']);

	if (!empty($_GET['Origem'])) {
	$Origem = $_GET['Origem'];
		// voltar
		header("Location: $Origem");
	} else {
		// voltar
		header("Location: index.php");
	}
}

if ($Page == 1) {
	$Minimo = $PageOffset - $ItensPorPagina;
	if ($Minimo < 0) {
		unset($_SESSION['PageOffset']);
	} else {
		$_SESSION['PageOffset'] = $PageOffset - $ItensPorPagina;
	}
} else {
	$Maximo = $PageOffset + $ItensPorPagina;
	if ($Maximo > $Soma) {
	} else {
		$_SESSION['PageOffset'] = $PageOffset + $ItensPorPagina;
	}
}

if (!empty($_GET['Origem'])) {
	$Origem = $_GET['Origem'];
	// voltar
	header("Location: $Origem");
} else {
	// voltar
	header("Location: index.php");
}
exit;
?>