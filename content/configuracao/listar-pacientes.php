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
	unset($_SESSION['NomePaciente']);
}

// pesquisar por nome
if (isset($_POST['NomePaciente'])) {
	$NomePaciente = $_POST['NomePaciente'];
	$_SESSION['NomePaciente'] = $NomePaciente;
	$FiltroNomePaciente = 'AND NomeCompleto LIKE "%'.$NomePaciente.'%"';
} elseif (isset($_SESSION['NomePaciente'])) {
	$NomePaciente = $_SESSION['NomePaciente'];
	$FiltroNomePaciente = 'AND NomeCompleto LIKE "%'.$NomePaciente.'%"';
} else {
	$NomePaciente = NULL;
	$FiltroNomePaciente = NULL;
	unset($_SESSION['NomePaciente']);
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
	} elseif ($Status == 3) {
		$NomeStatus = 'Ativo e inativo';
		$FiltroStatus = 'WHERE (Status = 1 OR Status = 2)';
	} else {
		$Status = NULL;
		$NomeStatus = 'Ativo';
		$FiltroStatus = 'WHERE Status = 1';
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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Pacientes</h2>

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

<form action="" method="post" class="form-inline">
	<label>Filtrar por nome:</label>
	<input type="text" class="form-control" name="NomePaciente" value="<?php echo $NomePaciente;?>" placeholder="Digite o nome">
	<select class="form-control" name="Status">
		<option value="<?php echo $Status;?>"><?php echo $NomeStatus;?></option>
		<option value="1">Ativo</option>
		<option value="2">Inativo</option>
		<option value="3">Ativo e inativo</option>
	</select>
	<button type="submit" class="btn btn-success">Pesquisar</button>
	<a href="listar-pacientes.php?Limpar=1" class="btn btn-default">Limpar filtro</a>
</form>
<br>
<?php
// buscar xxx
$sql = "SELECT * FROM paciente $FiltroStatus $FiltroNomePaciente ORDER BY NomeCompleto ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>ID</th>';
	echo '<th>Nome completo</th>';
	echo '<th>Nome curto</th>';
	echo '<th>Status</th>';
	echo '<th>Agenda Base</th>';
	echo '<th>Agenda</th>';
	echo '<th>Programa FP+</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
		$Status = $row['Status'];

		if ($Status == 1) {
			$NomeStatus = 'Ativo';
		} else {
			$NomeStatus = 'Inativo';
		}

		// verificar se foi usado no programa fp+
		$sqlA = "SELECT * FROM fisiofor_prog.prog_incidental_1 WHERE fisiofor_prog.prog_incidental_1.id_paciente = '$id_paciente' LIMIT 1";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$Checkfp = 'Sim';
		    }
		} else {
			// não tem
			$Checkfp = '-';
		}

		// verificar se foi usado na agenda base
		$sqlA = "SELECT * FROM agenda_paciente_base WHERE id_paciente = '$id_paciente' LIMIT 1";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$Checkagendabase = 'Sim';
		    }
		} else {
			// não tem
			$Checkagendabase = '-';
		}

		// verificar se foi usado na agenda
		$sqlA = "SELECT * FROM agenda_paciente WHERE id_paciente = '$id_paciente' LIMIT 1";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$Checkagenda = 'Sim';
		    }
		} else {
			// não tem
			$Checkagenda = '-';
		}

		echo '<tr>';
		echo '<td>'.$id_paciente.'</td>';
		echo '<td><a href="../paciente/paciente.php?id_paciente='.$id_paciente.'" class="Link">'.$NomeCompleto.'</a></td>';
		echo '<td>'.$NomeCurto.'</td>';
		echo '<td>'.$NomeStatus.'</td>';
		echo '<td>'.$Checkagendabase.'</td>';
		echo '<td>'.$Checkagenda.'</td>';
		echo '<td>'.$Checkfp.'</td>';
		echo '<td></td>';
		echo '</tr>';
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