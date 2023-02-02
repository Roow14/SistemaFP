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
$Origem = $_GET['Origem'];
$ObsTerapiaSolicitada = $_POST['ObsTerapiaSolicitada'];
$ObsTerapiaRealizada = $_POST['ObsTerapiaRealizada'];

if (empty($_POST['ObsTerapiaSolicitada'])) {

} else {
	// buscar xxx
	$sql = "SELECT * FROM terapia_observacao WHERE id_paciente = 'id_paciente' AND ObsTerapiaSolicitada = '$ObsTerapiaSolicitada'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// atualizar
			$sqlA = "UPDATE terapia_observacao SET ObsTerapiaSolicitada = '$ObsTerapiaSolicitada' WHERE id_paciente = '$id_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
	    }
	} else {
		// inserir
		$sqlA = "INSERT INTO terapia_observacao (ObsTerapiaSolicitada, id_paciente) VALUES ('$ObsTerapiaSolicitada', '$id_paciente')";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
}
	
if (empty($_POST['ObsTerapiaRealizada'])) {

} else {
	// buscar xxx
	$sql = "SELECT * FROM terapia_observacao WHERE id_paciente = 'id_paciente' AND ObsTerapiaRealizada = '$ObsTerapiaRealizada'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// atualizar
			$sqlA = "UPDATE terapia_observacao SET ObsTerapiaRealizada = '$ObsTerapiaRealizada' WHERE id_paciente = '$id_paciente' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
	    }
	} else {
		// inserir
		$sqlA = "INSERT INTO terapia_observacao (ObsTerapiaRealizada, id_paciente) VALUES ('$ObsTerapiaRealizada', '$id_paciente')";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
}

// voltar
header("Location: $Origem?id_paciente=$id_paciente");
exit;
?>
