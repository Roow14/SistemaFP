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
if (isset($_GET['id_paciente'])) {
	$id_paciente = $_GET['id_paciente'];
} elseif (isset($_POST['id_paciente'])) {
	$id_paciente = $_POST['id_paciente'];
}
$_SESSION['id_paciente'] = $id_paciente;

// voltar
header("Location: agenda-base-paciente.php");
exit;
?>
