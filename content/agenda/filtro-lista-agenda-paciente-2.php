<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
$id_paciente = $_SESSION['id_paciente'];
$DataInicial = $_POST['DataInicial'];
$DataFinal = $_POST['DataFinal'];
$id_categoria = $_POST['id_categoria'];
$id_convenio = $_POST['id_convenio'];

if (!empty($_POST['DataInicial'])) {
	$_SESSION['DataInicial'] = $DataInicial;
} else {
	unset($_SESSION['DataInicial']);
}
if (!empty($_POST['DataFinal'])) {
	$_SESSION['DataFinal'] = $DataFinal;
} else {
	unset($_SESSION['DataFinal']);
}
if (!empty($_POST['id_categoria'])) {
	$_SESSION['id_categoria'] = $id_categoria;
} else {
	unset($_SESSION['id_categoria']);
}
if (!empty($_POST['id_convenio'])) {
	$_SESSION['id_convenio'] = $id_convenio;
} else {
	unset($_SESSION['id_convenio']);
}

// voltar
header("Location: lista-agenda-paciente.php");
exit;
?>
