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
$id_profissional = $_GET['id_profissional'];

if ($_SESSION['AtivarAdicaoProfissional']) {
	unset($_SESSION['AtivarAdicaoProfissional']);
} else {
	$_SESSION['AtivarAdicaoProfissional'] = 'sim';
}

// voltar
header("Location: categoria-profissional.php?id_profissional=$id_profissional");
exit;
