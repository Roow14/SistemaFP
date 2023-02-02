<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

if (!empty($_SESSION['OrdemData'])) {
	unset($_SESSION['OrdemData']);
} else {
	$_SESSION['OrdemData'] = 1;
}

// voltar
header("Location: lista-agenda-paciente.php");
exit;
?>
