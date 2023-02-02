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
$id_paciente = $_SESSION['id_paciente'];

if (isset($_GET['Data'])) {
	$_SESSION['Data'] = $_GET['Data'];
} elseif (isset($_POST['Data'])) {
	$_SESSION['Data'] = $_POST['Data'];
} else {
	$Data = $_SESSION['Data'];
}

if (isset($_GET['id_hora'])) {
	$_SESSION['id_hora'] = $_GET['id_hora'];
} elseif (isset($_POST['id_hora'])) {
	$_SESSION['id_hora'] = $_POST['id_hora'];
} else {
	$id_hora = $_SESSION['id_hora'];
}

// buscar xxx
$sql = "SELECT paciente.NomeCompleto
FROM paciente
WHERE paciente.id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$NomePaciente = $row['NomeCompleto'];
    }
} else {
	// não tem
}

$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$Hora = $row['Hora'];
    }
} else {
	// não tem
}

if (isset($_POST['id_categoria'])) {
	$id_categoria = $_POST['id_categoria'];
	$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeCategoria = $row['NomeCategoria'];
	    }
	} else {
		// não tem
		$NomeCategoria = 'Selecionar';
	}
} else {
	$id_categoria = NULL;
	$NomeCategoria = NULL;
}
	
if (isset($_POST['id_unidade'])) {
	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeUnidade = $row['NomeUnidade'];
	    }
	} else {
		// não tem
		$NomeUnidade = 'Selecionar';
	}
} else {
	$id_unidade = NULL;
	$NomeUnidade = NULL;
}

if (isset($_POST['id_profissional'])) {
	$sql = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeProfissional = $row['NomeProfissional'];
	    }
	} else {
		// não tem
		$NomeProfissional = 'Selecionar';
	}
} else {
	$id_profissional = NULL;
	$NomeProfissional = NULL;
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
	td:hover {
		background-color: #fcf8e3;
		transition: all ease 0.3s;
    	cursor: pointer;
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
	<form action="" method="post" class="" style="margin-bottom: 15px;">
		<div class="row">
			<div class="form-group col-sm-6">
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
			</div>

			<div class="form-group col-sm-3">
				<label>data:</label>
				<input type="date" class="form-control" data-toggle="tooltip" title="Dia da semana" name="DataAgenda" value="<?php echo $Data;?>" required>
			</div>

			<div class="form-group col-sm-3">
	        	<label>Horário:</label>
				<select class="form-control" name="id_hora" value="<?php echo $id_hora;?>" required>
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
			<div class="form-group col-sm-6">
				<label>Categoria:</label>
				<select class="form-control" name="id_categoriaX">
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
			<div class="form-group col-sm-6">
				<label>Unidade</label>
				<select class="form-control" name="id_unidadeX">
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
			<div class="col-sm-12">
				<button type="submit" class="btn btn-success">Confirmar etapa 1</button>
			</div>
		</div>
	</form>
	<form action="agenda-paciente-agendar-terapeuta-3.php" method="post" class="form-inline" style="margin-bottom: 5px;">
		<div class="form-group">
			<label>Terapeuta</label>
			<select class="form-control" name="id_profissionalX" required>
				<option value="<?php echo $id_profissional;?>"><?php echo $NomeProfissional;?></option>
				<?php
				// buscar xxx
				$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora' AND Status = 1";
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
						$NomeProfissionalX = $row['NomeCompleto'];

						// verificar se o profissional está agendado neste horário
						$sqlA = "SELECT * FROM agenda_paciente WHERE id_profissional = '$id_profissionalX' AND Data = '$Data' AND id_unidade ='$id_unidade' AND id_hora = '$id_hora' AND id_categoria = '$id_categoria'";
						$resultA = $conn->query($sqlA);
						if ($resultA->num_rows > 0) {
						    while($rowA = $resultA->fetch_assoc()) {
								// tem
								echo '<option value="">--- '.$NomeProfissionalX.' ---</option>';
						    }
						} else {
							// não tem
							echo '<option value="'.$id_profissionalX.'">'.$NomeProfissionalX.'</option>';
						}
				    }
				} else {
					// não tem
				}
				?>
			</select>
		</div>
		<input type="text" hidden name="id_categoria" value="<?php echo $id_categoria;?>">
		<input type="text" hidden name="id_unidade" value="<?php echo $id_unidade;?>">
		<input type="text" hidden name="id_hora" value="<?php echo $id_hora;?>">
		<input type="text" hidden name="id_agenda_paciente" value="<?php echo $id_agenda_paciente;?>">

		<button type="submit" class="btn btn-success">Confirmar etapa 2</button>
	</form>
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