<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
if (!empty($_SESSION['RemoverTerapeuta'])) {
	unset($_SESSION['RemoverTerapeuta']);
} else {
	$_SESSION['RemoverTerapeuta'] = 1;
}

// voltar
header("Location: agenda-paciente.php");
exit;
?>
