<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

$sqlA = "SELECT * FROM agenda_paciente WHERE id_hora = '$id_hora' AND Data = '$Data' AND id_paciente = '$id_paciente'";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$id_agenda_paciente = $rowA['id_agenda_paciente'];
		$id_profissional = $rowA['id_profissional'];
		$id_categoriaX = $rowA['id_categoria'];
		$id_unidadeX = $rowA['id_unidade'];

		// buscar xxx
		$sqlB = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
		$resultB = $conn->query($sqlB);
		if ($resultB->num_rows > 0) {
		    while($rowB = $resultB->fetch_assoc()) {
				// tem
				$NomeProfissional = $rowB['NomeCurto'];
		    }
		} else {
			// não tem
		}

		// buscar xxx
		$sqlB = "SELECT * FROM categoria WHERE id_categoria = '$id_categoriaX'";
		$resultB = $conn->query($sqlB);
		if ($resultB->num_rows > 0) {
		    while($rowB = $resultB->fetch_assoc()) {
				// tem
				$NomeCategoriaX = $rowB['NomeCategoria'];
		    }
		} else {
			// não tem
			$NomeCategoriaX = NULL;
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

		echo '<form action="relatorio-agenda-profissional.php" method="post" class="hidden-print">
            <input type="text" hidden name="id_profissional" value="'.$id_profissional.'">
            <button type="submit" class="Link">'.$NomeProfissional.'</button>
        </form>';
		echo '<span class="visible-print">'.$NomeProfissional.'</span>';
		echo '<span style="font-size:0.8em;">'.$NomeCategoriaX.'</span> - <span class="badge" style="background-color:'.$CorUnidade.';color:'.$CorTexto.'; margin-right: 5px;">'.$NomeUnidadeX.'</span>';
    }
} else {
	// não tem
}

?>