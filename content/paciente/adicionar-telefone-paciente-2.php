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
$ClasseTel = 1;
$NumeroTel = $_POST['NumeroTel'];
$Tipo = $_POST['Tipo'];
$NotaTel = $_POST['NotaTel'];

if (empty($_POST['NumeroTel'])) {
} else {
	// inserir
	$sql = "INSERT INTO telefone_paciente (id_paciente, NumeroTel, ClasseTel) VALUES ('$id_paciente', '$NumeroTel', '$ClasseTel')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}

	// buscar xxx
	$sql = "SELECT * FROM telefone_paciente ORDER BY Timestamp DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_telefone_paciente = $row['id_telefone_paciente'];
	    }
	} else {
	}

	if (empty($_POST['Tipo'])) {
	} else {
		// atualizar
		$sql = "UPDATE telefone_paciente SET Tipo = '$Tipo' WHERE id_telefone_paciente = '$id_telefone_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}

	if (empty($_POST['NotaTel'])) {
	} else {
		// atualizar
		$sql = "UPDATE telefone_paciente SET NotaTel = '$NotaTel' WHERE id_telefone_paciente = '$id_telefone_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
}

// voltar
header("Location: paciente.php?id_paciente=$id_paciente");
exit;
?>
