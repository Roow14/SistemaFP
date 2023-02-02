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
$sqlA = "SELECT * FROM agenda_paciente WHERE id_hora = '$id_hora' AND DiaSemana = '$DiaSemana' AND id_paciente = '$id_paciente' AND id_unidade = '$id_unidade'";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$id_agenda_paciente = $rowA['id_agenda_paciente'];
		$id_profissional = $rowA['id_profissional'];
		$id_categoriaX = $rowA['id_categoria'];

		// buscar xxx
		$sqlB = "SELECT * FROM categoria WHERE id_categoria = '$id_categoriaX'";
		$resultB = $conn->query($sqlB);
		if ($resultB->num_rows > 0) {
		    while($rowB = $resultB->fetch_assoc()) {
				// tem
				$NomeCategoriaX = $rowB['NomeCategoria'];
				echo $NomeCategoriaX.'<br>';
		    }
		} else {
			// não tem
		}

		// buscar xxx
		$sqlB = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
		$resultB = $conn->query($sqlB);
		if ($resultB->num_rows > 0) {
		    while($rowB = $resultB->fetch_assoc()) {
				// tem
				$NomeProfissional = $rowB['NomeCurto'];
				echo '<a href="agenda-base-profissional.php?id_profissional='.$id_profissional.'" class="Link">'.$NomeProfissional.'</a>';
		    }
		} else {
			// não tem
		}

		if (empty($_SESSION['AtivarAlteracaoAtendimento'])) {

		} else {
			echo '<span style="margin-left: 5px;"><a href="cadastrar-atendimento-remover-profissional.php?id_agenda_paciente='.$id_agenda_paciente.'" class="link-apagar">Cancelar</a></span>';
		}

    }
} else {
	// não tem
	// buscar xxx
	$sqlB = "SELECT profissional.* FROM categoria_profissional INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional WHERE categoria_profissional.id_categoria = '$id_categoria' AND categoria_profissional.id_periodo = '$id_periodo' AND profissional.Status = 1 ORDER BY profissional.NomeCompleto ASC";
	$resultB = $conn->query($sqlB);
	if ($resultB->num_rows > 0) {
		echo '<form action="cadastrar-atendimento-profissional-2.php?id_paciente='.$id_paciente.'&DiaSemana='.$DiaSemana.'&id_unidade='.$id_unidade.'&id_hora='.$id_hora.'&id_periodo='.$id_periodo.'&id_categoria='.$id_categoria.'" method="post" class="">';

	    echo '<div class="input-group" style="margin-left: -15px; margin-right: 15px;">';
		echo '<select class="form-control" name="id_profissionalPesq" required>';
		echo '<option value=""></option>';
	    while($rowB = $resultB->fetch_assoc()) {
			// tem
			if (empty($rowB['id_profissional'])) {

			} else {
				$id_profissionalPesq = $rowB['id_profissional'];
				$NomeProfissional = $rowB['NomeCompleto'];
				
				// verificar se o profissional está agendado neste horário
				$sqlA = "SELECT * FROM agenda_paciente WHERE id_profissional = '$id_profissionalPesq' AND DiaSemana = '$DiaSemana' AND id_unidade ='$id_unidade' AND id_hora = '$id_hora' AND id_periodo = '$id_periodo' AND id_categoria = '$id_categoria'";
				$resultA = $conn->query($sqlA);
				if ($resultA->num_rows > 0) {
				    while($roAw = $resultA->fetch_assoc()) {
						// tem
						echo '<option value="">--- '.$NomeProfissional.' ---</option>';
				    }
				} else {
					// não tem
					echo '<option value="'.$id_profissionalPesq.'">'.$NomeProfissional.'</option>';
				}
			}
	    }
	    echo '</select>';
	    echo '<div class="input-group-btn">';
		echo '<button type="submit" class="btn btn-default" style="color: #999; background-color: #fafafa; border-color: #ccc;">&#x2713;</button>';
		echo '</div>';
		echo '</div>';

	    echo '</form>';
	} else {
		// não tem
	}
}
?>