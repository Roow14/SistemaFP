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
$DataAgenda = $_GET['DataAgenda'];
$id_paciente = $_GET['id_paciente'];
$id_categoria = $_GET['id_categoria'];

$id_profissional = $_GET['id_profissional'];
$id_periodo = $_GET['id_periodo'];
$id_unidade = $_GET['id_unidade'];

// calcular próxima data
$DataProxima = date("Y-m-d", strtotime($DataAgenda.'-7 day'));
$_SESSION['DataAgenda'] = $DataProxima;

// voltar
if (isset($_GET['id_paciente'])) {
	header("Location: agenda-paciente.php?id_paciente=$id_paciente&id_categoria=$id_categoria");
} elseif (isset($_GET['id_profissional'])) {
	header("Location: agenda-profissional.php?id_profissional=$id_profissional&id_periodo=$id_periodo&id_unidade=$id_unidade");
} else {

}
exit;
?>
