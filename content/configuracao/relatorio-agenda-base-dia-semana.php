<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

date_default_timezone_set("America/Sao_Paulo");
$DataAtualX = date("d/m/Y");
$DataAtual = date("Y-m-d");

// conexão com banco
include '../conexao/conexao.php';

// limpar filtro por nome
if (empty($_GET['Limpar'])) {
} else {
	unset($_SESSION['id_hora']);
}

// filtrar por dia da semana
if (isset($_POST['DiaSemana'])) {
	$DiaSemana = $_POST['DiaSemana'];
	$_SESSION['DiaSemana'] = $DiaSemana;
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
	} elseif ($DiaSemana == 7) {
		$NomeDiaSemana = 'Sábado';
	}  else {
		$NomeDiaSemana = NULL;
	}
	$FiltroDiaSemana = 'WHERE agenda_paciente_base.DiaSemana = '.$DiaSemana;
} elseif (isset($_SESSION['DiaSemana'])) {
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
	} elseif ($DiaSemana == 7) {
		$NomeDiaSemana = 'Sábado';
	}  else {
		$NomeDiaSemana = NULL;
	}
	$FiltroDiaSemana = 'WHERE agenda_paciente_base.DiaSemana = '.$DiaSemana;
} else {
	$DiaSemana = 2;
	$_SESSION['DiaSemana'] = 2;
	$NomeDiaSemana = 'Segunda';
	$FiltroDiaSemana = 'WHERE agenda_paciente_base.DiaSemana = 2';
}

// filtrar por hora
if (isset($_POST['id_hora'])) {
	if (empty($_POST['id_hora'])) {
		$id_hora = NULL;
		$Hora = 'Todos';
		$FiltroHora = NULL;
	} else {
		$id_hora = $_POST['id_hora'];
		$_SESSION['id_hora'] = $id_hora;
		// buscar xxx
		$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$Hora = $row['Hora'];
				$FiltroHora = 'AND agenda_paciente_base.id_hora ='.$id_hora;
		    }
		} else {
			// não tem
		}
	}
		
} elseif (isset($_SESSION['id_hora'])) {
	$id_hora = $_SESSION['id_hora'];
	// buscar xxx
	$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$Hora = $row['Hora'];
			$FiltroHora = 'AND agenda_paciente_base.id_hora ='.$id_hora;
	    }
	} else {
		// não tem
	}
} else {
	$id_hora = NULL;
	$Hora = 'Todos';
	$FiltroHora = NULL;
}

// filtrar por unidade
if (isset($_POST['id_unidade'])) {
	if (empty($_POST['id_unidade'])) {
		$id_unidade = NULL;
		$NomeUnidade = 'Todos';
		$FiltroUnidade = NULL;
	} else {
		$id_unidade = $_POST['id_unidade'];
		$_SESSION['id_unidade'] = $id_unidade;
		// buscar xxx
		$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$NomeUnidade = $row['NomeUnidade'];
				$FiltroUnidade = 'AND agenda_paciente_base.id_unidade ='.$id_unidade;
		    }
		} else {
			// não tem
		}
	}
} elseif (isset($_SESSION['id_unidade'])) {
	$id_unidade = $_SESSION['id_unidade'];
	// buscar xxx
	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeUnidade = $row['NomeUnidade'];
			$FiltroUnidade = 'AND agenda_paciente_base.id_unidade ='.$id_unidade;
	    }
	} else {
		// não tem
	}
} else {
	$id_unidade = NULL;
	$NomeUnidade = 'Todos';
	$FiltroUnidade = NULL;
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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Agenda base</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="relatorio-agenda-base.php">Paciente</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-profissional.php">Terapeuta</a></li>
    <li class="active"><a href="relatorio-agenda-base-dia-semana.php">Dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-analise.php">Análise</a></li>
    <li class="inactive"><a href="criar-agenda-da-semana.php">Criar agenda</a></li>
    <li class="inactive"><a href="relatorio-agenda-do-dia.php">Agenda dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-paciente.php">Agenda criança</a></li>
    <li class="inactive"><a href="relatorio-agenda-profissional.php">Agenda terapeuta</a></li>
    <li class="inactive"><a href="ajuda.php">Ajuda</a></li>
</ul>

<div class="janela">
<p>Relatório da agenda base dos pacientes listados por dia da semana.</p>
<li><label>Data do relatório: </label> <?php echo $DataAtualX;?></li>
<form action="" method="post" class="form-inline">
	<label>Filtrar por dia da semana:</label>
	<select class="form-control" name="DiaSemana">
		<option value="<?php echo $DiaSemana;?>"><?php echo $NomeDiaSemana;?></option>
		<option value="2">Segunda</option>
		<option value="3">Terça</option>
		<option value="4">Quarta</option>
		<option value="5">Quinta</option>
		<option value="6">Sexta</option>
		<option value="7">Sábado</option>
	</select>
	<label>Hora:</label>
	<select class="form-control" name="id_hora">
		<option value="<?php echo $id_hora;?>"><?php echo $Hora;?></option>
		<?php
		// buscar xxx
		$sql = "SELECT * FROM hora WHERE Status = 1 ORDER BY Hora ASC";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$id_horaX = $row['id_hora'];
				$HoraX = $row['Hora'];
				echo '<option value="'.$id_horaX.'">'.$HoraX.'</option>';
		    }
		} else {
			// não tem
		}
		?>
		<option value="">Limpar filtro</option>
	</select>
	<label>Unidade:</label>
	<select class="form-control" name="id_unidade">
		<option value="<?php echo $id_unidade;?>"><?php echo $NomeUnidade;?></option>
		<?php
		// buscar xxx
		$sql = "SELECT * FROM unidade ORDER BY NomeUnidade ASC";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$id_unidadeX = $row['id_unidade'];
				$NomeUnidadeX = $row['NomeUnidade'];
				echo '<option value="'.$id_unidadeX.'">'.$NomeUnidadeX.'</option>';
		    }
		} else {
			// não tem
		}
		?>
		<option value="">Limpar filtro</option>
	</select>
	<button type="submit" class="btn btn-success">Pesquisar</button>
	<a href="relatorio-agenda-base-dia-semana.php?Limpar=1" class="btn btn-default">Limpar filtro p/hora</a>
