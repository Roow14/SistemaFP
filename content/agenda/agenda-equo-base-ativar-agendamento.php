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

if (empty($_SESSION['AtivarAgendamentoEquo'])) {
	$_SESSION['AtivarAgendamentoEquo'] = 'Sim';
	unset($_SESSION['AtivarRemocaoProfissionalEquo']);
} else {
	unset($_SESSION['AtivarAgendamentoEquo']);
}

// voltar
header("Location: agenda-equo-base-paciente.php");
exit;
?>
