<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include_once '../conexao/conexao.php';

// data atual
date_default_timezone_set("America/Sao_Paulo");
$DataAtual = date("Y-m-d");
$DataAtualBr = date("d/m/Y", strtotime($DataAtual));

if (empty($_SESSION['DataAgenda'])) {
	$DataAgenda = $DataAtual;
	$_SESSION['DataAgenda'] = $DataAtual;
} else {
	$DataAgenda = $_SESSION['DataAgenda'];
}
$DataAgendaX = date("d/m/Y", strtotime($DataAgenda));
$Data = $DataAgenda;

// verificar se o input dia é segunda
include 'verificar-dia-semana.php';

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
if (isset($_GET['id_paciente'])) {
	$id_paciente = $_GET['id_paciente'];
} elseif (isset($_SESSION['id_paciente'])) {
	$id_paciente = $_SESSION['id_paciente'];
} else {
	$id_paciente = NULL;
}

if (isset($id_paciente)) {
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

if (empty($_SESSION['id_categoria'])) {
	// não tem
	$id_categoria = NULL;
	$NomeCategoria = 'Selecionar';
} else {
	$id_categoria = $_SESSION['id_categoria'];

	// buscar xxx
	$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_categoria = $row['id_categoria'];
			$NomeCategoria = $row['NomeCategoria'];
	    }
	} else {
		// não tem
	}
}

if (empty($_SESSION['id_unidade'])) {
	// não tem
	$id_unidade = NULL;
	$NomeUnidade = 'Selecionar';
} else {
	$id_unidade = $_SESSION['id_unidade'];

	// buscar xxx
	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_unidade = $row['id_unidade'];
			$NomeUnidade = $row['NomeUnidade'];
	    }
	} else {
		// não tem
	}
}

if (empty($_SESSION['id_hora'])) {
	// não tem
	$id_hora = NULL;
	$Hora = 'Selecionar';
} else {
	$id_hora = $_SESSION['id_hora'];

	// buscar xxx
	$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_hora = $row['id_hora'];
			$Hora = $row['Hora'];
	    }
	} else {
		// não tem
	}
}
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include_once '../header/head.php';?>

<style type="text/css">
	.largura-col {
		width: 20%;
	}
	.link-apagar {
		color: orange;
	}
	.link-apagar:hover {
		color: red;
	}
	.info:hover {
		color: orange;
	}
	.cabecalho {
		margin-top: -15px;
	}
	.btn-custom {
		padding: 3px 5px;
    	border-radius: 15px;
	}
</style>

