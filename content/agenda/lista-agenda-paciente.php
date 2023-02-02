<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
if (isset($_SESSION['id_paciente'])) {
	$id_paciente = $_SESSION['id_paciente'];
}
if (isset($_GET['id_paciente'])) {
	$id_paciente = $_GET['id_paciente'];
	$_SESSION['id_paciente'] = $id_paciente;
}

include '../paciente/dados-paciente.php';

if ((!empty($_SESSION['DataInicial'])) AND (!empty($_SESSION['DataFinal']))) {
	$DataInicial = $_SESSION['DataInicial'];
	$DataFinal = $_SESSION['DataFinal'];
	$FiltroDatas = 'AND Data BETWEEN "'.$DataInicial.'" AND "'.$DataFinal.'"';
} else {
	$FiltroDatas = NULL;
}
if (!empty($_SESSION['id_categoria'])) {
	$id_categoria = $_SESSION['id_categoria'];
	// buscar xxx
	$sql = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeCategoria = $row['NomeCategoria'];
			$FiltroCategoria = 'AND agenda_paciente.id_categoria = '.$id_categoria;
	    }
	} else {
		// não tem
	}
} else {
	$id_categoria = NULL;
	$NomeCategoria = 'Selecionar';
	$FiltroCategoria = NULL;
}
if (!empty($_SESSION['id_convenio'])) {
	$id_convenio = $_SESSION['id_convenio'];
	// buscar xxx
	$sql = "SELECT * FROM convenio WHERE id_convenio = '$id_convenio'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeConvenio = $row['NomeConvenio'];
			$FiltroConvenio = 'AND agenda_paciente.id_convenio = '.$id_convenio;
	    }
	} else {
		// não tem
	}
} else {
	$id_convenio = NULL;
	$NomeConvenio = 'Selecionar';
	$FiltroConvenio = NULL;
}

if (!empty($_SESSION['OrdemData'])) {
	$OrdemData = 'ORDER BY Data ASC';
	$OrdemDataIcone = '&#129131;';
} else {
	$OrdemData = 'ORDER BY Data DESC';
	$OrdemDataIcone = '&#129129;';
}

$sql = "SELECT COUNT(id_agenda_paciente) AS Soma 
FROM agenda_paciente
WHERE id_paciente = '$id_paciente'
$FiltroDatas $FiltroCategoria $FiltroConvenio
";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// tem
	while($row = $result->fetch_assoc()) {
		$Soma = $row['Soma'];
	}
// não tem
} else {
	$Soma = NULL;
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
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Pacientes</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../paciente/">Lista</a></li>
	<li class="inactive"><a href="../paciente/paciente.php">Criança</a></li>
	<li class="inactive"><a href="../paciente/escola-paciente.php">Escola</a></li>
	<li class="inactive"><a href="../paciente/convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Plano terapêutico</a></li>
	<li class="inactive"><a href="../exame/">Dados médicos</a></li>
	<li class="active"><a href="../agenda/agenda-paciente.php">Agenda</a></li>
	<!-- <li class="inactive"><a href="../agenda/relatorio-agenda-base-paciente.php">Agenda base</a></li> -->
	<li class="inactive"><a href="../agenda/agenda-base-paciente.php">Agenda base</a></li>

</ul>

<div class="janela">
	<li><label>Nome completo:</label> <?php echo $NomeCompleto;?></li>

	<form action="filtro-lista-agenda-paciente-2.php" method="post" class="form-inline">
		<div class="form-group">
			<label>Data de início:</label>
			<input type="date" name="DataInicial" class="form-control" value="<?php echo $DataInicial;?>">
		</div>
		<div class="form-group">
			<label>data final:</label>
			<input type="date" name="DataFinal" class="form-control" value="<?php echo $DataFinal;?>">
		</div>
		<div class="form-group">
			<label>terapia:</label>
			<select class="form-control" name="id_categoria">
				<?php
				echo '<option value="'.$id_categoria.'">'.$NomeCategoria.'</option>';
				// buscar xxx
				$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						// tem
						$id_categoriaX = $row['id_categoria'];
						$NomeCategoriaX = $row['NomeCategoria'];
						echo '<option value="'.$id_categoriaX.'">'.$NomeCategoriaX.'</option>';
				    }
				} else {
					// não tem
				}
				?>
				<option value="">Limpar</option>
			</select>
		</div>
		<div class="form-group">
			<label>convênio:</label>
			<select class="form-control" name="id_convenio">
				<?php
				echo '<option value="'.$id_convenio.'">'.$NomeConvenio.'</option>';
				// buscar xxx
				$sql = "SELECT * FROM convenio WHERE StatusConvenio = 1 ORDER BY NomeConvenio ASC";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						// tem
						$id_convenioX = $row['id_convenio'];
						$NomeConvenioX = $row['NomeConvenio'];
						echo '<option value="'.$id_convenioX.'">'.$NomeConvenioX.'</option>';
				    }
				} else {
					// não tem
				}
				?>
				<option value="">Limpar</option>
			</select>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-success">Confirmar</button>
			<a href="limpar-filtro-lista-agenda-paciente-2.php" class="btn btn-default">Limpar filtro</a>
		</div>
	</form>
	<label>Total:</label> <?php echo $Soma;?>

	<?php
	// buscar xxx
	$sql = "SELECT * FROM agenda_paciente
	WHERE id_paciente = '$id_paciente'
	$FiltroDatas $FiltroCategoria $FiltroConvenio $OrdemData
	";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Data <a href="ordem-data-lista-agenda-paciente-2.php" class="Link">'.$OrdemDataIcone.'</a></th>';
		echo '<th>Hora</th>';
		echo '<th>Terapia</th>';
		echo '<th>Terapeuta</th>';
		echo '<th>Convênio</th>';
		echo '<th>Status convênio</th>';
		echo '<th>Presença</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_agenda_paciente = $row['id_agenda_paciente'];
			$id_paciente = $row['id_paciente'];
			$id_profissional = $row['id_profissional'];
			$id_unidade = $row['id_unidade'];
			$id_categoria = $row['id_categoria'];
			$Data = $row['Data'];
			$DataX = date("d/m/Y", strtotime($Data));
			$id_hora = $row['id_hora'];
			$DiaSemana = $row['DiaSemana'];
			$Convenio = $row['Convenio'];
			$id_convenio = $row['id_convenio'];
			$Presenca = $row['Presenca'];
			$Status = $row['Status'];

			if ($Convenio == 2) {
				$CheckConvenio = 'Validado';
			} else {
				$CheckConvenio = NULL;
			}

			if ($Presenca == 4) {
				$CheckPresenca = 'Outros';
			} elseif ($Presenca == 3) {
				$CheckPresenca = 'Faltou';
			} elseif ($Presenca == 2) {
				$CheckPresenca = 'Realizado';
			} else {
				$CheckPresenca = 'Agendado';
			}

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
			$sqlA = "SELECT * FROM convenio WHERE id_convenio = '$id_convenio'";
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
				$NomeCompleto = NULL;
			}

			echo '<tr>';
			echo '<td>'.$DataX.'</td>';
			echo '<td>'.$Hora.'</td>';
			echo '<td>'.$NomeCategoria.'</td>';
			echo '<td>'.$NomeTerapeuta.'</td>';
			echo '<td>'.$NomeConvenio.'</td>';
			echo '<td>'.$CheckConvenio.'</td>';
			echo '<td>'.$CheckPresenca.'</td>';
			echo '</tr>';
	    }
	    echo '</tbody>';
		echo '</table>';
	} else {
		// não tem
		echo 'Não foi encontrado nenhuma agenda.';
	}
	?>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
