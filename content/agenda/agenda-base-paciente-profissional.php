<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// buscar xxx
$sql = "SELECT distinct p.NomeCurto, u.NomeUnidade, c.NomeCategoria, u.CorUnidade, u.CorTexto, a.id_profissional, a.id_hora, a.DiaSemana, a.id_paciente, a.id_agenda_paciente_base, a.Auxiliar
FROM profissional p, categoria c, agenda_paciente_base a, unidade u 
WHERE a.id_categoria = c.id_categoria AND a.id_unidade = u.id_unidade AND a.id_profissional = p.id_profissional AND a.id_paciente = '$id_paciente' AND a.id_hora = '$id_hora' AND a.DiaSemana = '$DiaSemana'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_agenda_paciente_base = $row['id_agenda_paciente_base'];
		$id_profissional = $row['id_profissional'];
		$NomeProfissional = $row['NomeCurto'];
		$NomeCategoriaX = $row['NomeCategoria'];
		$CorUnidade = $row['CorUnidade'];
		$CorTexto = $row['CorTexto'];
		$NomeUnidadeX = $row['NomeUnidade'];
		$AuxiliarX = $row['Auxiliar'];

		// Auxiliar 1 aplicador, 2 terapeuta
		if ($AuxiliarX == 1) {
			// aplicador
			echo '<span class="Link hidden-print"><a href="agenda-base-profissional.php?id_profissional='.$id_profissional.'" class="Link">'.$NomeProfissional.'</a></span>';
			echo ' - <span class="badge" style="margin-right: 5px;">Aplicador</span>';
		} else {
			// terapeuta
			echo '<span class="Link hidden-print"><a href="agenda-base-profissional.php?id_profissional='.$id_profissional.'" class="Link">'.$NomeProfissional.'</a></span>';

			// echo '<span class="visible-print">'.$NomeProfissional.'</span>';

			echo '<span style="font-size:0.8em;"> - '.$NomeCategoriaX.'</span> - <span class="badge" style="background-color:'.$CorUnidade.';color:'.$CorTexto.'; margin-right: 5px;">'.$NomeUnidadeX.'</span>';
		}

		if (!empty($_SESSION['RemoverTerapeuta'])) {
			echo '<span class="hidden-print"><a href="agenda-base-paciente-remover-profissional.php?id_agenda_paciente_base='.$id_agenda_paciente_base.'" class="btn btn-warning btn-view btn-size">&#x2715;</a></span>';
		}

		echo '<br>';
    }
} else {
	// n??o tem
}

$id_x="$Hora.$DiaSemana.$id_hora";
?>