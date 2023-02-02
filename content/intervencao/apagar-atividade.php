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

// apagar
$sqlA = "DELETE FROM prog_atividade WHERE id_atividade = '$id_atividade'";
if ($conn->query($sqlA) === TRUE) {
	echo 'Objetivo apagado';
} else {
	echo 'O atividade não foi apagado.';
}

// voltar
header("Location: cadastrar-atividade-1.php?id_atividade_titulo=$id_atividade_titulo");
exit;
?>
