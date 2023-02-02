<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

date_default_timezone_set("America/Sao_Paulo");
$DataAtualX = date("d/m/Y");
$DataAtual = date("Y-m-d");

// conexão com banco
include '../conexao/conexao.php';

// buscar xxx
$sql = "SELECT * FROM agenda_paciente_base";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_agenda_paciente_base = $row['id_agenda_paciente_base'];
		$id_profissional = $row['id_profissional'];
		
		if (empty($id_profissional)) {
			// apagar
			$sqlA = "DELETE FROM agenda_paciente_base WHERE id_agenda_paciente_base = '$id_agenda_paciente_base'";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}

		} else {
			// buscar xxx
			$sqlA = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
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
    }

} else {
	// não tem
}

// voltar
header("Location: listar-pacientes-sem-terapeuta.php");
exit;
?>