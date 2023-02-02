<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// recebe StatusConvenio e id_agenda_paciente
// StatusConvenio 1 validar convenio, 2 cancelar validação
// recebe múltiplos id_agenda_paciente[], foreach identifica cada uma delas

// processo de validação
// 1. pesquisar se o Total é positivo, que são as horas liberadas pelo convenio
// se positivo, subtrair 1 hora do Total
// alterar o Convenio para 2, que é validado

// input
$StatusConvenio = $_GET['StatusConvenio'];

// validar convenio
if ($StatusConvenio == 1) {
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
				$Convenio = $row['Convenio'];

				// buscar xxx
				$sqlA = "SELECT * FROM convenio_paciente WHERE id_paciente = '$id_paciente' AND StatusConvenio = 1";
				$resultA = $conn->query($sqlA);
				if ($resultA->num_rows > 0) {
				    while($rowA = $resultA->fetch_assoc()) {
						// tem
						$id_convenio = $rowA['id_convenio'];
						$id_convenio_paciente = $rowA['id_convenio_paciente'];
						$Total = $rowA['Total'];

						if (($Total > 0) & ($Convenio == 1)) {
							// subtrair 1 hora do Total
							$NovoTotal = $Total - 1;

							// atualizar
							$sqlB = "UPDATE agenda_paciente SET id_convenio = '$id_convenio', Convenio = 2 WHERE id_agenda_paciente = '$Valor' ";
							if ($conn->query($sqlB) === TRUE) {
							} else {
							}

							// atualizar
							$sqlB = "UPDATE convenio_paciente SET Total = '$NovoTotal' WHERE id_convenio_paciente = '$id_convenio_paciente' ";
							if ($conn->query($sqlB) === TRUE) {
							} else {
							}
						}
						echo $sqlA;
				    }
				} else {
					// não tem
				}
		    }
		} else {
			// não tem
		}
	}
// cancelar validação
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
// header("Location: index.php");
exit;
?>
