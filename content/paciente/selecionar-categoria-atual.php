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
$id_categoria = $_GET['id_categoria'];

// buscar xxx
$sql = "SELECT * FROM categoria_paciente WHERE id_categoria = '$id_categoria'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_categoria_paciente = $row['id_categoria_paciente'];
		// apagar
		$sqlA = "DELETE FROM categoria_paciente WHERE id_categoria_paciente = '$id_categoria_paciente' ";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
	// inserir
	$sqlA = "INSERT INTO categoria_paciente (id_categoria, id_paciente) VALUES ('$id_categoria', '$id_paciente')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// voltar
header("Location: categoria-paciente.php?id_paciente=$id_paciente");
exit;
