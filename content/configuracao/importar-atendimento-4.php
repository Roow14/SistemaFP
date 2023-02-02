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
$sql = "SELECT * FROM agenda_paciente_tmp";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_agenda_paciente_tmp = $row['id_agenda_paciente_tmp'];
		$NomePaciente = $row['NomePaciente'];
		$Hora = $row['Hora'];
		$DiaSemana = $row['DiaSemana'];
		$NomeCategoria = $row['NomeCategoria'];
		$NomeProfissional = $row['NomeProfissional'];
		$id_hora = $row['id_hora'];
		$id_categoria = $row['id_categoria'];
		$id_paciente = $row['id_paciente'];
		$id_profissional = $row['id_profissional'];

		// buscar xxx
		$sqlA = "SELECT * FROM paciente WHERE NomeCompleto = '$NomePaciente'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_paciente = $rowA['id_paciente'];
				// atualizar
				$sqlB = "UPDATE agenda_paciente_tmp SET id_paciente = '$id_paciente' WHERE id_agenda_paciente_tmp = '$id_agenda_paciente_tmp' ";
				if ($conn->query($sqlB) === TRUE) {
				} else {
				}
		    }
		} else {
			// não tem
		}

		// buscar xxx
		$sqlA = "SELECT * FROM profissional WHERE NomeCompleto = '$NomeProfissional'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_profissional = $rowA['id_profissional'];
				// atualizar
				$sqlB = "UPDATE agenda_paciente_tmp SET id_profissional = '$id_profissional' WHERE id_agenda_paciente_tmp = '$id_agenda_paciente_tmp' ";
				if ($conn->query($sqlB) === TRUE) {
				} else {
				}
		    }
		} else {
			// não tem
		}

		// buscar xxx
		$sqlA = "SELECT * FROM categoria WHERE NomeCategoria = '$NomeCategoria'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_categoria = $rowA['id_categoria'];
				// atualizar
				$sqlB = "UPDATE agenda_paciente_tmp SET id_categoria = '$id_categoria' WHERE id_agenda_paciente_tmp = '$id_agenda_paciente_tmp' ";
				if ($conn->query($sqlB) === TRUE) {
				} else {
				}
		    }
		} else {
			// não tem
		}

		// buscar xxx
		$sqlA = "SELECT * FROM hora WHERE Hora = '$Hora'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_hora = $rowA['id_hora'];
				$Periodo = $rowA['Periodo'];
				// atualizar
				$sqlB = "UPDATE agenda_paciente_tmp SET id_hora = '$id_hora', id_periodo = '$Periodo' WHERE id_agenda_paciente_tmp = '$id_agenda_paciente_tmp' ";
				if ($conn->query($sqlB) === TRUE) {
				} else {
				}
		    }
		} else {
			// não tem
		}
    }
} else {
	// não tem
}

// voltar
header("Location: importar-atendimento.php");
exit;
?>