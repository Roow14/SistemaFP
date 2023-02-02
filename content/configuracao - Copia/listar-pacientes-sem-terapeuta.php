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

<ul class="nav nav-tabs hidden-print">
	<li class="inactive"><a href="relatorio-agenda-base.php">Paciente</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-profissional.php">Terapeuta</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-dia-semana.php">Dia</a></li>
    <li class="active"><a href="relatorio-agenda-base-analise.php">Análise</a></li>
    <li class="inactive"><a href="criar-agenda-da-semana.php">Criar agenda</a></li>
    <li class="inactive"><a href="relatorio-agenda-do-dia.php">Agenda dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-paciente.php">Agenda criança</a></li>
    <li class="inactive"><a href="relatorio-agenda-profissional.php">Agenda terapeuta</a></li>
</ul>

<div class="janela col-sm-12">

<li><label>Data do relatório: </label> <?php echo $DataAtualX;?></li>

<p>Listar pacientes na agenda base e que o campo do terapeuta aparece vazio.</p>
<p class="hidden-print">Apagar os terapeutas vazios: <a href="listar-pacientes-sem-terapeuta-apagar-profissional-2.php" class="btn btn-default">Apagar</a></p>
<?php
// buscar xxx
$sql = "SELECT * FROM agenda_paciente_base";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>id_agenda_base</th>';
	echo '<th>Dia semana</th>';
	echo '<th>Hora</th>';
	echo '<th>Criança</th>';
	echo '<th>Terapeuta</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_agenda_paciente_base = $row['id_agenda_paciente_base'];
		$id_paciente = $row['id_paciente'];
		$id_profissional = $row['id_profissional'];
		$DiaSemana = $row['DiaSemana'];
		$id_hora = $row['id_hora'];

		if ($DiaSemana == 2) {
			$Semana = 'Segunda';
		} elseif ($DiaSemana == 3) {
			$Semana = 'Terça';
		} elseif ($DiaSemana == 4) {
			$Semana = 'Quarta';
		} elseif ($DiaSemana == 5) {
			$Semana = 'Quinta';
		} elseif ($DiaSemana == 6) {
			$Semana = 'Sexta';
		} elseif ($DiaSemana == 7) {
			$Semana = 'Sábado';
		}  else {
			$Semana = NULL;
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
		$sqlA = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeCompleto = $rowA['NomeCompleto'];
		    }
		} else {
			// não tem
		}

		if (empty($id_profissional)) {
			echo '<tr>';
			echo '<td>'.$id_agenda_paciente_base.'</td>';
			echo '<td>'.$Semana.'</td>';
			echo '<td>'.$Hora.'</td>';
			echo '<td>'.$NomeCompleto.'</td>';
			echo '<td></td>';
			echo '</tr>';
		} else {
			// buscar xxx
			$sqlA = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					// $aa = $rowA['aa'];
			    }
			} else {
				// não tem
				echo '<tr>';
				echo '<td>'.$id_agenda_paciente_base.'</td>';
				echo '<td>'.$Semana.'</td>';
				echo '<td>'.$Hora.'</td>';
				echo '<td>'.$NomeCompleto.'</td>';
				echo '<td>'.$id_profissional.'</td>';
				echo '</tr>';
			}
		}
    }
    echo '</tbody>';
	echo '</table>';
} else {
	// não tem
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