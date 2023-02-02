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
$id_diagnostico_paciente = $_GET['id_diagnostico_paciente'];
$id_diagnostico = $_POST['id_diagnostico'];
$DataDiagnostico = $_POST['DataDiagnostico'];
$NotaDiagnostico = $_POST['NotaDiagnostico'];


// atualizar
$sql = "UPDATE diagnostico_paciente SET id_diagnostico = '$id_diagnostico', DataDiagnostico = '$DataDiagnostico' WHERE id_diagnostico_paciente = '$id_diagnostico_paciente' ";
if ($conn->query($sql) === TRUE) {
} else {
}

if (empty($_POST['NotaDiagnostico'])) {

} else {
	// atualizar
	$sql = "UPDATE diagnostico_paciente SET NotaDiagnostico = '$NotaDiagnostico' WHERE id_diagnostico_paciente = '$id_diagnostico_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}	
}

// voltar
header("Location: diagnostico-paciente.php?id_paciente=$id_paciente");
exit;
?>