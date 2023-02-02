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

// input

if (empty($_GET['id_paciente'])) {
	// não tem
	$id_paciente = NULL;
	$NomePaciente = 'Selecionar paciente';
	$FiltroPeriodo = NULL;
	$id_unidade = NULL;
	$id_periodo = NULL;
	$NomePeriodo = NULL;
	$NomeUnidade = NULL;
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
			$id_periodo = $row['id_periodo'];
			$id_unidade = $row['id_unidade'];
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
</style>

<body>
<div class="wrapper">
    <?php include_once '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include_once '../menu-superior/menu-superior.php';?>

        <div id="" style="padding: 0 25px;">
        	<h3>Agenda base do paciente</h3>
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
							<?php
							echo '<a href="cadastrar-atendimento-ativar-remocao-profissional.php?id_paciente='.$id_paciente.'&DiaSemana=2&id_categoria='.$id_categoria.'" class="btn btn-default">Cancelar profissional</a>';
							echo '<a href="cadastrar-atendimento-limpar-filtro.php?id_paciente='.$id_paciente.'&DiaSemana=2" class="btn btn-default">Limpar filtro p/categoria</a>';
							?>
						</div>
					</form>
					<div>
						<span style="margin-right: 25px;"><label>Período:</label> <?php echo $NomePeriodo;?></span>
						<span style="margin-right: 25px;"><label>Unidade:</label> <?php echo $NomeUnidade;?></span>
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
<?php include_once '../footer/footer.php';?>

<!-- jquery -->
<?php include_once '../../js/jquery-custom.php';?>
</body>
</html>
