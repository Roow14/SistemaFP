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
$id_profissional = $_GET['id_profissional'];

// calcular próxima data
$DataProxima = date("Y-m-d", strtotime($DataAgenda.'+7 day'));
$_SESSION['DataAgenda'] = $DataProxima;

// voltar
header("Location: agenda-profissional.php?id_profissional=$id_profissional");
exit;
?>
