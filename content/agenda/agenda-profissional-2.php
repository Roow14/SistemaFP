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
if (isset($_POST['id_profissionalX'])) {
	$id_profissional = $_POST['id_profissionalX'];
	$_SESSION['id_profissional'] = $id_profissional;
} else {

}

if (empty($_POST['id_periodoX'])) {
	unset($_SESSION['id_periodo']);
} else {
	$id_periodo = $_POST['id_periodoX'];
	$_SESSION['id_periodo'] = $id_periodo;
}

if (empty($_POST['id_unidadeX'])) {
	unset($_SESSION['id_unidade']);
} else {
	$id_unidade = $_POST['id_unidadeX'];
	$_SESSION['id_unidade'] = $id_unidade;
}

// voltar
header("Location: agenda-profissional.php?id_profissional=$id_profissional");
exit;
?>
