<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

$StatusConvenio = $_POST['StatusConvenio'];

// input múlitplo
foreach ($_POST['id_agenda_paciente'] as $Item => $Valor) {
	$Item++;
	// echo $Item.' > '.$Valor.'<br>';

	// 1. pesquisar se o Total é positivo, que são as horas liberadas pelo convenio
	// na ordem data crescente e hora crescente
	// buscar xxx
	$sql = "SELECT * FROM agenda_paciente WHERE id_agenda_paciente = '$Valor' ORDER BY Data ASC, id_hora ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_paciente = $row['id_paciente'];
			$id_agenda_paciente = $row['id_agenda_paciente'];

			// buscar xxx
			$sqlA = "SELECT * FROM convenio_paciente WHERE id_paciente = '$id_paciente' AND StatusConvenio = 1";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$id_convenio = $rowA['id_convenio'];

					if ($StatusConvenio == 1) {
						// atualizar
						$sqlB = "UPDATE agenda_paciente SET id_convenio_validado = '$id_convenio' WHERE id_agenda_paciente = '$id_agenda_paciente' ";
						if ($conn->query($sqlB) === TRUE) {
						} else {
						}
					}
					if ($StatusConvenio == 2) {
						// atualizar
						$sqlB = "UPDATE agenda_paciente SET id_convenio_validado = NULL WHERE id_agenda_paciente = '$id_agenda_paciente' ";
						if ($conn->query($sqlB) === TRUE) {
						} else {
						}
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

// voltar
header("Location: index.php");
exit;
?>
