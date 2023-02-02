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
$id_paciente = $_POST['id_paciente'];
$id_convenio_paciente = $_POST['id_convenio_paciente'];
$NotaConvenio = $_POST['NotaConvenio'];
$NumeroConvenio = $_POST['NumeroConvenio'];
$StatusConvenio = $_POST['StatusConvenio'];
// $Ordem = $_POST['Ordem'];


$sql = "UPDATE convenio_paciente SET StatusConvenio = '$StatusConvenio' WHERE id_convenio_paciente = '$id_convenio_paciente' ";
if ($conn->query($sql) === TRUE) {
} else {
}

if (empty($NotaConvenio)) {
	// atualizar
	$sql = "UPDATE convenio_paciente SET NotaConvenio = NULL WHERE id_convenio_paciente = '$id_convenio_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE convenio_paciente SET NotaConvenio = '$NotaConvenio' WHERE id_convenio_paciente = '$id_convenio_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($NumeroConvenio)) {
	// atualizar
	$sql = "UPDATE convenio_paciente SET NumeroConvenio = NULL WHERE id_convenio_paciente = '$id_convenio_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE convenio_paciente SET NumeroConvenio = '$NumeroConvenio' WHERE id_convenio_paciente = '$id_convenio_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: alterar-convenio-paciente.php?id_paciente=$id_paciente&id_convenio_paciente=$id_convenio_paciente");
exit;
?>
