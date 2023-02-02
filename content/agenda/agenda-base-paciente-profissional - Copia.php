	<?php
	if (!isset($_SESSION)) session_start();
	$nivel_necessario = 2;
	if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
	session_destroy();
	header("Location: ../../index.html"); exit;
	}
	// buscar xxx
	$sql = "SELECT distinct p.NomeCurto, u.NomeUnidade, c.NomeCategoria, u.CorUnidade, u.CorTexto, a.id_profissional, a.id_hora, a.DiaSemana, a.id_paciente, a.id_agenda_paciente_base
	from profissional p, categoria c, agenda_paciente_base a, unidade u 
	where a.id_categoria = c.id_categoria AND a.id_unidade = u.id_unidade and a.id_profissional = p.id_profissional and a.id_paciente = '{$id_paciente}' and a.id_hora = '{$id_hora}' and a.DiaSemana = '{$DiaSemana}'";
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

			echo '<span class="Link hidden-print"><a href="agenda-base-profissional.php?id_profissional='.$id_profissional.'" class="Link">'.$NomeProfissional.'</a><br></span>';
			echo '<span class="visible-print">'.$NomeProfissional.'</span>';
			echo '<span style="font-size:0.8em;">'.$NomeCategoriaX.'</span> - <span class="badge" style="background-color:'.$CorUnidade.';color:'.$CorTexto.'; margin-right: 5px;">'.$NomeUnidadeX.'</span>';

			if (empty($_SESSION['AtivarAlteracaoAtendimento'])) {

			} else {
				echo '<span class="hidden-print" data-toggle="tooltip" title="Cancelar terapeuta"><a href="agenda-base-paciente-remover-profissional.php?id_agenda_paciente_base='.$id_agenda_paciente_base.'" class="btn-custom btn-warning">&#x2715;</a></span><br>';
			}
	    }
	} else {
		// não tem
	}

	// conexão com banco
	// include_once '../conexao/conexao.php';

	// buscar xxx
	// $sqlA = "SELECT * FROM agenda_paciente_base WHERE id_hora = '$id_hora' AND DiaSemana = '$DiaSemana' AND id_paciente = '$id_paciente' AND id_unidade = '$id_unidade'";
	// $sqlA = "SELECT * FROM agenda_paciente_base WHERE id_hora = '$id_hora' AND DiaSemana = '$DiaSemana' AND id_paciente = '$id_paciente'";
	// $resultA = $conn->query($sqlA);
	// if ($resultA->num_rows > 0) {
	//     while($rowA = $resultA->fetch_assoc()) {
	// 		// tem
	// 		$id_agenda_paciente_base = $rowA['id_agenda_paciente_base'];
	// 		$id_profissional = $rowA['id_profissional'];
	// 		$id_categoriaX = $rowA['id_categoria'];
	// 		$id_unidadeX = $rowA['id_unidade'];

			

	// 		// buscar xxx
	// 		$sqlB = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
	// 		$resultB = $conn->query($sqlB);
	// 		if ($resultB->num_rows > 0) {
	// 		    while($rowB = $resultB->fetch_assoc()) {
	// 				// tem
	// 				$NomeProfissional = $rowB['NomeCurto'];
	// 		    }
	// 		} else {
	// 			// não tem
	// 		}

	// 		// buscar xxx
	// 		$sqlB = "SELECT * FROM categoria WHERE id_categoria = '$id_categoriaX'";
	// 		$resultB = $conn->query($sqlB);
	// 		if ($resultB->num_rows > 0) {
	// 		    while($rowB = $resultB->fetch_assoc()) {
	// 				// tem
	// 				$NomeCategoriaX = $rowB['NomeCategoria'];
	// 		    }
	// 		} else {
	// 			// não tem
	// 			$NomeCategoriaX = NULL;
	// 		}

	// 		// buscar xxx
	// 		$sqlB = "SELECT * FROM unidade WHERE id_unidade = '$id_unidadeX'";
	// 		$resultB = $conn->query($sqlB);
	// 		if ($resultB->num_rows > 0) {
	// 		    while($rowB = $resultB->fetch_assoc()) {
	// 				// tem
	// 				$CorUnidade = $rowB['CorUnidade'];
	// 				$CorTexto = $rowB['CorTexto'];
	// 				$NomeUnidadeX = $rowB['NomeUnidade'];
	// 		    }
	// 		} else {
	// 			// não tem
	// 			$NomeUnidadeX = NULL;
	// 		}

	// 		echo '<span class="Link hidden-print"><a href="agenda-base-profissional.php?id_profissional='.$id_profissional.'" class="Link">'.$NomeProfissional.'</a><br></span>';
	// 		echo '<span class="visible-print">'.$NomeProfissional.'</span>';
	// 		echo '<span style="font-size:0.8em;">'.$NomeCategoriaX.'</span> - <span class="badge" style="background-color:'.$CorUnidade.';color:'.$CorTexto.'; margin-right: 5px;">'.$NomeUnidadeX.'</span>';

	// 		if (empty($_SESSION['AtivarAlteracaoAtendimento'])) {

	// 		} else {
	// 			echo '<span class="hidden-print" data-toggle="tooltip" title="Cancelar terapeuta"><a href="agenda-base-paciente-remover-profissional.php?id_agenda_paciente_base='.$id_agenda_paciente_base.'" class="btn-custom btn-warning">&#x2715;</a></span><br>';
	// 		}

	//     }
	// } else {
	// 	// não tem
	// }
	?>