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
$sql = "SELECT * FROM agenda_paciente_base WHERE id_paciente = 308 AND DiaSemana = 3";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>id_agenda_paciente_base</th>';
	echo '<th>id_paciente</th>';
	echo '<th>id_profissional</th>';
	echo '<th>Auxiliar</th>';
	echo '<th>id_unidade</th>';
	echo '<th>id_categoria</th>';
	echo '<th>Data</th>';
	echo '<th>DiaSemana</th>';
	echo '<th>id_hora</th>';
	echo '<th>id_periodo</th>';
	echo '<th>NomePaciente</th>';
	echo '<th>NomeProfissional</th>';
	echo '<th>NomeUnidade</th>';
	echo '<th>NomeCategoria</th>';
	echo '<th>Status</th>';
	// echo '<th>Timestamp</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_agenda_paciente_base = $row['id_agenda_paciente_base'];
		$id_paciente = $row['id_paciente'];
		$id_profissional = $row['id_profissional'];
		$Auxiliar = $row['Auxiliar'];
		$id_unidade = $row['id_unidade'];
		$id_categoria = $row['id_categoria'];
		$Data = $row['Data'];
		$DiaSemana = $row['DiaSemana'];
		$id_hora = $row['id_hora'];
		$id_periodo = $row['id_periodo'];
		$NomePaciente = $row['NomePaciente'];
		$NomeProfissional = $row['NomeProfissional'];
		$NomeUnidade = $row['NomeUnidade'];
		$NomeCategoria = $row['NomeCategoria'];
		$Status = $row['Status'];
		$Timestamp = $row['Timestamp'];
		echo '<tr>';
		echo '<td>'.$id_agenda_paciente_base.'</td>';
		echo '<td>'.$id_paciente.'</td>';
		echo '<td>'.$id_profissional.'</td>';
		echo '<td>'.$Auxiliar.'</td>';
		echo '<td>'.$id_unidade.'</td>';
		echo '<td>'.$id_categoria.'</td>';
		echo '<td>'.$Data.'</td>';
		echo '<td>'.$DiaSemana.'</td>';
		echo '<td>'.$id_hora.'</td>';
		echo '<td>'.$id_periodo.'</td>';
		echo '<td>'.$NomePaciente.'</td>';
		echo '<td>'.$NomeProfissional.'</td>';
		echo '<td>'.$NomeUnidade.'</td>';
		echo '<td>'.$NomeCategoria.'</td>';
		echo '<td>'.$Status.'</td>';
		// echo '<td>'.$Timestamp.'</td>';
		echo '</tr>';
    }
    echo '</tbody>';
	echo '</table>';
} else {
	// não tem
}

?>