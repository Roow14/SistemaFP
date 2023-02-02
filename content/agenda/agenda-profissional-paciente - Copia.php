<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// buscar xxx
$sqlA = "SELECT * FROM agenda_paciente WHERE id_hora = '$id_hora' AND Data = '$Data' AND id_profissional = '$id_profissional' $FiltroUnidade";
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
				echo '<span class="Link hidden-print"><a href="agenda-paciente.php?id_paciente='.$id_paciente.'">'.$NomePaciente.'</a><br></span>';
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

		// botão para cancelar terapeuta
		if (empty($_SESSION['AtivarAlteracaoAtendimento'])) {
		} else {
			echo '<span class="hidden-print" data-toggle="tooltip" title="Cancelar terapeuta"><a href="agenda-profissional-remover-paciente.php?id_agenda_paciente='.$id_agenda_paciente.'&id_profissional='.$id_profissional.'" class="btn-custom btn-warning">&#x2715;</a></span><br>';
		}

    }
} else {
	// não tem
 }
?>