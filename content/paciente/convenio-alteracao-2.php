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
$id_convenio_paciente = $_POST['id_convenio_paciente'];
$NumeroConvenio = $_POST['NumeroConvenio'];
$StatusConvenioPaciente = $_POST['StatusConvenioPaciente'];
$NotaConvenioPaciente = $_POST['NotaConvenioPaciente'];
$NotaConvenioPaciente = str_replace("'","&#39;",$NotaConvenioPaciente);
$NotaConvenioPaciente = str_replace('"',"&#34;",$NotaConvenioPaciente);

// atualizar
if (empty($NumeroConvenio)) {
	$sql = "UPDATE convenio_paciente SET NumeroConvenio = NULL WHERE id_convenio_paciente = '$id_convenio_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	$sql = "UPDATE convenio_paciente SET NumeroConvenio = '$NumeroConvenio' WHERE id_convenio_paciente = '$id_convenio_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (empty($NotaConvenioPaciente)) {
	$sql = "UPDATE convenio_paciente SET NotaConvenioPaciente = NULL WHERE id_convenio_paciente = '$id_convenio_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	$sql = "UPDATE convenio_paciente SET NotaConvenioPaciente = '$NotaConvenioPaciente' WHERE id_convenio_paciente = '$id_convenio_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

$sql = "UPDATE convenio_paciente SET StatusConvenioPaciente = '$StatusConvenioPaciente' WHERE id_convenio_paciente = '$id_convenio_paciente' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: convenio.php?id_paciente=$id_paciente");
exit;
?>
