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

// voltar
header("Location: listar-profissionais-por-categoria.php");
exit;
?>
