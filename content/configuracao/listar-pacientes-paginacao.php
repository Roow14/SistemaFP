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
$Origem = $_GET['Origem'];

if ($Page == 3) {
	unset($_SESSION['PageOffset']);
	// fechar e voltar
	header("Location: $Origem");
	exit;
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
// fechar e voltar
header("Location: $Origem");
exit;
?>