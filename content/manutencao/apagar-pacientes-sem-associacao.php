<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';
 
// buscar xxx
$sql = "SELECT * FROM agenda_paciente_base ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$DiaSemana = $row['DiaSemana'];
		$id_hora = $row['id_hora'];
		$id_paciente = $row['id_paciente'];
		$id_agenda_paciente_base = $row['id_agenda_paciente_base'];

		// buscar xxx
		$sqlA = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$Hora = $rowA['Hora'];
		    }
		} else {
			// não tem
		}

		// buscar xxx
		$sqlA = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeCompleto = $rowA['NomeCompleto'];
		    }
		} else {
			// não tem
			// apagar
			$sqlB = "DELETE FROM agenda_paciente_base WHERE id_agenda_paciente_base = '$id_agenda_paciente_base'";
			if ($conn->query($sqlB) === TRUE) {
			} else {
			}
		}
    }
} else {
	// não tem
}

// voltar
header("Location: corrigir-profissionais-equo.php");
exit;
?>
