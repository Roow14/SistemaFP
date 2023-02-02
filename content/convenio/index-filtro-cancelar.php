<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// input
$Tmp = 'Tmp_'.$_SESSION['UsuarioID'];

// apagar tabela
$sql = "DROP TABLE $Tmp";
if ($conn->query($sql) === TRUE) {
} else {
}

// sql to create table
$sql = "CREATE TABLE $Tmp (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
id_agenda_paciente VARCHAR(30)
)";
if ($conn->query($sql) === TRUE) {
} else {
}

// buscar xxx
$sqlZ = "SELECT agenda_paciente.*, paciente.NomeCompleto, hora.Hora, categoria.NomeCategoria
FROM agenda_paciente
INNER JOIN paciente ON paciente.id_paciente = agenda_paciente.id_paciente
INNER JOIN hora ON hora.id_hora = agenda_paciente.id_hora
INNER JOIN categoria ON categoria.id_categoria = agenda_paciente.id_categoria
WHERE agenda_paciente.Data = '$DataAgenda'
$FiltroPaciente $FiltroCategoria
ORDER BY paciente.NomeCompleto ASC, hora.Hora ASC
";
$resultZ = $conn->query($sqlZ);
if ($resultZ->num_rows > 0) {
    while($rowZ = $resultZ->fetch_assoc()) {
		// tem
		$id_pacienteY = $rowZ['id_paciente'];
		$id_convenioY = $rowZ['id_convenio'];
		$id_agenda_pacienteY = $rowZ['id_agenda_paciente'];

		// buscar xxx
		$sqlA = "SELECT * FROM convenio_paciente
		INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
		WHERE convenio_paciente.id_paciente = '$id_pacienteY' AND convenio_paciente.StatusConvenio = 1 $FiltroConvenio";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				// inserir
				$sqlB = "INSERT INTO $Tmp (id_agenda_paciente) VALUES ('$id_agenda_pacienteY')";
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

// buscar xxx
$sql = "SELECT * FROM $Tmp ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$Soma = $row['id'];
		$_SESSION['Soma'] = $Soma;
    }
} else {
	// não tem
	$Soma = NULL;
	unset ($_SESSION['Soma']);
}
?>
