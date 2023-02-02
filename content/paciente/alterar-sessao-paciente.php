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
$id_sessao_paciente = $_GET['id_sessao_paciente'];
$SessaoInicial = $_POST['SessaoInicial'];
$HorasInicial = $_POST['HorasInicial'];
$id_categoria = $_POST['id_categoria'];
$Status = $_POST['Status'];

if ($_POST['SessaoInicial'] < 0) {
} else {
	// atualizar
	$sql = "UPDATE sessao_paciente SET SessaoInicial = '$SessaoInicial' WHERE id_sessao_paciente = '$id_sessao_paciente' ";
	if ($conn->query($sql) === TRUE) {
		echo $sql;
	} else {
		echo 'erro '.$sql;
	}
}

if ($_POST['HorasInicial'] < 0) {
} else {
	// atualizar
	$sql = "UPDATE sessao_paciente SET HorasInicial = '$HorasInicial' WHERE id_sessao_paciente = '$id_sessao_paciente' ";
	if ($conn->query($sql) === TRUE) {
		echo $sql;
	} else {
		echo 'erro '.$sql;
	}
}

// atualizar
$sql = "UPDATE sessao_paciente SET Status = '$Status' WHERE id_sessao_paciente = '$id_sessao_paciente' ";
if ($conn->query($sql) === TRUE) {
	echo $sql;
} else {
	echo 'erro '.$sql;
}

// voltar
header("Location: listar-sessoes.php?id_paciente=$id_paciente");
exit;
