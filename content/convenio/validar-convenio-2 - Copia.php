<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

$StatusConvenio = $_GET['StatusConvenio'];

if ($StatusConvenio == 1) {
	// input múlitplo
	foreach ($_POST['id_agenda_paciente'] as $Item => $Valor) {
		$Item++;
		// echo $Item.' > '.$Valor.'<br>';

		// atualizar
		$sql = "UPDATE agenda_paciente SET Convenio = 2 WHERE id_agenda_paciente = '$Valor' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}

		// buscar xxx
		$sql = "SELECT * FROM agenda_paciente WHERE id_agenda_paciente = '$Valor'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$id_paciente = $row['id_paciente'];

				// buscar xxx
				$sqlA = "SELECT * FROM convenio_paciente WHERE id_paciente = '$id_paciente' AND StatusConvenio = 1";
				$resultA = $conn->query($sqlA);
				if ($resultA->num_rows > 0) {
				    while($rowA = $resultA->fetch_assoc()) {
						// tem
						$id_convenio = $rowA['id_convenio'];

						// atualizar
						$sqlB = "UPDATE agenda_paciente SET id_convenio = '$id_convenio' WHERE id_agenda_paciente = '$Valor' ";
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
	}
} else {
	// input múlitplo
	foreach ($_POST['id_agenda_paciente'] as $Item => $Valor) {
		$Item++;
		// echo $Item.' > '.$Valor.'<br>';

		// atualizar
		$sql = "UPDATE agenda_paciente SET Convenio = 1 WHERE id_agenda_paciente = '$Valor' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}

		// atualizar
		$sqlB = "UPDATE agenda_paciente SET id_convenio = NULL WHERE id_agenda_paciente = '$Valor' ";
		if ($conn->query($sqlB) === TRUE) {
		} else {
		}
	}
}

// voltar
header("Location: index.php");
exit;
?>
