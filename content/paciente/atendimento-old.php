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

// input
if (empty($_GET['id_paciente'])) {
	// não tem
	$id_paciente = NULL;
	$NomePaciente = 'Selecionar';
} else {
	$id_paciente = $_GET['id_paciente'];

	// buscar xxx
	$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_paciente = $row['id_paciente'];
			$NomePaciente = $row['NomeCompleto'];
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

	// buscar xxx
	$sql = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_periodo = $row['id_periodo'];
			$NomePeriodo = $row['NomePeriodo'];
			$FiltroPeriodo = 'WHERE Periodo ='.$id_periodo;
	    }
	} else {
		// não tem
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
			$id_unidade = $row['id_unidade'];
			$NomeUnidade = $row['NomeUnidade'];
	    }
	} else {
		// não tem
	}
}

if (empty($_GET['id_categoria'])) {
	// não tem
	$id_categoria = NULL;
	$NomeCategoria = 'Selecionar';
} else {
	$id_categoria = $_GET['id_categoria'];

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
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
	.largura-col {
		/*width: 20%;*/
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="" style="padding: 0 25px;">
        	<h3>Cadastrar atendimento</h3>
			<div>

				<!-- cadastro do paciente -->
				<div style="margin-bottom: 25px;">
					<form action="cadastrar-atendimento-selecionar-paciente.php" method="post" class="form-inline" style="margin-bottom: 5px;">
						<div class="form-group">
							<label>Nome</label>
							<select class="form-control" name="id_pacientePesq" required>
								<option value="<?php echo $id_paciente;?>"><?php echo $NomePaciente;?></option>
								<?php
								// buscar xxx
								$sql = "SELECT * FROM paciente WHERE Status = 1 ORDER BY NomeCompleto ASC ";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    while($row = $result->fetch_assoc()) {
										// tem
										$id_pacientePesq = $row['id_paciente'];
										$NomePaciente = $row['NomeCompleto'];
										echo '<option value="'.$id_pacientePesq.'">'.$NomePaciente.'</option>';
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
								$sql = "SELECT * FROM periodo ORDER BY NomePeriodo ASC ";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    while($row = $result->fetch_assoc()) {
										// tem
										$id_periodoPesq = $row['id_periodo'];
										$NomePeriodo = $row['NomePeriodo'];
										echo '<option value="'.$id_periodoPesq.'">'.$NomePeriodo.'</option>';
								    }
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
								$sql = "SELECT * FROM unidade ORDER BY Unidade ASC ";
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
							<label>Categoria</label>
							<select class="form-control" name="id_categoriaPesq">
								<option value="<?php echo $id_categoria;?>"><?php echo $NomeCategoria;?></option>
								<?php
								// buscar xxx
								$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC ";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    while($row = $result->fetch_assoc()) {
										// tem
										$id_categoriaPesq = $row['id_categoria'];
										$NomeCategoria = $row['NomeCategoria'];
										echo '<option value="'.$id_categoriaPesq.'">'.$NomeCategoria.'</option>';
								    }
								    echo '<option value="">Limpar filtro</option>';
								} else {
									// não tem
								}
								?>
							</select>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-success">Confirmar</button>
						</div>
					</form>
					<div>
						<?php
						echo '<a href="cadastrar-atendimento-ativar-remocao-profissional.php?id_paciente='.$id_paciente.'&DiaSemana=2&id_unidade='.$id_unidade.'&id_periodo='.$id_periodo.'&id_categoria='.$id_categoria.'" class="btn btn-default">Apagar profissional</a>';
						echo '<a href="cadastrar-atendimento-limpar-filtro.php?id_paciente='.$id_paciente.'&DiaSemana=2&id_unidade='.$id_unidade.'&id_periodo='.$id_periodo.'" class="btn btn-default">Limpar filtro p/categoria</a>';
						?>
					</div>
				</div>

				<!-- terapia e profissional -->
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
						$sql = "SELECT * FROM hora $FiltroPeriodo ";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						    while($row = $result->fetch_assoc()) {
								// tem
								$id_hora = $row['id_hora'];
								$Hora = $row['Hora'];
								$DiaSemana = 2;

								echo '<tr>';
								echo '<td>'.$Hora.'</td>';

								echo '<td>';
								$DiaSemana = 2;
								include 'cadastrar-atendimento-profissional.php';
								echo '</td>';

								echo '<td>';
								$DiaSemana = 3;
								include 'cadastrar-atendimento-profissional.php';
								echo '</td>';

								echo '<td>';
								$DiaSemana = 4;
								include 'cadastrar-atendimento-profissional.php';
								echo '</td>';

								echo '<td>';
								$DiaSemana = 5;
								include 'cadastrar-atendimento-profissional.php';
								echo '</td>';

								echo '<td>';
								$DiaSemana = 6;
								include 'cadastrar-atendimento-profissional.php';
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
