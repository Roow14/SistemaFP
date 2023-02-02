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
// $id_pedido_medico = $_GET['id_pedido_medico'];
// $id_categoria = $_GET['id_categoria'];
// $_SESSION['DataSessao'] = $_POST['DataSessao'];
// $_SESSION['id_categoria'] = $_POST['id_categoria'];
$_SESSION['id_unidade'] = $_POST['id_unidade'];

if (empty($_POST['id_periodo'])) {
	unset($_SESSION['id_periodo']);
} else {
	$_SESSION['id_periodo'] = $_POST['id_periodo'];
}

// voltar
header("Location: agendar-sessao.php?id_paciente=$id_paciente");
exit;
?>
