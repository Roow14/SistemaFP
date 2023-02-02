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
$id_periodo = $_GET['id_periodo'];
$id_unidade = $_GET['id_unidade'];

// voltar
header("Location: agenda-base-profissional.php?id_profissional=$id_profissional&id_periodo=$id_periodo&id_unidade=$id_unidade");
exit;
?>
