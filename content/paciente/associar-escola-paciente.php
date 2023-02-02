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
$id_escola = $_POST['id_escola'];

if (empty($_POST['id_escola'])) {
	// voltar
	header("Location: escola-paciente.php?id_paciente=$id_paciente");
	exit;
} else {
	
}

// verificar
$sql = "SELECT * FROM escola_paciente WHERE id_escola = '$id_escola' AND id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	// tem
    }
} else {
	// não tem
	// inserir
	$sqlA = "INSERT INTO escola_paciente (id_escola, id_paciente) VALUES ('$id_escola', '$id_paciente')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// voltar
header("Location: escola-paciente.php?id_paciente=$id_paciente");
exit;