<body>
<div class="wrapper">
    <?php include_once '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include_once '../menu-superior/menu-superior.php';?>

        <div id="" style="padding: 0 25px;">
        	<div class="cabecalho">
        		<h3>Agenda base da criança</h3>
        		<span style="margin-right: 25px;"><label>Nome:</label> <?php echo $NomePaciente;?></span>
        		<span style="margin-right: 25px;"><label>Horários de preferência:</label> <?php echo $PacientePreferencia;?></span>
        		<span class="hidden-print form-group">
					<span data-toggle="tooltip" title="Semana anterior"><a href="alterar-inicio-da-semana-anterior.php?DataAgenda=<?php echo $DataAgenda;?>&id_paciente=<?php echo $id_paciente;?>&id_categoria=<?php echo $id_categoria;?>" class="btn btn-default">&lsaquo;</a></span>
					<span data-toggle="tooltip" title="Próxima semana"><a href="alterar-inicio-da-semana-proximo.php?DataAgenda=<?php echo $DataAgenda;?>&id_paciente=<?php echo $id_paciente;?>&id_categoria=<?php echo $id_categoria;?>" class="btn btn-default">&rsaquo;</a></span>
					<span data-toggle="tooltip" title="Ver dados da criança"><a href="../paciente/paciente.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Dados</a></span>
					<span data-toggle="tooltip" title="Alterar criança e semana"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Filtro</button></span>
					<button onclick="window.print()" class="btn btn-default hidden-print">Imprimir</button>
				</span>
			</div>
			<div class="hidden-print">
				<h4>Agendar terapeuta <a href="" type="button" data-toggle="modal" data-target="#Ajuda" class="Link">&#9432;</a></h4>
				<form action="agenda-base-paciente-agendar-terapeuta-2.php" method="post" class="form-inline" style="margin-bottom: 5px;">
					<div class="form-group">
		            	<label>Dia da semana:</label>
						<input type="" class="form-control" data-toggle="tooltip" title="Dia da semana" name="DataAgenda" value="<?php echo $Data;?>" required>
					</div>
					<div class="form-group">
		            	<label>Horário:</label>
						<select class="form-control" name="id_hora" value="<?php echo $id_hora;?>" required>
							<option value="<?php echo $id_hora;?>"><?php echo $Hora;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM hora ORDER BY Ordem ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_horaX = $row['id_hora'];
									$Hora = $row['Hora'];
									echo '<option value="'.$id_horaX.'">'.$Hora.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Categoria:</label>
						<select class="form-control" name="id_categoriaX" required>
							<option value="<?php echo $id_categoria;?>"><?php echo $NomeCategoria;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_categoriaX = $row['id_categoria'];
									$NomeCategoria = $row['NomeCategoria'];
									echo '<option value="'.$id_categoriaX.'">'.$NomeCategoria.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Unidade</label>
						<select class="form-control" name="id_unidadeX" required>
							<option value="<?php echo $id_unidade;?>"><?php echo $NomeUnidade;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM unidade ORDER BY NomeUnidade ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_unidadeX = $row['id_unidade'];
									$NomeUnidade = $row['NomeUnidade'];
									echo '<option value="'.$id_unidadeX.'">'.$NomeUnidade.'</option>';
							    }
							    echo '<option value="">Limpar filtro</option>';
							} else {
								// não tem
							}
							?>
						</select>
					</div>
					<button type="submit" class="btn btn-success">Confirmar</button>
					<a href="agenda-base-paciente-limpar-filtro.php" class="btn btn-default">Limpar filtro</a>
				</form>
				<form action="agenda-base-paciente-agendar-terapeuta-3.php" method="post" class="form-inline" style="margin-bottom: 5px;">
					<div class="form-group">
						<label>Terapeuta</label>
						<select class="form-control" name="id_profissionalX" required>
							<option value="">Selecionar</option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$PeriodoY = $row['Periodo'];
							    }
							} else {
								// não tem
							}
						
							// buscar xxx
							$sql = "SELECT profissional.* FROM categoria_profissional INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional WHERE categoria_profissional.id_categoria = '$id_categoria' AND categoria_profissional.id_periodo = '$PeriodoY' AND categoria_profissional.id_unidade = '$id_unidade' AND profissional.Status = 1 ORDER BY profissional.NomeCompleto ASC";
							
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_profissionalX = $row['id_profissional'];
									$NomeProfissional = $row['NomeCompleto'];

									// verificar se o profissional está agendado neste horário
									$sqlA = "SELECT * FROM agenda_paciente_base WHERE id_profissional = '$id_profissionalX' AND DiaSemana = '$DiaSemana' AND id_unidade ='$id_unidade' AND id_hora = '$id_hora' AND id_categoria = '$id_categoria'";
									$resultA = $conn->query($sqlA);
									if ($resultA->num_rows > 0) {
									    while($rowA = $resultA->fetch_assoc()) {
											// tem
											echo '<option value="">--- '.$NomeProfissional.' ---</option>';
									    }
									} else {
										// não tem
										echo '<option value="'.$id_profissionalX.'">'.$NomeProfissional.'</option>';
									}
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>
					<button type="submit" class="btn btn-success">Confirmar</button>
					<a href="agenda-base-paciente-ativar-remocao-profissional.php?id_paciente=<?php echo $id_paciente;?>DiaSemana=2&id_categoria=<?php echo $id_categoria;?>" class="btn btn-default" data-toggle="tooltip" title="Ativar / desativar botão para cancelar terapeuta">&#x2715;</a>
				</form>
			</div>
			<?php echo $sqlA;?>

			<!-- profissionais -->
			<div>
				<table class="table table-striped table-hover table-condensed">
				<thead>
				<tr>
				<th>Hora</th>
				<th class="largura-col">Segunda</th>
				<th class="largura-col">Terça</th>
				<th class="largura-col">Quarta</th>
				<th class="largura-col">Quinta</th>
				<th class="largura-col">Sexta</th>
				</tr>
				</thead>
				<tbody>
					<?php
					// buscar xxx
					$sql = "SELECT * FROM hora";
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
							include 'agenda-base-paciente-profissional.php';
							echo '</td>';

							echo '<td>';
							$DiaSemana = 3;
							include 'agenda-base-paciente-profissional.php';
							echo '</td>';

							echo '<td>';
							$DiaSemana = 4;
							include 'agenda-base-paciente-profissional.php';
							echo '</td>';

							echo '<td>';
							$DiaSemana = 5;
							include 'agenda-base-paciente-profissional.php';
							echo '</td>';

							echo '<td>';
							$DiaSemana = 6;
							include 'agenda-base-paciente-profissional.php';
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
<?php include_once '../footer/footer.php';?>

<!-- jquery -->
<?php include_once '../../js/jquery-custom.php';?>
</body>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
</html>
