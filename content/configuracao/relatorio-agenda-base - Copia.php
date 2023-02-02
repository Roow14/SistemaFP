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
	unset($_SESSION['Paciente']);
}

// pesquisar por nome
if (isset($_POST['Paciente'])) {
	$Paciente = $_POST['Paciente'];
	$_SESSION['Paciente'] = $Paciente;
	$FiltroPaciente = 'AND NomeCompleto LIKE "%'.$Paciente.'%"';
} elseif (isset($_SESSION['Paciente'])) {
	$Paciente = $_SESSION['Paciente'];
	$FiltroPaciente = 'AND NomeCompleto LIKE "%'.$Paciente.'%"';
} else {
	$Paciente = NULL;
	$FiltroPaciente = NULL;
	unset($_SESSION['Paciente']);
}

// filtrar por status
if (empty($_POST['Status'])) {
	$Status = NULL;
	$NomeStatus = 'Ativo';
	$FiltroStatus = 'WHERE Status = 1';
} else {
	$Status = $_POST['Status'];
	if ($Status == 1) {
		$NomeStatus = 'Ativo';
		$FiltroStatus = 'WHERE Status = '.$Status;
	} elseif ($Status == 2) {
		$NomeStatus = 'Inativo';
		$FiltroStatus = 'WHERE Status = '.$Status;
	} else {
		$NomeStatus = 'Ativo e inativo';
		$FiltroStatus = 'WHERE (Status = 1 OR Status = 2)';
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
	<li class="active"><a href="relatorio-agenda-base.php">Paciente</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-profissional.php">Terapeuta</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-dia-semana.php">Dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-analise.php">Análise</a></li>
    <li class="inactive"><a href="criar-agenda-da-semana.php">Criar agenda</a></li>
    <li class="inactive"><a href="relatorio-agenda-do-dia.php">Agenda dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-paciente.php">Agenda criança</a></li>
    <li class="inactive"><a href="relatorio-agenda-profissional.php">Agenda terapeuta</a></li>
</ul>

<div class="janela">
<p>Relatório das agendas base dos pacientes.</p>
<li><label>Data do relatório: </label> <?php echo $DataAtualX;?></li>
<form action="" method="post" class="form-inline">
	<label>Filtrar por paciente:</label>
	<input type="text" class="form-control" name="Paciente" value="<?php echo $Paciente;?>" placeholder="Digite o nome">
	<select class="form-control" name="Status">
		<option value="<?php echo $Status;?>"><?php echo $NomeStatus;?></option>
		<option value="1">Ativo</option>
		<option value="2">Inativo</option>
		<option value="">Ativo e inativo</option>
	</select>
	<button type="submit" class="btn btn-success">Pesquisar</button>
	<a href="relatorio-agenda-base.php?Limpar=1" class="btn btn-default">Limpar filtro</a>
</form>
<br>
<?php
// buscar xxx
$sql = "SELECT * FROM paciente $FiltroStatus $FiltroPaciente";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$NomeCompleto = $row['NomeCompleto'];
		$Status = $row['Status'];
		if ($Status == 1) {
			$NomeStatus = 'Ativo';
		} else {
			$NomeStatus = 'Inativo';
		}
		echo '<label>Nome do paciente:</label> '.$NomeCompleto.'<br>';
		echo '<label>Status:</label> '.$NomeStatus;
		echo '<br>';
		// buscar xxx
		$sqlA = "SELECT * FROM agenda_paciente_base WHERE id_paciente = '$id_paciente'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
			echo '<table class="table table-striped table-hover table-condensed">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Dia da semana</th>';
			echo '<th>Hora</th>';
			echo '<th>Terapeuta</th>';
			echo '<th>Categoria</th>';
			echo '<th>Unidade</th>';
			echo '<th>ID</th>';
			echo '</tr>';
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_agenda_paciente_base = $rowA['id_agenda_paciente_base'];
				$id_profissional = $rowA['id_profissional'];
				$DiaSemana = $rowA['DiaSemana'];
				$id_hora = $rowA['id_hora'];
				$id_categoria = $rowA['id_categoria'];
				$id_unidade = $rowA['id_unidade'];

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
				echo '<td>'.$Semana.'</td>';
				echo '<td>'.$Hora.'</td>';
				echo '<td>'.$NomeCompletoProf.'</td>';
				echo '<td>'.$NomeCategoria.'</td>';
				echo '<td>'.$NomeUnidade.'</td>';
				echo '<td>'.$id_agenda_paciente_base.'</td>';
				echo '</tr>';
		    }
		    echo '</tbody>';
			echo '</table>';
		} else {
			// não tem
			echo 'Sem agenda';
			echo '<br>';
		}
		echo '<br>';
    }
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