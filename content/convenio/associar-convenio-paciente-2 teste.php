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
$id_convenio = $_POST['id_convenio'];

// verificar se o convenio está associado ao paciente
$sql = "SELECT * FROM convenio_paciente WHERE id_paciente = '$id_paciente' AND id_convenio = '$id_convenio'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		// atualizar
		$sqlA = "UPDATE convenio_paciente SET id_convenio = '$id_convenio' WHERE id_paciente = '$id_paciente' ";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
	// não tem
	// inserir
	$sqlA = "INSERT INTO convenio_paciente (id_convenio, id_paciente) VALUES ('$id_convenio', '$id_paciente')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// voltar
header("Location: convenio-paciente.php?id_paciente=$id_paciente");
exit;
?>
