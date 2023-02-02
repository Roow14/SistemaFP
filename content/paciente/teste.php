<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

date_default_timezone_set("America/Sao_Paulo");
$DataAtualX = date("d/m/Y");
$DataAtual = date("Y-m-d");

// conexão com banco
include '../conexao/conexao.php';

$Origem = '../paciente/index.php';
unset($_SESSION['id_paciente']);
unset($_SESSION['id_profissinal']);

// filtro
if (empty($_SESSION['StatusPaciente'])) {
	$StatusPaciente = NULL;
	$FiltroStatus = 'WHERE Status = 1';
	$NomeStatusPaciente = 'Ativo';
} else {
	$StatusPaciente = $_SESSION['StatusPaciente'];
	if ($StatusPaciente == 1) {
		$NomeStatusPaciente = 'Ativo';
		$FiltroStatus = 'WHERE Status = '. $StatusPaciente;
	} elseif ($StatusPaciente == 3) {
		$NomeStatusPaciente = 'Ativos e inativos';
		$FiltroStatus = 'WHERE Status = 1 OR Status = 2';
		$NomeStatusPaciente = 'Inativo';
		$FiltroStatus = 'WHERE Status = '. $StatusPaciente;
	}
}

// filtro por paciente
if (empty($_SESSION['PesquisaPaciente'])) {
	$PesquisaPaciente = NULL;
	$FiltroPaciente = NULL;
} else {
	$PesquisaPaciente = $_SESSION['PesquisaPaciente'];
	$FiltroPaciente = 'AND (NomeCompleto LIKE "%'.$PesquisaPaciente.'%" OR id_paciente LIKE "%'.$PesquisaPaciente.'%")';
}

$sql = "SELECT COUNT(id_paciente) AS Soma FROM paciente $FiltroStatus $FiltroPaciente ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// tem
	while($row = $result->fetch_assoc()) {
		$Soma = $row['Soma'];
	}
// não tem
} else {
	$Soma = 0;
}

// buscar xxx
$sql = "SELECT * FROM paciente 
$FiltroStatus $FiltroPaciente 
ORDER BY NomeCurto ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>ID</th>';
	echo '<th>Nome</th>';
	echo '<th>Status</th>';
	echo '<th>Convênio</th>';
	echo '<th>Plano ter.</th>';
	echo '<th style="text-align: right;">Ação</th>';
	echo '</tr>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
		$Status = $row['Status'];
		if ($Status == 1) {
			$NomeStatus = 'Ativo';
		} else {
			$NomeStatus = 'Inativo';
		}

		echo '<tr>';
		echo '<td>'.$id_paciente.'</td>';
		echo '<td><a href="paciente.php?id_paciente='.$id_paciente.'" method="post" class="Link">'.$NomeCompleto.'</a></td>';
		echo '<td>'.$NomeStatus.'</td>';

		// buscar xxx
		$sqlA = "SELECT convenio.NomeConvenio FROM convenio_paciente
		INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio 
		WHERE convenio_paciente.id_paciente = '$id_paciente' AND convenio_paciente.StatusConvenio = 1";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeConvenio = $rowA['NomeConvenio'];
		    }
		} else {
			// não tem
			$NomeConvenio = NULL;
		}

		if (!empty($NomeConvenio)) {
			echo '<td>'.$NomeConvenio.'</td>';
		} else {
			echo '<td style="background-color:orange;"></td>';
		}

		// buscar avaliação ativa para utilizar as horas na agenda base
		$sqlA = "SELECT * FROM avaliacao WHERE id_paciente = '$id_paciente' AND Status = 1";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
		        // tem
		        $id_avaliacao = $rowA['id_avaliacao'];
		    }
		} else {
		    // não tem
		    $id_avaliacao = NULL;
		}

		if (!empty($id_avaliacao)) {
			echo '<td>';

			// buscar xxx
			$sqlA = "SELECT categoria_paciente.*, categoria.NomeCategoria
	        FROM categoria_paciente
	        INNER JOIN categoria ON categoria_paciente.id_categoria = categoria.id_categoria
	        WHERE categoria_paciente.id_avaliacao = '$id_avaliacao'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$id_categoria_paciente = $rowA['id_categoria_paciente'];
	                $id_categoriaX = $rowA['id_categoria'];
	                $NomeCategoriaX = $rowA['NomeCategoria'];
	                $HorasX = $rowA['Horas'];

	                $sqlB = "SELECT COUNT(id_agenda_paciente_base) AS Soma FROM agenda_paciente_base WHERE id_paciente = '$id_paciente' AND id_categoria = '$id_categoriaX' ";
					$resultB = $conn->query($sqlB);
					if ($resultB->num_rows > 0) {
						// tem
						while($rowB = $resultB->fetch_assoc()) {
							$Soma = $rowB['Soma'];
						}
					// não tem
					} else {
						$Soma = 0;
					}

					if ($Soma == $HorasX) {
						echo $NomeCategoriaX.' ('.$Soma.' / '.$HorasX.')<br>';
					} else {
						echo '<mark class="laranja">'.$NomeCategoriaX.' ('.$Soma.' / '.$HorasX.') - corrigir</mark><br>';
					}
	                
			    }
			} else {
				// não tem
				echo 'Não foi encontrado nenhum plano terapêutico.';
			}

			// buscar xxx
			$sqlA = "SELECT DISTINCT categoria.NomeCategoria, agenda_paciente_base.id_categoria FROM agenda_paciente_base
			INNER JOIN categoria ON agenda_paciente_base.id_categoria = categoria.id_categoria
			WHERE agenda_paciente_base.id_paciente = '$id_paciente' ";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$id_categoriaY = $rowA['id_categoria'];
					$NomeCategoriaY = $rowA['NomeCategoria'];

					// buscar xxx
					$sqlB = "SELECT * FROM categoria_paciente WHERE id_paciente = '$id_paciente' AND id_categoria = '$id_categoriaY' ";
					$resultB = $conn->query($sqlB);
					if ($resultB->num_rows > 0) {
					    while($rowB = $resultB->fetch_assoc()) {
							// tem
					    }
					} else {
						// não tem
						echo '<mark class="laranja">'.$NomeCategoriaY.' - não está no plano terapêutico</mark><br>';
					}
			    }
			} else {
				// não tem
			}
			echo '</td>';
		} else {
			echo '<td style="background-color:orange;"></td>';
		}
		
		echo '<td style="text-align: right;">';
		echo '<a href="../agenda/agenda-paciente.php?id_paciente='.$id_paciente.'" class="btn btn-default">Agenda</a>';
		echo '<a href="../agenda/agenda-base-paciente.php?id_paciente='.$id_paciente.'" class="btn btn-default">Agenda base</a>';
		echo '</td>';
		
		echo '<td>';
		echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</form>';
} else {
	// não tem
	echo '<div style="margin: 25px 0">';
	echo '<b>Nota:</b> Não foi encontrado nenhum paciente.';
	echo '</div>';
}
?>