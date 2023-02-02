<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// buscar xxx
$sql = "SELECT distinct p.NomeCurto, u.NomeUnidade, c.NomeCategoria, u.CorUnidade, u.CorTexto, a.id_profissional, a.id_hora, a.Data, a.id_paciente, a.id_agenda_paciente, a.Auxiliar
FROM profissional p, categoria c, agenda_paciente a, unidade u 
WHERE a.id_categoria = c.id_categoria AND a.id_unidade = u.id_unidade AND a.id_profissional = p.id_profissional AND a.id_paciente = '$id_paciente' AND a.id_hora = '$id_hora' AND a.Data = '$Data'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_agenda_paciente = $row['id_agenda_paciente'];
		$id_profissional = $row['id_profissional'];
		$NomeProfissional = $row['NomeCurto'];
		$NomeCategoriaX = $row['NomeCategoria'];
		$CorUnidade = $row['CorUnidade'];
		$CorTexto = $row['CorTexto'];
		$NomeUnidadeX = $row['NomeUnidade'];
		$AuxiliarX = $row['Auxiliar'];
		// $id_periodo = $row['id_periodo'];
		// $DiaSemana = $row['DiaSemana'];

		// Auxiliar 1 aplicador, 2 terapeuta
		if ($AuxiliarX == 1) {
			// aplicador
			echo '<span class="Link hidden-print"><a href="agenda-profissional.php?id_profissional='.$id_profissional.'" class="Link">'.$id_agenda_paciente.'-'.$NomeProfissional.'</a></span>';
			echo ' - <span class="badge" style="margin-right: 5px;">Aplicador</span>';
		} else {
			// terapeuta
			echo '<span class="Link hidden-print"><a href="agenda-profissional.php?id_profissional='.$id_profissional.'" class="Link">'.$id_agenda_paciente.'-'.$NomeProfissional.'</a></span>';

			// echo '<span class="visible-print">'.$NomeProfissional.'</span>';

			echo '<span style="font-size:0.8em;"> - '.$NomeCategoriaX.'</span> - <span class="badge" style="background-color:'.$CorUnidade.';color:'.$CorTexto.'; margin-right: 5px;">'.$NomeUnidadeX.'</span>';
		}

		if (!empty($_SESSION['RemoverTerapeuta'])) {
			echo '<span class="hidden-print"><a href="agenda-paciente-remover-profissional.php?id_agenda_paciente='.$id_agenda_paciente.'" class="btn btn-warning btn-view btn-size">&#x2715;</a></span>';
		}

		echo '<br>';
    }
} else {
	// não tem
}

$id_x="$Hora.$Data.$id_hora";
?>