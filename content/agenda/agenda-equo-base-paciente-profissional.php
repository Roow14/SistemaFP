 <?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input 
$id_unidade = 1;
$id_categoria = 14;

// outros inputs da agenda-equo.php
// $id_hora
// $Hora
// $Periodo
// $DiaSemana
// $Data

// buscar dados do paciente
$sqlA = "SELECT DISTINCT id_paciente FROM agenda_paciente_base WHERE id_hora = '$id_hora' AND DiaSemana = '$DiaSemana' AND id_unidade = '$id_unidade' AND id_categoria = '$id_categoria'";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$id_pacienteY = $rowA['id_paciente'];

		// buscar xxx
		$sqlB = "SELECT * FROM paciente WHERE id_paciente = '$id_pacienteY'";
		$resultB = $conn->query($sqlB);
		if ($resultB->num_rows > 0) {
		    while($rowB = $resultB->fetch_assoc()) {
				// tem
				$NomePaciente = $rowB['NomeCurto'];
				echo 'P:<a href="agenda-base-paciente.php?id_paciente='.$id_pacienteY.'&id_periodo='.$id_periodo.'&id_unidade='.$id_unidade.'&DiaSemana='.$DiaSemana.'" class="Link"> '.$NomePaciente.'</a><br>';
		    }
		} else {
			// não tem
		}

		// buscar xxx
		$sqlC = "SELECT * FROM agenda_paciente_base WHERE id_hora = '$id_hora' AND DiaSemana = '$DiaSemana' AND id_unidade = '$id_unidade' AND id_categoria = '$id_categoria' AND id_paciente = '$id_pacienteY' AND Auxiliar = 2";
		$resultC = $conn->query($sqlC);
		if ($resultC->num_rows > 0) {
		    while($rowC = $resultC->fetch_assoc()) {
				// tem
				$id_profissional = $rowC['id_profissional'];
				// buscar xxx
				$sqlD = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
				$resultD = $conn->query($sqlD);
				if ($resultD->num_rows > 0) {
				    while($rowD = $resultD->fetch_assoc()) {
						// tem
						$NomeProfissional = $rowD['NomeCurto'];
						echo 'T: '.$NomeProfissional.'<br>';
				    }
				} else {
					// não tem
				}
		    }
		} else {
			// não tem
			echo 'T<br>';
		}

		if (empty($_SESSION['AtivarAgendamentoEquo'])) {
			// buscar auxiliar
			$sqlC = "SELECT * FROM agenda_paciente_base WHERE id_hora = '$id_hora' AND DiaSemana = '$DiaSemana' AND id_unidade = '$id_unidade' AND id_categoria = '$id_categoria' AND id_paciente = '$id_pacienteY' AND Auxiliar = 1";
			$resultC = $conn->query($sqlC);
			if ($resultC->num_rows > 0) {
			    while($rowC = $resultC->fetch_assoc()) {
					// tem
					$id_agenda_paciente_base = $rowC['id_agenda_paciente_base'];
					$id_profissionalX = $rowC['id_profissional'];
					// buscar xxx
					$sqlD = "SELECT * FROM profissional WHERE id_profissional = '$id_profissionalX'";
					$resultD = $conn->query($sqlD);
					if ($resultD->num_rows > 0) {
					    while($rowD = $resultD->fetch_assoc()) {
							// tem
							$NomeProfissional = $rowD['NomeCurto'];
							echo 'A: '.$NomeProfissional.'<br>';

							if (empty($_SESSION['AtivarRemocaoProfissionalEquo'])) {
							} else {
								echo '<a href="agenda-equo-base-apagar-profissional-2.php?id_agenda_paciente_base='.$id_agenda_paciente_base.'" class="link-apagar">Cancelar</a>';
							}
							echo '<br>';
					    }
					} else {
						// não tem
					}
			    }
			} else {
				// não tem
				echo 'A:<br>';
			}	
		} else {
			// buscar auxiliar
			$sqlC = "SELECT * FROM agenda_paciente_base WHERE id_hora = '$id_hora' AND DiaSemana = '$DiaSemana' AND id_unidade = '$id_unidade' AND id_categoria = '$id_categoria' AND id_paciente = '$id_pacienteY' AND Auxiliar = 1";
			$resultC = $conn->query($sqlC);
			if ($resultC->num_rows > 0) {
			    while($rowC = $resultC->fetch_assoc()) {
					// tem
					$id_agenda_paciente_base = $rowC['id_agenda_paciente_base'];
					$id_profissionalX = $rowC['id_profissional'];
					// buscar xxx
					$sqlD = "SELECT * FROM profissional WHERE id_profissional = '$id_profissionalX'";
					$resultD = $conn->query($sqlD);
					if ($resultD->num_rows > 0) {
					    while($rowD = $resultD->fetch_assoc()) {
							// tem
							$NomeProfissional = $rowD['NomeCurto'];
							echo 'A: '.$NomeProfissional.'<br>';

							if (empty($_SESSION['AtivarRemocaoProfissionalEquo'])) {
							} else {
								echo '<a href="agenda-equo-base-apagar-profissional-2.php?id_agenda_paciente_base='.$id_agenda_paciente_base.'" class="link-apagar">Cancelar</a>';
							}
							echo '<br>';
					    }
					} else {
						// não tem
					}
			    }
			} else {
				// verificar quantos terapeutas estão cadastrados no mesmo horário
				$sqlC = "SELECT COUNT(id_profissional) AS Soma FROM agenda_paciente_base WHERE id_paciente = '$id_pacienteY' AND DiaSemana = '$DiaSemana' AND id_hora = '$id_hora' AND id_unidade = '$id_unidade' AND id_categoria = '$id_categoria'";
				$resultC = $conn->query($sqlC);
				if ($resultC->num_rows > 0) {
					// tem
					while($rowC = $resultC->fetch_assoc()) {
						$Soma = $rowC['Soma'];
					}
				// não tem
				} else {
					$Soma = NULL;
				}
				// se a soma for menor que 2 podemos adicionar um auxiliar
				if ($Soma < 2) {
					// buscar xxx
					$sqlC = "SELECT * FROM periodo WHERE Periodo = '$Periodo'";
					$resultC = $conn->query($sqlC);
					if ($resultC->num_rows > 0) {
					    while($rowC = $resultC->fetch_assoc()) {
							// tem
							$id_periodoZ = $rowC['id_periodo'];
					    }
					} else {
						// não tem
					}
					// buscar xxx
					$sqlC = "SELECT profissional.* FROM categoria_profissional INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional WHERE categoria_profissional.id_categoria = '$id_categoria' AND categoria_profissional.id_periodo = '$id_periodoZ' AND categoria_profissional.id_unidade = '$id_unidade' AND profissional.Status = 1 ORDER BY profissional.NomeCompleto ASC";
					$resultC = $conn->query($sqlC);
					if ($resultC->num_rows > 0) {
						echo '<form action="agenda-equo-base-paciente-profissional-2.php?id_paciente='.$id_pacienteY.'&DiaSemana='.$DiaSemana.'&id_hora='.$id_hora.'&id_periodo='.$id_periodoZ.'" method="post" class="">';

					    echo '<div class="input-group" style="margin-left: -15px; margin-right: 15px;">';
						echo '<select class="form-control" name="id_profissionalPesq" required>';
						echo '<option value=""></option>';
					    while($rowC = $resultC->fetch_assoc()) {
							// tem
							if (empty($rowC['id_profissional'])) {

							} else {
								$id_profissionalPesq = $rowC['id_profissional'];
								$NomeProfissional = $rowC['NomeCompleto'];
												
								// verificar se o profissional está agendado neste horário
								$sqlD = "SELECT * FROM agenda_paciente_base WHERE id_profissional = '$id_profissionalPesq' AND DiaSemana = '$DiaSemana' AND id_unidade ='$id_unidade' AND id_hora = '$id_hora'";
								$resultD = $conn->query($sqlD);
								if ($resultD->num_rows > 0) {
								    while($rowD = $resultD->fetch_assoc()) {
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
						echo '<button type="submit" class="btn btn-default">&#x2713;</button>';
						echo '</div>';
						echo '</div>';
					    echo '</form>';
					} else {
						// não tem
					}
				} else {
				}
			}	
		}

				
    }
} else {
	// não tem
}
?>