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
if (isset($_POST['id_pacienteX'])) {
	$id_paciente = $_POST['id_pacienteX'];
	$_SESSION['id_paciente'] = $id_paciente;
	// voltar
	header("Location: agenda-paciente.php?id_paciente=$id_paciente");
	exit;

} else {

}

if ((isset($_POST['id_categoriaX'])) AND (isset($_POST['id_unidadeX']))) {
	$id_paciente = $_SESSION['id_paciente'];
	$id_categoria = $_POST['id_categoriaX'];
	$_SESSION['id_categoria'] = $id_categoria;
	$id_unidade = $_POST['id_unidadeX'];
	$_SESSION['id_unidade'] = $id_unidade;
	// voltar
	header("Location: agenda-paciente.php?id_paciente=$id_paciente&id_categoria=$id_categoria");
	exit;

} else {
	
}

?>