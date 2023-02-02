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
if (isset($_GET['id_profissional'])) {
	$id_profissional = $_GET['id_profissional'];
} elseif (isset($_POST['id_profissional'])) {
	$id_profissional = $_POST['id_profissional'];
}
$_SESSION['id_profissional'] = $id_profissional;

// voltar
header("Location: agenda-base-profissional.php");
exit;
?>
