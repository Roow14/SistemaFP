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
$DataSessao = $_GET['DataSessao'];
$id_periodo = $_GET['id_periodo'];
$id_categoria = $_GET['id_categoria'];
$id_unidade = $_GET['id_unidade'];


// voltar
header("Location: agendar-sessao.php?id_paciente=$id_paciente&id_categoria=$id_categoria&id_periodo=$id_periodo&id_unidade=$id_unidade&id_sessao_paciente=$id_sessao_paciente");
exit;
?>
