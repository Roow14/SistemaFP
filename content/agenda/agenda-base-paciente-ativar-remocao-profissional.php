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

if (empty($_SESSION['AtivarAlteracaoAtendimento'])) {
	$_SESSION['AtivarAlteracaoAtendimento'] = 'Sim';
} else {
	unset($_SESSION['AtivarAlteracaoAtendimento']);
}

// voltar
header("Location: agenda-base-paciente.php");
exit;
?>
