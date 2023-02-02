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
if (empty($_POST['id_categoriaX'])) {
	unset($_SESSION['id_categoria']);
} else {
	$_SESSION['id_categoria'] = $_POST['id_categoriaX'];
}

if (empty($_POST['PesquisaProfissional'])) {
	unset($_SESSION['PesquisaProfissional']);
} else {
	$_SESSION['PesquisaProfissional'] = $_POST['PesquisaProfissional'];
}

if (empty($_POST['id_periodo'])) {
	unset($_SESSION['id_periodo']);
} else {
	$_SESSION['id_periodo'] = $_POST['id_periodo'];
}

if (empty($_POST['id_unidade'])) {
	unset($_SESSION['id_unidade']);
} else {
	$_SESSION['id_unidade'] = $_POST['id_unidade'];
}

// voltar
header("Location: agenda.php");
exit;
?>
