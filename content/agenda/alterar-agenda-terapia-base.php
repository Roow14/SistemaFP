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
$id_paciente = $_SESSION['id_paciente'];
$id_agenda_paciente_base = $_GET['id_agenda_paciente_base'];
include '../paciente/dados-paciente.php';

// buscar xxx
$sql = "SELECT * FROM agenda_paciente_base WHERE id_agenda_paciente_base = '$id_agenda_paciente_base'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_profissional = $row['id_profissional'];
		$id_unidade = $row['id_unidade'];
		$id_categoria = $row['id_categoria'];
		$DiaSemana = $row['DiaSemana'];
		$id_hora = $row['id_hora'];

		// buscar xxx
		$sqlA = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$Hora = $rowA['Hora'];
		    }
		} else {
			// não tem
			$Hora = NULL;
		}

		// buscar xxx
		$sqlA = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeCategoria = $rowA['NomeCategoria'];
		    }
		} else {
			// não tem
			$NomeCategoria = NULL;
		}

		// buscar xxx
		$sqlA = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeTerapeuta = $rowA['NomeCompleto'];
		    }
		} else {
			// não tem
			$NomeTerapeuta = NULL;
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
			$NomeUnidade = NULL;
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
			$NomeDiaSemana = NULL;
		}
    }
} else {
	// não tem
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
	input[type=checkbox] {
	    transform: scale(1.3);
        margin: 5px 10px;
	}
	.ajuste-botao {
		float: right;
		/*margin-top: -30px;*/
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Pacientes</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../paciente/">Lista</a></li>
	<li class="inactive"><a href="../paciente/paciente.php">Criança</a></li>
	<li class="inactive"><a href="../paciente/escola-paciente.php">Escola</a></li>
	<li class="inactive"><a href="../paciente/convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Avaliação</a></li>
	<li class="inactive"><a href="../exame/">Dados médicos</a></li>
	<li class="inactive"><a href="../agenda/lista-agenda-paciente.php">Agenda</a></li>
	<li class="active"><a href="../agenda/relatorio-agenda-base-paciente.php">Agenda base</a></li>
</ul>

<div class="janela">
	<li><label>Nome completo:</label> <?php echo $NomeCompleto;?></li>
	<li><label>Horários de preferência:</label> <?php echo $PacientePreferencia;?></li>

	<form action="" method="post" class="form-inline" style="margin-bottom: 5px;">
		<div class="form-group">
        	<label>Dia da semana:</label>
			<select class="form-control" name="DiaSemana" value="<?php echo $DiaSemana;?>" disabled>
				<option value="<?php echo $DiaSemana;?>"><?php echo $NomeDiaSemana;?></option>
				<option value="2">Segunda</option>
				<option value="3">Terça</option>
				<option value="4">Quarta</option>
				<option value="5">Quinta</option>
				<option value="6">Sexta</option>
			</select>
		</div>
		<div class="form-group">
        	<label>Horário:</label>
			<select class="form-control" name="id_hora" value="<?php echo $id_hora;?>" disabled>
				<option value="<?php echo $id_hora;?>"><?php echo $Hora;?></option>
				<?php
				// buscar xxx
				$sql = "SELECT * FROM hora WHERE Status = 1 ORDER BY Ordem ASC ";
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
			<select class="form-control" name="id_categoriaX" disabled>
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
			<select class="form-control" name="id_unidadeX" disabled>
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
	</form>
	<h4>Selecione um terapeuta.</h4>
	<form action="alterar-terapia-base-2.php?id_agenda_paciente_base=<?php echo $id_agenda_paciente_base;?>" method="post" class="form-inline" style="margin-bottom: 5px;">
		<div class="form-group">
			<label>Terapeuta</label>
			<select class="form-control" name="id_profissionalX" required>
				<option value="<?php echo $id_profissional;?>"><?php echo $NomeTerapeuta;?></option>
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
				$sql = "SELECT profissional.* 
				FROM categoria_profissional 
				INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional 
				WHERE categoria_profissional.id_categoria = '$id_categoria' 
				AND categoria_profissional.id_periodo = '$PeriodoY' 
				AND categoria_profissional.id_unidade = '$id_unidade' 
				AND profissional.Status = 1 
				ORDER BY profissional.NomeCompleto ASC";
				
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
	</form>
	<br>
	<a href="" class="btn btn-default" data-toggle="modal" data-target="#apagar">Apagar terapia</a>
</div>

<!-- apagar terapia -->
<div id="apagar" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Apagar terapia da agenda base</h4>
			</div>
			<div class="modal-body">
				<p>Nota: A terapia será removida permanentemente. Deseja continuar?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				<a href="apagar-agenda-terapia-base-2.php?id_agenda_paciente_base=<?php echo $id_agenda_paciente_base;?>" class="btn btn-danger">Apagar</a>
			</div>
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
