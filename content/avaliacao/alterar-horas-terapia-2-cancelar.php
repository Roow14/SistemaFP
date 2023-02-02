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
$id_paciente = $_SESSION['id_paciente'];
$Horas = $_POST['Horas'];

// buscar xxx
$sql = "SELECT * FROM horas_terapia WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_horas_terapia = $row['id_horas_terapia'];
		if (!empty($Horas)) {
			// atualizar
			$sqlA = "UPDATE horas_terapia SET Horas = '$Horas' WHERE id_horas_terapia = '$id_horas_terapia' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		} else {
			// atualizar
			$sqlA = "UPDATE horas_terapia SET Horas = NULL WHERE id_horas_terapia = '$id_horas_terapia' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}
    }
} else {
	// não tem
	if (!empty($Horas)) {
		// inserir
		$sqlA = "INSERT INTO horas_terapia (Horas, id_paciente) VALUES ('$Horas', '$id_paciente')";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
}	

// voltar
header("Location: index.php");
exit;
?>