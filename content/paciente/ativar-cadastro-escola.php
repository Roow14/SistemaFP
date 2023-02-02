<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

if ($_SESSION['AtivarCadastroEscola']) {
	unset($_SESSION['AtivarCadastroEscola']);
} else {
	$_SESSION['AtivarCadastroEscola'] = 'sim';
}

// voltar
header("Location: listar-escolas.php");
exit;
