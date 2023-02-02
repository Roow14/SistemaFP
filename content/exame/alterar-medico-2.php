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
$id_exame = $_POST['id_exame'];
$id_medico = $_POST['id_medico'];
$Anotacao = $_POST['Anotacao'];
$Anotacao = str_replace("'","&#39;",$Anotacao);
$Anotacao = str_replace('"','&#34;',$Anotacao);
$Crm = $_POST['Crm'];
$NomeMedico = $_POST['NomeMedico'];

// atualizar
if (!empty($Crm)) {
	$sql = "UPDATE medico SET Crm = '$Crm' WHERE id_medico = '$id_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (!empty($NomeMedico)) {
	$sql = "UPDATE medico SET NomeMedico = '$NomeMedico' WHERE id_medico = '$id_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
if (!empty($Anotacao)) {
	$sql = "UPDATE medico SET Anotacao = '$Anotacao' WHERE id_medico = '$id_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	$sql = "UPDATE medico SET Anotacao = '$Anotacao' WHERE id_medico = '$id_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: medico.php?id_medico=$id_medico&id_exame=$id_exame");
exit;
?>