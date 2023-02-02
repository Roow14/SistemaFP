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
$id_diagnostico = $_GET['id_diagnostico'];
$Cid = $_POST['Cid'];
$NomeDiagnostico = $_POST['NomeDiagnostico'];

if (empty($_GET['Origem'])) {
} else {
	$Origem = $_GET['Origem'];
}

if (empty($_GET['id_paciente'])) {
} else {
	$id_paciente = $_GET['id_paciente'];
}

// atualizar
$sql = "UPDATE diagnostico SET Cid = '$Cid', NomeDiagnostico = '$NomeDiagnostico' WHERE id_diagnostico = '$id_diagnostico' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
if (empty($_GET['Origem'])) {
	header("Location: configurar-diagnostico.php");
} else {
	$Origem = $_GET['Origem'];
	header("Location: configurar-diagnostico.php?Origem=$Origem&id_paciente=$id_paciente");
}
exit;
?>
