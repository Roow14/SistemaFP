<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
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
if (isset($_GET['id_profissional'])) {
	$id_profissional = $_GET['id_profissional'];
} elseif (isset($_SESSION['id_profissional'])) {
	$id_profissional = $_SESSION['id_profissional'];
} else {
	$id_profissional = NULL;
}

if (isset($id_profissional)) {
	// buscar xxx
	$sql = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_profissional = $row['id_profissional'];
			$NomeTerapeuta = $row['NomeCompleto'];
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
			// $sqlA = "SELECT * FROM paciente_preferencia WHERE id_paciente = '$id_paciente'";
			// $resultA = $conn->query($sqlA);
			// if ($resultA->num_rows > 0) {
			//     while($rowA = $resultA->fetch_assoc()) {
			// 		// tem
			// 		$PacientePreferencia = $rowA['PacientePreferencia'];
			//     }
			// } else {
			// 	// não tem
			// 	$PacientePreferencia = NULL;
			// }

			// buscar xxx
			// $sqlA = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
			// $resultA = $conn->query($sqlA);
			// if ($resultA->num_rows > 0) {
			//     while($rowA = $resultA->fetch_assoc()) {
			// 		// tem
			// 		$NomePeriodo = $rowA['NomePeriodo'];
			// 		$FiltroPeriodo = 'WHERE Periodo ='.$id_periodo;
			//     }
			// } else {
			// 	// não tem
			// 	// mensagem de alerta
			// 	echo "<script type=\"text/javascript\">
			// 	    alert(\"Erro: cadastrar o período de atendimento.\");
			// 	    window.location = \"../paciente/paciente.php?id_paciente=$id_paciente\"
			// 	    </script>";
			// 	exit;
			// }
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
				// echo "<script type=\"text/javascript\">
				//     alert(\"Erro: cadastrar a unidade de atendimento.\");
				//     window.location = \"../paciente/paciente.php?id_paciente=$id_paciente\"
				//     </script>";
				// exit;
			}
	    }
	} else {
		// não tem
	}
} else {
	// não tem
	$id_profissional = NULL;
	$NomeTerapeuta = 'Selecionar';
	$FiltroPeriodo = NULL;
	$id_unidade = NULL;
	$id_periodo = NULL;
	$NomePeriodo = NULL;
	$NomeUnidade = NULL;
	// $PacientePreferencia = NULL;
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
	$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora' AND Status = 1";
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

if (empty($_SESSION['DiaSemana'])) {
	$DiaSemana = NULL;
	$NomeDiaSemana = 'Selecionar';
} else {
	$DiaSemana = $_SESSION['DiaSemana'];
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
		$NomeDiaSemana = NULL;
	}
}
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
	.btn-custom {
		padding: 6px 8px;
		border-radius: 50%;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-profissional.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">
        	
<h2>Terapeuta</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../profissional/listar-profissionais.php">Lista</a></li>
	<li class="inactive"><a href="../profissional/profissional.php?id_profissional=<?php echo $id_profissional;?>">Terapeuta</a></li>
	<li class="inactive"><a href="../agenda/agenda-profissional.php?id_profissional=<?php echo $id_profissional;?>">Agenda</a></li>
	<li class="active"><a href="../agenda/agenda-base-profissional.php?id_profissional=<?php echo $id_profissional;?>">Agenda base</a></li>
</ul>

<div class="janela">
	<div>
		<span style="margin-right: 25px;"><label>Nome:</label> <?php echo $NomeTerapeuta;?></span>
		<!-- <span style="margin-right: 25px;"><label>Horários de preferência:</label> <?php echo $PacientePreferencia;?></span> -->
		<span class="hidden-print form-group">
			<a href="agenda-base-profissional-ativar-remocao-paciente.php?id_profissional=<?php echo $id_profissional;?>" class="btn btn-default" data-toggle="tooltip" title="Ativar / desativar botão para cancelar criança">Remover</a>
			<button onclick="window.print()" class="btn btn-default hidden-print">Imprimir</button>
		</span>
	</div>

	<!-- terapeutas -->
	<div style="margin-top: 15px;">
		<table class="table table-striped table-hover table-condensed table-bordered">
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
						include 'agenda-base-profissional-paciente.php';
						echo '</td>';

						echo '<td>';
						$DiaSemana = 3;
						include 'agenda-base-profissional-paciente.php';
						echo '</td>';

						echo '<td>';
						$DiaSemana = 4;
						include 'agenda-base-profissional-paciente.php';
						echo '</td>';

						echo '<td>';
						$DiaSemana = 5;
						include 'agenda-base-profissional-paciente.php';
						echo '</td>';

						echo '<td>';
						$DiaSemana = 6;
						include 'agenda-base-profissional-paciente.php';
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

<!-- ajuda -->
<div id="Ajuda" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Agendar terapeuta</h4>
			</div>
			<div class="modal-body">
				<p>Primeiramente, verfique se existe um terapeuta agendado no horário desejado. Se existir, clique no botão "X" e cancele o terapeuta.</p>
				<p>Em seguida selecione o dia da semana, hora, categoria, unidade e clique em confirmar.</p>
	            <p>Para finalizar, selecione o terapeuta e clique em confirmar.</p>
	            <p><b>Notas:</b></p>
	            <p>No <b>campo terapeuta</b> aparecerão somente os terapeutas que preenchem os requisitos do filtro aplicado: dia da semana, categoria e unidade.<br>
	            O sinal --- indica que o terapeuta já tem uma agenda para este horário.</p>
	            <p><b>Limpar filtro</b>: remove os filtros de dia da semana, categoria e unidade.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

<!-- filtro -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Ver agenda base de outro terapeuta</h4>
			</div>
			<form action="agenda-base-profissional-selecionar-terapeuta.php" method="post" class="form-inline" style="margin-bottom: 15px;">
				<div class="modal-body">
	            	<!-- filtros -->
					<div class="form-group">
						<label>Nome</label>
						<select class="form-control" name="id_profissional" required>
							<option value="<?php echo $id_profissional;?>"><?php echo $NomeTerapeuta;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM profissional WHERE Status = 1 ORDER BY NomeCompleto ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_profissionalX = $row['id_profissional'];
									$NomeTerapeutaX = $row['NomeCompleto'];
									echo '<option value="'.$id_profissionalX.'">'.$NomeTerapeutaX.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Confirmar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- alterar dados -->
<div id="Alterar" class="modal " role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<form action="" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Agendar terapeuta</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
		            	<label>Data:</label>
						<input type="date" class="form-control" name="DataAgenda">
					</div>
					<div class="form-group">
		            	<label>Horário:</label>
						<select class="form-control" name="id_hora" required>
							<option value="">Selecionar</option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM hora ORDER BY Ordem ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_hora = $row['id_hora'];
									$Hora = $row['Hora'];
									echo '<option value="'.$id_hora.'">'.$Hora.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Categoria:</label>
						<select class="form-control" name="id_categoriaX" data-toggle="tooltip" title="Selecione uma categoria e ative o campo de seleção do profissional." required>
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
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Confirmar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- alterar dados -->
<div id="AgendarTerapeuta" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<form action="agendar-terapeuta.php" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Agendar terapeuta - passo 2</h4>
				</div>
				<div class="modal-body">
	            	<label>Data:</label>
					<input type="date" class="form-control" name="DataAgenda">
				</div>
				<div class="modal-body">
	            	<label>Horário:</label>
					<select class="form-control" name="id_hora" required>
						<option value="">Selecionar</option>
						<?php
						// buscar xxx
						$sql = "SELECT * FROM hora ORDER BY Ordem ASC ";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
						    while($row = $result->fetch_assoc()) {
								// tem
								$id_hora = $row['id_hora'];
								$Hora = $row['Hora'];
								echo '<option value="'.$id_hora.'">'.$Hora.'</option>';
						    }
						} else {
							// não tem
						}
						?>
					</select>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Confirmar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
</body>
</html>
