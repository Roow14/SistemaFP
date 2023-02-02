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
if (empty($_GET['Origem'])) {
} else {
	$Origem = $_GET['Origem'];
}

if (empty($_GET['id_paciente'])) {
} else {
	$id_paciente = $_GET['id_paciente'];
}

unset($_SESSION['ErroApagarDiagnostico']);
unset($_SESSION['ErroAdicionarDiagnostico']);
unset($_SESSION['ErroApagarExameo']);
unset($_SESSION['ErroAdicionarExame']);

// voltar
if (empty($_GET['Origem'])) {
	header("Location: configurar-diagnostico.php");
} else {
	$Origem = $_GET['Origem'];
	header("Location: configurar-diagnostico.php?Origem=$Origem&id_paciente=$id_paciente");
}
// exit;
?>
