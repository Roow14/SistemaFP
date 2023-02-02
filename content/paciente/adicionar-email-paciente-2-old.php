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
$EmailPaciente = $_POST['EmailPaciente'];
$NotaEmail = $_POST['NotaEmail'];

if (empty($_POST['EmailPaciente'])) {
} else {
	// inserir
	$sql = "INSERT INTO email_paciente (id_paciente, EmailPaciente) VALUES ('$id_paciente', '$EmailPaciente')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}

	// buscar xxx
	$sql = "SELECT * FROM email_paciente ORDER BY Timestamp DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_email_paciente = $row['id_email_paciente'];
	    }
	} else {
	}

	if (empty($_POST['NotaEmail'])) {
	} else {
		// atualizar
		$sql = "UPDATE email_paciente SET NotaEmail = '$NotaEmail' WHERE id_email_paciente = '$id_email_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}	
}

// voltar
header("Location: paciente.php?id_paciente=$id_paciente");
exit;
?>
