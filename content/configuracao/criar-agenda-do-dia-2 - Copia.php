<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';
	
// input múlitplo
foreach ($_POST['id_agenda_paciente'] as $Item => $Valor) {
	$Item++;
	// echo $Item.' > '.$Valor.'<br>';
	
	// atualizar
	$sql = "UPDATE agenda_paciente SET Status = 2 WHERE id_agenda_paciente = '$Valor' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: relatorio-agenda-do-dia.php");
exit;
?>
