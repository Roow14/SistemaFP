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
$PesquisaPaciente = $_POST['PesquisaPaciente'];
$id_convenio = $_POST['id_convenio'];
$StatusConvenio = $_POST['StatusConvenio'];

if (empty($PesquisaPaciente)) {
	unset($_SESSION['PesquisaPaciente']);
} else {
	$_SESSION['PesquisaPaciente'] = $PesquisaPaciente;
}

if (empty($id_convenio)) {
	unset($_SESSION['id_convenio']);
} else {
	$_SESSION['id_convenio'] = $id_convenio;
}

if (empty($StatusConvenio)) {
	unset($_SESSION['StatusConvenio']);
} else {
	$_SESSION['StatusConvenio'] = $StatusConvenio;
}

// voltar
header("Location: listar-convenio-paciente.php");
exit;
?>
