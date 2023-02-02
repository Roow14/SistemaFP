<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

$Status = $_GET['Status'];

// input múlitplo
foreach ($_POST['id_agenda_paciente'] as $Item => $Valor) {
	$Item++;
	// echo $Item.' > '.$Valor.'<br>';

	// buscar xxx
	$sql = "SELECT * FROM agenda_paciente WHERE id_agenda_paciente = '$Valor' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_convenio_validado = $row['id_convenio_validado'];

			if (!empty($id_convenio_validado)) {
				// atualizar
				$sqlA = "UPDATE agenda_paciente SET Presenca = '$Status' WHERE id_agenda_paciente = '$Valor' ";
				if ($conn->query($sqlA) === TRUE) {
				} else {
				}
			}			
	    }
	} else {
		// não tem
	}
}

// voltar
header("Location: relatorio-agenda-do-dia.php");
exit;
?>