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
$id_paciente = $_GET['id_paciente'];
$id_observacao = $_GET['id_observacao'];
$Observacao = $_POST['Observacao'];


// atualizar
if (empty($_POST['Observacao'])) {
	// apagar
	$sql = "DELETE FROM diagnostico_observacao WHERE id_paciente = '$id_paciente'";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
	echo '<br>';
} else {
	// atualizar
	$sql = "UPDATE diagnostico_observacao SET Observacao = '$Observacao' WHERE id_observacao = '$id_observacao' ";
	if ($conn->query($sql) === TRUE) {
		echo 'conteúdo atualizado com sucesso ';
	} else {
		echo 'erro na atualização do texto '.$sql;
	}
	echo '<br>';
}

// voltar
header("Location: diagnostico-paciente.php?id_paciente=$id_paciente");
exit;
?>