<?php
	if (!isset($_SESSION)) session_start();
	$nivel_necessario = 2;
	if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
	session_destroy();
	header("Location: ../../index.html"); exit;
	}

	// conexão com banco
	include '../conexao/conexao.php';

	// data atual
	date_default_timezone_set("America/Sao_Paulo");
	$DataAtual = date("Y-m-d");
	$DataAtualBr = date("d/m/Y", strtotime($DataAtual));

	// input
	if (isset($_POST['DataAgenda'])) {
		$DataAgenda = $_POST['DataAgenda'];
		$_SESSION['DataAgenda'] = $DataAgenda;
	} elseif (isset($_SESSION['DataAgenda'])) {
		$DataAgenda = $_SESSION['DataAgenda'];
	} else {
		$_SESSION['DataAgenda'] = $DataAtual;
		$DataAgenda = $DataAtual;
	}
	$DataAgendaX = date("d/m/Y", strtotime($DataAgenda));
	$Data = $DataAgenda;

	// verificar se o input dia é segunda
	include '../agenda/verificar-dia-semana.php';

	// segunda
	$date = date_create($DataAgenda);
	$Segunda = date_format($date,"Y-m-d");
	$SegundaBr = date("d/m/Y", strtotime($Segunda));

	// terça
	$date = date_create($DataAgenda);
	date_add($date,date_interval_create_from_date_string("1 day"));
	$Terca = date_format($date,"Y-m-d");
	$TercaBr = date("d/m/Y", strtotime($Terca));

	// quarta
	$date = date_create($DataAgenda);
	date_add($date,date_interval_create_from_date_string("2 day"));
	$Quarta = date_format($date,"Y-m-d");
	$QuartaBr = date("d/m/Y", strtotime($Quarta));

	// quinta
	$date = date_create($DataAgenda);
	date_add($date,date_interval_create_from_date_string("3 day"));
	$Quinta = date_format($date,"Y-m-d");
	$QuintaBr = date("d/m/Y", strtotime($Quinta));

	// sexta
	$date = date_create($DataAgenda);
	date_add($date,date_interval_create_from_date_string("4 day"));
	$Sexta = date_format($date,"Y-m-d");
	$SextaBr = date("d/m/Y", strtotime($Sexta));

	// input
	if (isset($_POST['id_paciente'])) {
		$id_paciente = $_POST['id_paciente'];
		$_SESSION['id_paciente'] = $_POST['id_paciente'];

		// buscar xxx
		$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$id_paciente = $row['id_paciente'];
				$NomePaciente = $row['NomeCompleto'];
				$id_periodo = $row['id_periodo'];
				$id_unidade = $row['id_unidade'];

				if ($id_periodo == 10) {
					$FiltroPeriodo = 'WHERE Periodo = 1 OR Periodo = 2';
				} elseif ($id_periodo == 11) {
					$FiltroPeriodo = 'WHERE Periodo = 2 OR Periodo = 3';
				} else {
					$FiltroPeriodo = 'WHERE Periodo ='.$id_periodo;
				}

				// buscar xxx
				$sqlA = "SELECT * FROM paciente_preferencia WHERE id_paciente = '$id_paciente'";
				$resultA = $conn->query($sqlA);
				if ($resultA->num_rows > 0) {
				    while($rowA = $resultA->fetch_assoc()) {
						// tem
						$PacientePreferencia = $rowA['PacientePreferencia'];
				    }
				} else {
					// não tem
					$PacientePreferencia = NULL;
				}

				// buscar xxx
				$sqlA = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
				$resultA = $conn->query($sqlA);
				if ($resultA->num_rows > 0) {
				    while($rowA = $resultA->fetch_assoc()) {
						// tem
						$NomePeriodo = $rowA['NomePeriodo'];
						$FiltroPeriodo = 'WHERE Periodo ='.$id_periodo;
				    }
				} else {
					// não tem
					// mensagem de alerta
					echo "<script type=\"text/javascript\">
					    alert(\"Erro: cadastrar o período de atendimento.\");
					    window.location = \"../paciente/paciente.php?id_paciente=$id_paciente\"
					    </script>";
					exit;
				}
				// buscar xxx
				$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
				$resultA = $conn->query($sqlA);
				if ($resultA->num_rows > 0) {
				    while($rowA = $resultA->fetch_assoc()) {
						// tem
						$NomeUnidade = $rowA['NomeUnidade'];
				    }
				} else {
					// não tem
					// mensagem de alerta
					echo "<script type=\"text/javascript\">
					    alert(\"Erro: cadastrar a unidade de atendimento.\");
					    window.location = \"../paciente/paciente.php?id_paciente=$id_paciente\"
					    </script>";
					exit;
				}
		    }
		} else {
			// não tem
		}
	} elseif (isset($_GET['id_paciente'])) {
		$id_paciente = $_GET['id_paciente'];
		$_SESSION['id_paciente'] = $_GET['id_paciente'];

		// buscar xxx
		$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$id_paciente = $row['id_paciente'];
				$NomePaciente = $row['NomeCompleto'];
				$id_periodo = $row['id_periodo'];
				$id_unidade = $row['id_unidade'];

				if ($id_periodo == 10) {
					$FiltroPeriodo = 'WHERE Periodo = 1 OR Periodo = 2';
				} elseif ($id_periodo == 11) {
					$FiltroPeriodo = 'WHERE Periodo = 2 OR Periodo = 3';
				} else {
					$FiltroPeriodo = 'WHERE Periodo ='.$id_periodo;
				}

				// buscar xxx
				$sqlA = "SELECT * FROM paciente_preferencia WHERE id_paciente = '$id_paciente'";
				$resultA = $conn->query($sqlA);
				if ($resultA->num_rows > 0) {
				    while($rowA = $resultA->fetch_assoc()) {
						// tem
						$PacientePreferencia = $rowA['PacientePreferencia'];
				    }
				} else {
					// não tem
					$PacientePreferencia = NULL;
				}

				// buscar xxx
				$sqlA = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
				$resultA = $conn->query($sqlA);
				if ($resultA->num_rows > 0) {
				    while($rowA = $resultA->fetch_assoc()) {
						// tem
						$NomePeriodo = $rowA['NomePeriodo'];
						$FiltroPeriodo = 'WHERE Periodo ='.$id_periodo;
				    }
				} else {
					// não tem
					// mensagem de alerta
					echo "<script type=\"text/javascript\">
					    alert(\"Erro: cadastrar o período de atendimento.\");
					    window.location = \"../paciente/paciente.php?id_paciente=$id_paciente\"
					    </script>";
					exit;
				}
				// buscar xxx
				$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
				$resultA = $conn->query($sqlA);
				if ($resultA->num_rows > 0) {
				    while($rowA = $resultA->fetch_assoc()) {
						// tem
						$NomeUnidade = $rowA['NomeUnidade'];
				    }
				} else {
					// não tem
					// mensagem de alerta
					echo "<script type=\"text/javascript\">
					    alert(\"Erro: cadastrar a unidade de atendimento.\");
					    window.location = \"../paciente/paciente.php?id_paciente=$id_paciente\"
					    </script>";
					exit;
				}
		    }
		} else {
			// não tem
		}
	} elseif (isset($_SESSION['id_paciente'])) {
		$id_paciente = $_SESSION['id_paciente'];

		// buscar xxx
		$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$id_paciente = $row['id_paciente'];
				$NomePaciente = $row['NomeCompleto'];
				$id_periodo = $row['id_periodo'];
				$id_unidade = $row['id_unidade'];

				if ($id_periodo == 10) {
					$FiltroPeriodo = 'WHERE Periodo = 1 OR Periodo = 2';
				} elseif ($id_periodo == 11) {
					$FiltroPeriodo = 'WHERE Periodo = 2 OR Periodo = 3';
				} else {
					$FiltroPeriodo = 'WHERE Periodo ='.$id_periodo;
				}

				// buscar xxx
				$sqlA = "SELECT * FROM paciente_preferencia WHERE id_paciente = '$id_paciente'";
				$resultA = $conn->query($sqlA);
				if ($resultA->num_rows > 0) {
				    while($rowA = $resultA->fetch_assoc()) {
						// tem
						$PacientePreferencia = $rowA['PacientePreferencia'];
				    }
				} else {
					// não tem
					$PacientePreferencia = NULL;
				}

				// buscar xxx
				$sqlA = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
				$resultA = $conn->query($sqlA);
				if ($resultA->num_rows > 0) {
				    while($rowA = $resultA->fetch_assoc()) {
						// tem
						$NomePeriodo = $rowA['NomePeriodo'];
						$FiltroPeriodo = 'WHERE Periodo ='.$id_periodo;
				    }
				} else {
					// não tem
					// mensagem de alerta
					echo "<script type=\"text/javascript\">
					    alert(\"Erro: cadastrar o período de atendimento.\");
					    window.location = \"../paciente/paciente.php?id_paciente=$id_paciente\"
					    </script>";
					exit;
				}
				// buscar xxx
				$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
				$resultA = $conn->query($sqlA);
				if ($resultA->num_rows > 0) {
				    while($rowA = $resultA->fetch_assoc()) {
						// tem
						$NomeUnidade = $rowA['NomeUnidade'];
				    }
				} else {
					// não tem
					// mensagem de alerta
					echo "<script type=\"text/javascript\">
					    alert(\"Erro: cadastrar a unidade de atendimento.\");
					    window.location = \"../paciente/paciente.php?id_paciente=$id_paciente\"
					    </script>";
					exit;
				}
		    }
		} else {
			// não tem
		}
	} else {
		// não tem
		$id_paciente = NULL;
		$NomePaciente = 'Selecionar paciente';
		$FiltroPeriodo = NULL;
		$id_unidade = NULL;
		$id_periodo = NULL;
		$NomePeriodo = NULL;
		$NomeUnidade = NULL;
		$PacientePreferencia = NULL;
	}

	// print_r($_SESSION); 
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
	.janela {
	    background-color: #fafafa;
	    /*min-height: 300px;*/
	    padding: 15px;
	    border-left: 1px solid #ddd;
	    border-right: 1px solid #ddd;
	    border-bottom: 1px solid #ddd;
	    border-radius: 4px;
	}
	.conteudo {

	}
	li {
		list-style: none;
	}
	.Link {
		background-color: transparent;
		border: none;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Agenda da criança</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="relatorio-agenda-base.php">Paciente</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-profissional.php">Terapeuta</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-dia-semana.php">Dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-analise.php">Análise</a></li>
    <li class="inactive"><a href="criar-agenda-da-semana.php">Criar agenda</a></li>
    <li class="inactive"><a href="relatorio-agenda-do-dia.php">Agenda dia</a></li>
    <li class="active"><a href="relatorio-agenda-paciente.php">Agenda criança</a></li>
    <li class="inactive"><a href="relatorio-agenda-profissional.php">Agenda terapeuta</a></li>
</ul>

<div class="janela">
	<form action="" method="post" class="form-inline" style="margin-bottom: 15px;">
		<label>Filtrar por criança:</label>
		<select class="form-control" name="id_paciente">
			<option value="<?php echo $id_paciente;?>"><?php echo $NomePaciente;?></option>
			<?php
			$sql = "SELECT * FROM paciente WHERE Status = 1 ORDER BY NomeCompleto ASC";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					// tem
					$id_pacienteX = $row['id_paciente'];
					$NomePacienteX = $row['NomeCompleto'];
					echo '<option value="'.$id_pacienteX.'">'.$NomePacienteX.'</option>';
			    }
			} else {
				// não tem
			}
			?>
		</select>
		<label>data:</label>
		<input type="date" class="form-control" data-toggle="tooltip" title="Dia da semana" name="DataAgenda" value="<?php echo $Data;?>" required>
		<button type="submit" class="btn btn-success">Confirmar</button>
	</form>

	<!-- terapeutas -->
	<table class="table table-striped table-hover table-condensed table-bordered">
	<thead>
	<tr>
	<th>Hora</th>
	<th class="largura-col">Segunda <span><?php echo $SegundaBr;?></span></th>
	<th class="largura-col">Terça <span><?php echo $TercaBr;?></span></th>
	<th class="largura-col">Quarta <span><?php echo $QuartaBr;?></span></th>
	<th class="largura-col">Quinta <span><?php echo $QuintaBr;?></span></th>
	<th class="largura-col">Sexta <span><?php echo $SextaBr;?></span></th>
	</tr>
	</thead>
	<tbody>
		<?php
		// buscar xxx
		$sql = "SELECT * FROM hora WHERE Status = 1";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$id_hora = $row['id_hora'];
				$Hora = $row['Hora'];
				$Periodo = $row['Periodo'];

				echo '<tr>';
				echo '<td>'.$Hora.'</td>';

				echo '<td>';
				$DiaSemana = 2;
				$Data = $Segunda;
				include 'agenda-paciente-profissional.php';
				echo '</td>';

				echo '<td>';
				$DiaSemana = 3;
				$Data = $Terca;
				include 'agenda-paciente-profissional.php';
				echo '</td>';

				echo '<td>';
				$DiaSemana = 4;
				$Data = $Quarta;
				include 'agenda-paciente-profissional.php';
				echo '</td>';

				echo '<td>';
				$DiaSemana = 5;
				$Data = $Quinta;
				include 'agenda-paciente-profissional.php';
				echo '</td>';

				echo '<td>';
				$DiaSemana = 6;
				$Data = $Sexta;
				include 'agenda-paciente-profissional.php';
				echo '</td>';

				echo '</tr>';
		    }
		} else {
			// não tem
		}
		?>
	</tbody>
	</table>
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