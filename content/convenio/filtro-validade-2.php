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
$StatusConvenio = $_POST['StatusConvenio'];

if (empty($StatusConvenio)) {
	unset($_SESSION['StatusConvenio']);
} else {
	$_SESSION['StatusConvenio'] = $StatusConvenio;
}

// voltar
header("Location: index.php");
exit;
?>
