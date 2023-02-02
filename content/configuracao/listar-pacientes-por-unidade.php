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

// filtrar por unidade
if (isset($_POST['id_unidade'])) {
	if (empty($_POST['id_unidade'])) {
		$id_unidade = NULL;
		$NomeUnidade = 'Não definido';
		$FiltroUnidade = 'AND paciente.id_unidade is NULL';
	} elseif ($_POST['id_unidade'] == 99) {
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
				$FiltroUnidade = 'AND paciente.id_unidade ='.$id_unidade;
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
			$FiltroUnidade = 'AND paciente.id_unidade ='.$id_unidade;
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

<h2>Análise</h2>

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
<h3>Pacientes por unidade</h3>
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
		<option value="">Não definido</option>
		<option value="99">Limpar filtro</option>
	</select>
	<button type="submit" class="btn btn-success">Pesquisar</button>
	<a href="listar-pacientes.php?Limpar=1" class="btn btn-default">Limpar filtro</a>
</form>
<br>
<?php
// buscar xxx
$sql = "SELECT * FROM paciente $FiltroStatus $FiltroNomePaciente $FiltroUnidade ORDER BY NomeCompleto ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>ID</th>';
	echo '<th>Nome completo</th>';
	echo '<th>Nome curto</th>';
	echo '<th>Status</th>';
	echo '<th>Unidade</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
		$Status = $row['Status'];
		
		$id_unidadeY = $row['id_unidade'];
		// buscar xxx
		$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidadeY'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeUnidadeY = $rowA['NomeUnidade'];
		    }
		} else {
			// não tem
			$NomeUnidadeY = NULL;
		}

		if ($Status == 1) {
			$NomeStatus = 'Ativo';
		} else {
			$NomeStatus = 'Inativo';
		}

		
		echo '<tr>';
		echo '<td>'.$id_paciente.'</td>';
		echo '<td><a href="../paciente/paciente.php?id_paciente='.$id_paciente.'" class="Link" target="blank">'.$NomeCompleto.'</a></td>';
		echo '<td>'.$NomeCurto.'</td>';
		echo '<td>'.$NomeStatus.'</td>';
		echo '<td>'.$NomeUnidadeY.'</td>';
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