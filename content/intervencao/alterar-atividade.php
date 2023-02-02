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
$id_atividade = $_GET['id_atividade'];
$id_atividade_titulo = $_GET['id_atividade_titulo'];
$NomeAtividade = $_POST['NomeAtividade'];
$Ordem = $_POST['Ordem'];

if (empty($_POST['NomeAtividade'])) {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: O nome da atividade está vazia.\");
	    window.location = \"cadastrar-atividade.php\"
	    </script>";
	exit;
} else {
}

// atualizar
$sql = "UPDATE prog_atividade SET NomeAtividade = '$NomeAtividade' WHERE id_atividade = '$id_atividade' ";
if ($conn->query($sql) === TRUE) {
} else {
}

if (empty($_POST['Ordem'])) {
	// atualizar
	$sql = "UPDATE prog_atividade SET Ordem = NULL WHERE id_atividade = '$id_atividade' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE prog_atividade SET Ordem = '$Ordem' WHERE id_atividade = '$id_atividade' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: cadastrar-atividade-1.php?id_atividade_titulo=$id_atividade_titulo");
exit;
?>