</form>
<br>
<?php
// buscar xxx
$sqlA = "SELECT * FROM agenda_paciente_base $FiltroDiaSemana $FiltroHora $FiltroUnidade ORDER BY id_hora ASC";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Hora</th>';
	echo '<th>Paciente</th>';
	echo '<th>Profissional</th>';
	echo '<th>Categoria</th>';
	echo '<th>Unidade</th>';
	echo '</tr>';
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$id_paciente = $rowA['id_paciente'];
		$id_profissional = $rowA['id_profissional'];
		$id_hora = $rowA['id_hora'];
		$id_categoria = $rowA['id_categoria'];
		$id_unidade = $rowA['id_unidade'];

		// buscar xxx
		$sqlB = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
		$resultB = $conn->query($sqlB);
		if ($resultB->num_rows > 0) {
		    while($rowB = $resultB->fetch_assoc()) {
				// tem
				$NomeCompleto = $rowB['NomeCompleto'];
		    }
		} else {
			// não tem
			$NomeCompleto = NULL;
		}

		// buscar xxx
		$sqlB = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
		$resultB = $conn->query($sqlB);
		if ($resultB->num_rows > 0) {
		    while($rowB = $resultB->fetch_assoc()) {
				// tem
				$NomeCompletoProf = $rowB['NomeCompleto'];
		    }
		} else {
			// não tem
			$NomeCompletoProf = NULL;
		}

		// buscar xxx
		$sqlB = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
		$resultB = $conn->query($sqlB);
		if ($resultB->num_rows > 0) {
		    while($rowB = $resultB->fetch_assoc()) {
				// tem
				$Hora = $rowB['Hora'];
		    }
		} else {
			// não tem
			$Hora = NULL;
		}

		// buscar xxx
		$sqlB = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
		$resultB = $conn->query($sqlB);
		if ($resultB->num_rows > 0) {
		    while($rowB = $resultB->fetch_assoc()) {
				// tem
				$NomeUnidade = $rowB['NomeUnidade'];
		    }
		} else {
			// não tem
			$NomeUnidade = NULL;
		}

		// buscar xxx
		$sqlB = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
		$resultB = $conn->query($sqlB);
		if ($resultB->num_rows > 0) {
		    while($rowB = $resultB->fetch_assoc()) {
				// tem
				$NomeCategoria = $rowB['NomeCategoria'];
		    }
		} else {
			// não tem
			$NomeCategoria = NULL;
		}

		echo '<tr>';
		echo '<td>'.$Hora.'</td>';
		echo '<td>'.$NomeCompleto.'</td>';
		echo '<td>'.$NomeCompletoProf.'</td>';
		echo '<td>'.$NomeCategoria.'</td>';
		echo '<td>'.$NomeUnidade.'</td>';
		echo '</tr>';
    }
    echo '</tbody>';
	echo '</table>';
} else {
	// não tem
	echo '<br>';
	echo 'Não foi encontrado nenhum paciente';
}
?>
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