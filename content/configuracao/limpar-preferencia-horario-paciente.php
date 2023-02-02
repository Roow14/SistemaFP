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
$sql = "SELECT * FROM paciente ORDER BY id_paciente ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];

		// buscar xxx
		$sqlA = "SELECT * FROM paciente_preferencia WHERE id_paciente = '$id_paciente' ORDER BY id_paciente_preferencia ASC LIMIT 1";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_paciente_preferencia = $rowA['id_paciente_preferencia'];
				$PacientePreferencia = $rowA['PacientePreferencia'];
				// echo $id_paciente_preferencia.' Primeiro <br>';

				// buscar xxx
				$sqlB = "SELECT * FROM paciente_preferencia WHERE id_paciente = '$id_paciente' AND PacientePreferencia = '$PacientePreferencia' LIMIT 1, 10";
				$resultB = $conn->query($sqlB);
				if ($resultB->num_rows > 0) {
				    while($rowB = $resultB->fetch_assoc()) {
						// tem
						$id_paciente_preferencia = $rowB['id_paciente_preferencia'];
						$PacientePreferencia = $rowB['PacientePreferencia'];
						// echo $id_paciente_preferencia.' - '.$PacientePreferencia.'<br>';

						// apagar
						$sqlC = "DELETE FROM paciente_preferencia WHERE id_paciente_preferencia = '$id_paciente_preferencia'";
						if ($conn->query($sqlC) === TRUE) {
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
	// não tem
}

// mensagem de alerta
echo "<script type=\"text/javascript\">
    alert(\"Textos duplicados verificados.\");
    window.location = \"configuracao.php\"
    </script>";
exit;

// voltar
header("Location: configuracao.php");
exit;
?>
