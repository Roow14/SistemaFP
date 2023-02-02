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
$id_periodo = $_GET['id_periodo'];
$id_unidade = $_GET['id_unidade'];
$id_categoria = $_GET['id_categoria'];

if (empty($_SESSION['AtivarAlteracaoAtendimento'])) {
	$_SESSION['AtivarAlteracaoAtendimento'] = 'Sim';
} else {
	unset($_SESSION['AtivarAlteracaoAtendimento']);
}

// voltar
header("Location: cadastrar-atendimento.php?id_paciente=$id_paciente&id_periodo=$id_periodo&id_unidade=$id_unidade&id_categoria=$id_categoria");
exit;
?>
