<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

date_default_timezone_set("America/Sao_Paulo");
$DataAtualX = date("d/m/Y");
$DataAtual = date("Y-m-d");

// conexão com banco
include '../conexao/conexao.php';

// input
$id_unidade = $_POST['id_unidade'];
$_SESSION['id_unidade'] = $id_unidade;

$DiaSemana = $_POST['DiaSemana'];

$_SESSION['DiaSemana'] = $DiaSemana;
$id_categoria = $_POST['id_categoria'];
$_SESSION['id_categoria'] = $id_categoria;

if (!empty($_POST['id_hora'])) {
	$id_hora = $_POST['id_hora'];
	$_SESSION['id_hora'] = $id_hora;
} else {
	unset($_SESSION['id_hora']);
}

// fechar
header("Location: terapeutas-disponiveis-base.php");
exit;
?>