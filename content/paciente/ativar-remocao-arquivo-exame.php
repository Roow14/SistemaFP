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
$id_paciente = $_GET['id_paciente'];
$id_pedido_medico = $_GET['id_pedido_medico'];

if (empty($_SESSION['ApagarArquivoExame'])) {
	$_SESSION['ApagarArquivoExame'] = 'sim';
} else {
	unset($_SESSION['ApagarArquivoExame']);
}

// voltar
header("Location: pedido-medico.php?id_paciente=$id_paciente&id_pedido_medico=$id_pedido_medico");
exit;
