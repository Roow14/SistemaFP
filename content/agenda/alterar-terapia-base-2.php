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
$id_agenda_paciente_base = $_GET['id_agenda_paciente_base'];
$id_profissional = $_POST['id_profissionalX'];

if (!empty($id_profissional)) {
	// atualizar
	$sql = "UPDATE agenda_paciente_base SET id_profissional = '$id_profissional' WHERE id_agenda_paciente_base = '$id_agenda_paciente_base' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}

	// voltar
	header("Location: relatorio-agenda-base-paciente.php");
	exit;
}
	
// voltar
header("Location: alterar-agenda-terapia-base.php?id_agenda_paciente_base=$id_agenda_paciente_base");
exit;
?>
