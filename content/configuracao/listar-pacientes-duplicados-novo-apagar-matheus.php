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

// limpar filtro por nome
if (empty($_GET['Limpar'])) {
} else {
	unset($_SESSION['NomePaciente']);
}

// pesquisar por nome
if (isset($_POST['NomePaciente'])) {
	$NomePaciente = $_POST['NomePaciente'];
	$_SESSION['NomePaciente'] = $NomePaciente;
	$FiltroNomePaciente = 'WHERE NomeCompleto LIKE "%'.$NomePaciente.'%"';
} elseif (isset($_SESSION['NomePaciente'])) {
	$NomePaciente = $_SESSION['NomePaciente'];
	$FiltroNomePaciente = 'WHERE NomeCompleto LIKE "%'.$NomePaciente.'%"';
} else {
	$NomePaciente = NULL;
	$FiltroNomePaciente = NULL;
	unset($_SESSION['NomePaciente']);
}

// apagar
$sql = "DELETE FROM paciente WHERE NomeCompleto LIKE '%matheus santos%' AND id_paciente != 666";
if ($conn->query($sql) === TRUE) {
} else {
}

header("Location: listar-pacientes-duplicados-novo.php"); exit;
?>