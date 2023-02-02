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
$id_exame = $_POST['id_exame'];
$DataExame = $_POST['DataExame'];
$id_medico = $_POST['id_medico'];
$Exame = $_POST['Exame'];
$Exame = str_replace("'","&#39;",$Exame);
$Exame = str_replace('"','&#34;',$Exame);
$TituloExame = $_POST['TituloExame'];

// atualizar
if (!empty($TituloExame)) {
	$sql = "UPDATE exame_novo SET TituloExame = '$TituloExame' WHERE id_exame = '$id_exame' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	$sql = "UPDATE exame_novo SET TituloExame = NULL WHERE id_exame = '$id_exame' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// atualizar
$sql = "UPDATE exame_novo SET id_medico = '$id_medico' WHERE id_exame = '$id_exame' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// atualizar
$sql = "UPDATE exame_novo SET DataExame = '$DataExame' WHERE id_exame = '$id_exame' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// atualizar
if (!empty($Exame)) {
	$sql = "UPDATE exame_novo SET Exame = '$Exame' WHERE id_exame = '$id_exame' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	$sql = "UPDATE exame_novo SET Exame = NULL WHERE id_exame = '$id_exame' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: alterar-exame.php?id_exame=$id_exame");
exit;
?>