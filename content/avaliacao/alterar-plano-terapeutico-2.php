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
$id_avaliacao = $_GET['id_avaliacao'];
$PlanoTerapeutico = $_POST['PlanoTerapeutico'];

if (!empty($PlanoTerapeutico)) {
	// atualizar
	$sql = "UPDATE avaliacao SET PlanoTerapeutico = '$PlanoTerapeutico' WHERE id_avaliacao = '$id_avaliacao' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE avaliacao SET PlanoTerapeutico = NULL WHERE id_avaliacao = '$id_avaliacao' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: alterar-avaliacao.php?id_paciente=$id_paciente&id_avaliacao=$id_avaliacao");
exit;
?>