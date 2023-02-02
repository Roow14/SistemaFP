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
$id_diagnostico = $_GET['id_diagnostico'];

// buscar xxx
$sql = "SELECT * FROM diagnostico_paciente WHERE id_diagnostico = '$id_diagnostico'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_diagnostico_paciente = $row['id_diagnostico_paciente'];
		// apagar
		$sqlA = "DELETE FROM diagnostico_paciente WHERE id_diagnostico_paciente = '$id_diagnostico_paciente' ";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
	// inserir
	$sqlA = "INSERT INTO diagnostico_paciente (id_diagnostico, id_paciente) VALUES ('$id_diagnostico', '$id_paciente')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// voltar
header("Location: diagnostico-paciente.php?id_paciente=$id_paciente");
exit;
