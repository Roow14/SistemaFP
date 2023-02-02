<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

$sqlA = "SELECT agenda_paciente.*, profissional.NomeCurto, categoria.NomeCategoria
FROM agenda_paciente
INNER JOIN profissional ON agenda_paciente.id_profissional = profissional.id_profissional
INNER JOIN categoria ON agenda_paciente.id_categoria = categoria.id_categoria
WHERE agenda_paciente.id_hora = '$id_hora' AND agenda_paciente.Data = '$Data' AND agenda_paciente.id_paciente = '$id_paciente'";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
	echo '<td>';
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$id_agenda_paciente = $rowA['id_agenda_paciente'];
		$NomeProfissional = $rowA['NomeCurto'];
		$NomeCategoria = $rowA['NomeCategoria'];
		$id_unidade = $rowA['id_unidade'];

		// buscar xxx
		$sqlB = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
		$resultB = $conn->query($sqlB);
		if ($resultB->num_rows > 0) {
		    while($rowB = $resultB->fetch_assoc()) {
				// tem
				$CorUnidade = $rowB['CorUnidade'];
				$CorTexto = $rowB['CorTexto'];
				$NomeUnidadeX = $rowB['NomeUnidade'];
		    }
		} else {
			// não tem
			$NomeUnidadeX = NULL;
		}

		echo '<a href="relatorio-agenda-paciente-box.php?id_agenda_paciente='.$id_agenda_paciente.'" method="post" class="Link">'.$NomeProfissional.'</a><br>'; 
		echo '<span class="visible-print">'.$NomeProfissional.'</span>';
		echo '<span style="font-size:0.8em;">'.$NomeCategoria.'</span> - <span class="badge" style="background-color:'.$CorUnidade.';color:'.$CorTexto.'; margin-right: 5px;">'.$NomeUnidadeX.'</span>';
    }
    echo '</td>';
} else {
	// não tem
	echo '<td class="vazio"><a href="relatorio-agenda-paciente-box-vazio.php?Data='.$Data.'&id_hora='.$id_hora.'" method="post"><div>Agendar</div></a></td>';
}
?>