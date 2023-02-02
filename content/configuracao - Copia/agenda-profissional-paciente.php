<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// buscar xxx
$sqlA = "SELECT * FROM agenda_paciente WHERE id_hora = '$id_hora' AND Data = '$Data' AND id_profissional = '$id_profissional'";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$id_agenda_paciente = $rowA['id_agenda_paciente'];
		$id_paciente = $rowA['id_paciente'];
		$id_categoriaX = $rowA['id_categoria'];
		$id_unidadeX = $rowA['id_unidade'];

		// buscar xxx
		$sqlB = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
		$resultB = $conn->query($sqlB);
		if ($resultB->num_rows > 0) {
		    while($rowB = $resultB->fetch_assoc()) {
				// tem
				$NomePaciente = $rowB['NomeCurto'];
				echo '<form action="relatorio-agenda-paciente.php" method="post" class="hidden-print">
			            <input type="text" hidden name="id_paciente" value="'.$id_paciente.'">
			            <button type="submit" class="Link">'.$NomePaciente.'</button>
			        </form>';
				echo '<span class="visible-print">'.$NomePaciente.'</span>';
				
		    }
		} else {
			// não tem
		}

		// buscar xxx
		$sqlB = "SELECT * FROM unidade WHERE id_unidade = '$id_unidadeX'";
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

		// buscar xxx
		$sqlB = "SELECT * FROM categoria WHERE id_categoria = '$id_categoriaX'";
		$resultB = $conn->query($sqlB);
		if ($resultB->num_rows > 0) {
		    while($rowB = $resultB->fetch_assoc()) {
				// tem
				$NomeCategoriaX = $rowB['NomeCategoria'];
				// echo $NomeCategoriaX.'<br>';
				echo '<span style="font-size:0.8em;">'.$NomeCategoriaX.'</span> - <span class="badge" style="background-color:'.$CorUnidade.';color:'.$CorTexto.'; margin-right: 5px;">'.$NomeUnidadeX.'</span>';
		    }
		} else {
			// não tem
		}
    }
} else {
	// não tem
 }
?>