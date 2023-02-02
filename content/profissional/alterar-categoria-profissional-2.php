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
$id_categoria_profissional = $_GET['id_categoria_profissional'];
$id_profissional = $_GET['id_profissional'];
$id_categoria = $_POST['id_categoria'];
$id_periodo = $_POST['id_periodo'];
$id_unidade = $_POST['id_unidade'];

if (empty($_POST['id_categoria'])) {
} else {
	// atualizar
	$sql = "UPDATE categoria_profissional SET id_categoria = '$id_categoria' WHERE id_categoria_profissional = '$id_categoria_profissional' ";
	if ($conn->query($sql) === TRUE) {
		echo $sql.'<br>';
	} else {
		echo 'erro: '.$sql.'<br>';
	}
}

if (empty($_POST['id_periodo'])) {
} else {
	// atualizar
	$sql = "UPDATE categoria_profissional SET id_periodo = '$id_periodo' WHERE id_categoria_profissional = '$id_categoria_profissional' ";
	if ($conn->query($sql) === TRUE) {
		echo $sql.'<br>';
	} else {
		echo 'erro: '.$sql.'<br>';
	}
}

if (empty($_POST['id_unidade'])) {
} else {
	// atualizar
	$sql = "UPDATE categoria_profissional SET id_unidade = '$id_unidade' WHERE id_categoria_profissional = '$id_categoria_profissional' ";
	if ($conn->query($sql) === TRUE) {
		echo $sql.'<br>';
	} else {
		echo 'erro: '.$sql.'<br>';
	}
}

// voltar
header("Location: profissional.php?id_profissional=$id_profissional");
exit;
?>
