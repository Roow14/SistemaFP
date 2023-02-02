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

if (empty($_SESSION['DataAgenda'])) {
	$DataAgenda = $DataAtual;
	$_SESSION['DataAgenda'] = $DataAtual;
} else {
	$DataAgenda = $_SESSION['DataAgenda'];
}

// verificar se o input dia é segunda
include 'verificar-dia-semana.php';

// terça
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
if (empty($_GET['id_profissional'])) {
	// não tem
	$id_profissional = NULL;
	$NomeProfissional = 'Selecionar profissional';
	$FiltroPeriodo = NULL;
} else {
	$id_profissional = $_GET['id_profissional'];
	// buscar xxx
	$sql = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeProfissional = $row['NomeCompleto'];
	    }
	} else {
		// não tem
	}
}

if (empty($_GET['id_periodo'])) {
	// não tem
	$id_periodo = NULL;
	$NomePeriodo = 'Selecionar';
	$FiltroPeriodo = NULL;
} else {
	$id_periodo = $_GET['id_periodo'];

	if ($id_periodo == 10) {
		$FiltroPeriodo = 'WHERE Periodo = 1 OR Periodo = 2' ;
		$NomePeriodo = 'Manhã e tarde';
	} elseif ($id_periodo == 11) {
		$FiltroPeriodo = 'WHERE Periodo = 2 OR Periodo = 3' ;
		$NomePeriodo = 'Tarde e noite';
	} else {
		$FiltroPeriodo = 'WHERE Periodo = '.$id_periodo;
		// buscar xxx
		$sql = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$NomePeriodo = $row['NomePeriodo'];
		    }
		} else {
			// não tem
		}
	}
}

if (empty($_GET['id_unidade'])) {
	// não tem
	$id_unidade = NULL;
	$NomeUnidade = 'Selecionar';
} else {
	$id_unidade = $_GET['id_unidade'];
	// buscar xxx
	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeUnidade = $row['NomeUnidade'];
	    }
	} else {
		// não tem
	}
}
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
	.largura-col {
		width: 20%;
	}
	.largura-col span {
		font-weight: 300;
		font-size: 16px;
	}
	.link-apagar {
		color: orange;
	}
	.link-apagar:hover {
		color: red;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="" style="padding: 0 25px;">
        	<h3>Agenda do profissional</h3>
			<div>

				<!-- cadastro do profissional -->
				<div style="margin-bottom: 15px;">
					<form action="agenda-profissional-2.php" method="post" class="form-inline" style="margin-bottom: 5px;">
						<div class="form-group">
							<label>Nome</label>
							<select class="form-control" name="id_profissionalPesq" required>
								<option value="<?php echo $id_profissional;?>"><?php echo $NomeProfissional;?></option>
								<?php
								// buscar xxx
								$sql = "SELECT * FROM profissional WHERE Status = 1 ORDER BY NomeCompleto ASC ";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    while($row = $result->fetch_assoc()) {
										// tem
										$id_profissionalPesq = $row['id_profissional'];
										$NomeProfissional = $row['NomeCompleto'];
										echo '<option value="'.$id_profissionalPesq.'">'.$NomeProfissional.'</option>';
								    }
								} else {
									// não tem
								}
								?>
							</select>
						</div>

						<div class="form-group">
							<label>Período</label>
							<select class="form-control" name="id_periodoPesq" required>
								<option value="<?php echo $id_periodo;?>"><?php echo $NomePeriodo;?></option>
								<?php
								// buscar xxx
								$sql = "SELECT * FROM periodo ORDER BY Periodo ASC ";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    while($row = $result->fetch_assoc()) {
										// tem
										$id_periodoPesq = $row['id_periodo'];
										$NomePeriodo = $row['NomePeriodo'];
										echo '<option value="'.$id_periodoPesq.'">'.$NomePeriodo.'</option>';
								    }
								    // echo '<option value="90">Manhã e tarde</option>';
									// echo '<option value="91">Tarde e noite</option>';
									// echo '<option value="92">Dia e noite</option>';
								} else {
									// não tem
								}
								?>
							</select>
						</div>

						<div class="form-group">
							<label>Unidade</label>
							<select class="form-control" name="id_unidadePesq" required>
								<option value="<?php echo $id_unidade;?>"><?php echo $NomeUnidade;?></option>
								<?php
								// buscar xxx
								$sql = "SELECT * FROM unidade ORDER BY NomeUnidade ASC ";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    while($row = $result->fetch_assoc()) {
										// tem
										$id_unidadePesq = $row['id_unidade'];
										$NomeUnidade = $row['NomeUnidade'];
										echo '<option value="'.$id_unidadePesq.'">'.$NomeUnidade.'</option>';
								    }
								} else {
									// não tem
								}
								?>
							</select>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-success">Confirmar</button>
							<?php
							echo '<a href="agenda-profissional-ativar-remocao-paciente.php?id_profissional='.$id_profissional.'&id_periodo='.$id_periodo.'&id_unidade='.$id_unidade.'" class="btn btn-default">Cancelar paciente</a>';
							echo '<a href="agenda-profissional-limpar-filtro.php" class="btn btn-default">Limpar filtro</a>';
							?>
						</div>
					</form>
					<form action="alterar-inicio-da-semana.php?id_profissional=<?php echo $id_profissional;?>&id_periodo=<?php echo $id_periodo;?>&id_unidade=<?php echo $id_unidade;?>" method="post" class="form-inline">
		            	<label>Início da semana:</label>
						<input type="date" class="form-control" name="DataAgenda" value="<?php echo $DataAgenda;?>">
						<a href="alterar-inicio-da-semana-anterior.php?DataAgenda=<?php echo $DataAgenda;?>&id_profissional=<?php echo $id_profissional;?>&id_periodo=<?php echo $id_periodo;?>&id_unidade=<?php echo $id_unidade;?>" class="btn btn-default">&lsaquo; Anterior</a>
						<a href="alterar-inicio-da-semana-proximo.php?DataAgenda=<?php echo $DataAgenda;?>&id_profissional=<?php echo $id_profissional;?>&id_periodo=<?php echo $id_periodo;?>&id_unidade=<?php echo $id_unidade;?>" class="btn btn-default">Próxima &rsaquo;</a>
						<button class="btn btn-success">Confirmar</button>
		            </form>
				</div>

				<!-- terapia e profissional -->
				<div>
					<table class="table table-striped table-hover table-condensed">
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
						$sql = "SELECT * FROM hora $FiltroPeriodo";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						    while($row = $result->fetch_assoc()) {
								// tem
								$id_hora = $row['id_hora'];
								$Hora = $row['Hora'];

								echo '<tr>';
								echo '<td>'.$Hora.'</td>';

								echo '<td>';
								$DiaSemana = 2;
								$Data = $Segunda;
								include 'agenda-profissional-paciente.php';
								echo '</td>';

								echo '<td>';
								$DiaSemana = 3;
								$Data = $Terca;
								include 'agenda-profissional-paciente.php';
								echo '</td>';

								echo '<td>';
								$DiaSemana = 4;
								$Data = $Quarta;
								include 'agenda-profissional-paciente.php';
								echo '</td>';

								echo '<td>';
								$DiaSemana = 5;
								$Data = $Quinta;
								include 'agenda-profissional-paciente.php';
								echo '</td>';

								echo '<td>';
								$DiaSemana = 6;
								$Data = $Sexta;
								include 'agenda-profissional-paciente.php';
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
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
