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
$id_escola = $_GET['id_escola'];

if ($_SESSION['AtivarRemocaoEscola']) {
	unset($_SESSION['AtivarRemocaoEscola']);
} else {
	$_SESSION['AtivarRemocaoEscola'] = 'sim';
}

// voltar
header("Location: escola.php?id_escola=$id_escola");
exit;
