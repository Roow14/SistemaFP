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

if (empty($_SESSION['AtivarRemocaoProfissionalEquo'])) {
	$_SESSION['AtivarRemocaoProfissionalEquo'] = 'Sim';
	unset($_SESSION['AtivarAgendamentoEquo']);
} else {
	unset($_SESSION['AtivarRemocaoProfissionalEquo']);
}

// voltar
header("Location: agenda-equo-base-paciente.php");
exit;
?>
