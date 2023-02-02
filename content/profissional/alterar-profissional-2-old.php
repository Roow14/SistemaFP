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
$id_profissional = $_GET['id_profissional'];
$NomeCurto = $_POST['NomeCurto'];
$NomeCompleto = $_POST['NomeCompleto'];
$id_funcao = $_POST['id_funcao'];
$Senha = $_POST['Senha'];

// atualizar
$sql = "UPDATE profissional SET NomeCompleto = '$NomeCompleto' WHERE id_profissional = '$id_profissional' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// atualizar
$sql = "UPDATE profissional SET NomeCurto = '$NomeCurto' WHERE id_profissional = '$id_profissional' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// atualizar
$sql = "UPDATE profissional SET id_funcao = '$id_funcao' WHERE id_profissional = '$id_profissional' ";
if ($conn->query($sql) === TRUE) {
} else {
}

if (empty($_POST['Senha'])) {
	// atualizar
	$sql = "UPDATE profissional SET Senha = NULL WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// inserir
	$sql = "INSERT INTO profissional (Senha, id_profissional) VALUES ('$Senha', '$id_profissional')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: profissional.php?id_profissional=$id_profissional");
exit;
?>