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

// verificar se o convênio está associado ao cliente
$sql = "SELECT * FROM convenio_paciente WHERE id_paciente = '$id_paciente' AND id_convenio = '$id_convenio'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
}
} else {
	// não tem
	$sqlA = "INSERT INTO convenio_paciente (id_paciente, id_convenio) VALUES ('$id_paciente', '$id_convenio')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}
// não está, associar


// voltar
header("Location: convenio.php?id_paciente=$id_paciente");
exit;
?>
