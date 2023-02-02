<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

        	<h3>Agenda base do paciente</h3>
			<p>Conferir duplicidade</p>
			<div class="row">
<div class="col-sm-12">
<?php
// limpar dados da tabela
$sqlA = "TRUNCATE agenda_paciente_tmp";
if ($conn->query($sqlA) === TRUE) {
} else {
}

// copiar os dados da agenda base dompaciente para o tmp
$sql = "SELECT * FROM agenda_paciente";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_agenda_paciente = $row['id_agenda_paciente'];
		$id_profissional = $row['id_profissional'];
		$id_unidade = $row['id_unidade'];
		$id_categoria = $row['id_categoria'];
		$DiaSemana = $row['DiaSemana'];
		$id_hora = $row['id_hora'];
		$id_paciente = $row['id_paciente'];

		// inserir
		$sqlA = "INSERT INTO agenda_paciente_tmp (id_agenda_paciente, id_profissional, id_unidade, id_categoria, DiaSemana, id_hora, id_paciente) VALUES ('$id_agenda_paciente', '$id_profissional', '$id_unidade', '$id_categoria', '$DiaSemana', '$id_hora', '$id_paciente')";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
	// não tem
}

$sql = "SELECT * FROM agenda_paciente";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Dia da semana</th>';
	echo '<th>Hora</th>';
	echo '<th>Profissional</th>';
	echo '<th>Paciente</th>';
	echo '<th>Profissional 2</th>';
	echo '<th>Paciente 2</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_agenda_paciente = $row['id_agenda_paciente'];
		$id_profissional = $row['id_profissional'];
		$id_unidade = $row['id_unidade'];
		$id_categoria = $row['id_categoria'];
		$DiaSemana = $row['DiaSemana'];
		$id_hora = $row['id_hora'];
		$id_paciente = $row['id_paciente'];

		// buscar xxx
		$sqlA = "SELECT * FROM agenda_paciente_tmp ";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_agenda_pacienteX = $rowA['id_agenda_paciente'];
				$id_profissionalX = $rowA['id_profissional'];
				$id_unidadeX = $rowA['id_unidade'];
				$id_categoriaX = $rowA['id_categoria'];
				$DiaSemanaX = $rowA['DiaSemana'];
				$id_horaX = $rowA['id_hora'];
				$id_pacienteX = $rowA['id_paciente'];

				if (($id_profissional == $id_profissionalX) AND ($id_categoria == $id_categoriaX) AND ($id_unidade == $id_unidadeX) AND ($id_hora == $id_horaX) AND ($DiaSemana == $DiaSemanaX)) {
					// são iguais

					echo $id_agenda_paciente.' = '.$id_agenda_pacienteX.'<br>';

					// buscar xxx
					$sqlA = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente' ";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							// tem
							$NomePaciente = $rowA['NomeCompleto'];
					    }
					} else {
						// não tem
					}

					// buscar xxx
					$sqlA = "SELECT * FROM paciente WHERE id_paciente = '$id_pacienteX' ";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							// tem
							$NomePacienteX = $rowA['NomeCompleto'];
					    }
					} else {
						// não tem
					}

					// buscar xxx
					$sqlA = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional' ";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							// tem
							$NomeProfissional = $rowA['NomeCompleto'];
					    }
					} else {
						// não tem
					}

					// buscar xxx
					$sqlA = "SELECT * FROM profissional WHERE id_profissional = '$id_profissionalX' ";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							// tem
							$NomeProfissionalX = $rowA['NomeCompleto'];
					    }
					} else {
						// não tem
					}

					// buscar xxx
					$sqlA = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria' ";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							// tem
							$NomeCategoria = $rowA['NomeCategoria'];
					    }
					} else {
						// não tem
					}

					// buscar xxx
					$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade' ";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							// tem
							$NomeUnidade = $rowA['NomeUnidade'];
					    }
					} else {
						// não tem
					}

					// buscar xxx
					$sqlA = "SELECT * FROM hora WHERE id_hora = '$id_hora' ";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							// tem
							$Hora = $rowA['Hora'];
					    }
					} else {
						// não tem
					}

					if ($DiaSemana == 2) {
						$NomeDiaSemana = 'Segunda';
					} elseif ($DiaSemana == 3) {
						$NomeDiaSemana = 'Terça';
					} elseif ($DiaSemana == 4) {
						$NomeDiaSemana = 'Quarta';
					} elseif ($DiaSemana == 5) {
						$NomeDiaSemana = 'Quinta';
					} elseif ($DiaSemana == 6) {
						$NomeDiaSemana = 'Sexta';
					} else {

					}


					echo '<tr>';
					echo '<td>'.$NomeDiaSemana.'</td>';
					echo '<td>'.$Hora.'</td>';
					echo '<td>'.$NomeProfissional.'</td>';
					echo '<td>';
					echo '<a href="../agenda/agenda-base-paciente-selecionar-paciente.php?id_paciente='.$id_paciente.'" class="Link">'.$NomePaciente.'</a>';
					echo '</td>';
					echo '<td>'.$NomeProfissionalX.'</td>';
					echo '<td>';
					echo '<a href="../agenda/agenda-base-paciente-selecionar-paciente.php?id_paciente='.$id_pacienteX.'" class="Link">'.$NomePacienteX.'</a>';
					echo '</td>';
					
					// echo '<td>'.$NomeCategoria.'</td>';
					// echo '<td>'.$NomeUnidade.'</td>';
					echo '</tr>';

				} else {
					// diferentes
				}
		    }
		} else {
			// não tem
			
		}
    }
    echo '</tbody>';
	echo '</table>';
} else {
	// não tem
}

?>
</div>
			</div>
		</div>
    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
