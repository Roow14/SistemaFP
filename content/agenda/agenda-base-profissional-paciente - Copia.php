<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
// include_once '../conexao/conexao.php';

// buscar xxx
$sqlA = "SELECT * FROM agenda_paciente_base WHERE id_hora = '$id_hora' AND DiaSemana = '$DiaSemana' AND id_profissional = '$id_profissional' ";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$id_agenda_paciente_base = $rowA['id_agenda_paciente_base'];
		$id_paciente = $rowA['id_paciente'];
		$id_categoria = $rowA['id_categoria'];
		$id_unidade = $rowA['id_unidade'];

		// buscar xxx
		$sqlB = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
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
		// echo $id_paciente;
		// buscar xxx
		$sqlB = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
		$resultB = $conn->query($sqlB);
		if ($resultB->num_rows > 0) {
		    while($rowB = $resultB->fetch_assoc()) {
				// tem
				$NomePaciente = $rowB['NomeCurto'];
				echo '<span class="Link hidden-print"><a href="agenda-base-paciente.php?id_paciente='.$id_paciente.'">'.$NomePaciente.'</a><br></span>';
				echo '<span class="visible-print">'.$NomePaciente.'</span>';

				echo '<span style="font-size:0.8em;">'.$NomeCategoriaX.'</span> - <span class="badge" style="background-color:'.$CorUnidade.';color:'.$CorTexto.'; margin-right: 5px;">'.$NomeUnidadeX.'</span>';
		    }
		} else {
			// não tem
		}

		// botão para cancelar criança
		if (empty($_SESSION['AtivarAlteracaoAtendimento'])) {
		} else {
			echo '<span class="hidden-print" data-toggle="tooltip" title="Cancelar criança"><a href="agenda-base-profissional-remover-paciente.php?id_agenda_paciente_base='.$id_agenda_paciente_base.'&id_profissional='.$id_profissional.'" class="btn-custom btn-warning">&#x2715;</a></span><br>';
		}
    }
} else {
	// não tem
}
?>