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

if (empty($_SESSION['DataDe'])) {
	$DataDe = $DataAtual;
	$_SESSION['DataDe'] = $DataDe;
} else {
	$DataDe = $_SESSION['DataDe'];
}

if (empty($_SESSION['DataPara'])) {
	// cálcular a data final com 90 dias para frente
	$DataPara = date_create($DataAtual);
	// $DataFutura = date_create('2019-02-28');
	date_add($DataPara,date_interval_create_from_date_string("7 days"));
	$DataPara = date_format($DataPara,"Y-m-d");
	// salvar a data na session
	$_SESSION['DataPara'] = $DataPara;
} else {
	$DataPara = $_SESSION['DataPara'];
}

$FiltroData = 'AND DataSessao BETWEEN "'.$_SESSION['DataDe'].'" AND "'.$_SESSION['DataPara'].'"';

// input
$id_profissional = $_GET['id_profissional'];

// buscar dados
$sql = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCurto = $row['NomeCurto'];
		$NomeCompleto = $row['NomeCompleto'];
    }
} else {
}
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-profissional.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">
<div class="">
    <h3>Agenda do profissional</h3>
    <label>Nome do profissional:</label> <?php echo $NomeCompleto;?><br>
	<label>Nome social:</label> <?php echo $NomeCurto;?><br>
	<form action="configurar-filtro-data.php?id_profissional=<?php echo $id_profissional;?>" method="post" class="form-inline">
		<label>Aplicar filtro de:</label>
		<input type="date" class="form-control" name="DataDe" value="<?php echo $DataDe;?>">
		<label>até:</label>
		<input type="date" class="form-control" name="DataPara" value="<?php echo $DataPara;?>">
		<button type="submit" class="btn btn-success">Confirmar</button>
	</form>
	<hr>
	<?php
	// buscar xxx
	$sql = "SELECT * FROM sessao WHERE id_profissional = '$id_profissional' $FiltroData ORDER BY DataSessao ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Data</th>';
		echo '<th>Dia da semana</th>';
		echo '<th>Hora</th>';
		echo '<th>Categoria</th>';
		echo '<th>Paciente</th>';
		echo '<th>Unidade</th>';
		echo '<th>Status</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	    while($row = $result->fetch_assoc()) {
			$DataSessao = $row['DataSessao'];
			$DataSessao1 = date("d/m/Y", strtotime($DataSessao));

			$Data = date("d-m-Y", strtotime($DataSessao));
			setlocale(LC_TIME,"pt");
			$DiaSemana = (strftime("%A", strtotime($Data)));

			$id_hora = $row['id_hora'];
			$id_categoriaX = $row['id_categoria'];
			$id_unidade = $row['id_unidade'];
			$id_pacienteX = $row['id_paciente'];
			// buscar xxx
			$sqlA = "SELECT * FROM categoria WHERE id_categoria = '$id_categoriaX'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$NomeCategoriaX = $rowA['NomeCategoria'];
			    }
			} else {
			}
			// buscar xxx
			$sqlA = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$Hora = $rowA['Hora'];
			    }
			} else {
			}
			// buscar xxx
			$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$NomeUnidade = $rowA['NomeUnidade'];
			    }
			} else {
			}
			// buscar xxx
			$sqlA = "SELECT * FROM paciente WHERE id_paciente = '$id_pacienteX'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
			    	// $id_pacienteX = $rowA['id_paciente'];
					$NomeCompletoX = $rowA['NomeCompleto'];
					$NomeCurtoX = $rowA['NomeCurto'];
			    }
			} else {
			}

			// verificar se o profissional está atendendo o paciente
			$sqlA = "SELECT * FROM agenda_profissional WHERE id_paciente = '$id_pacienteX' AND id_profissional = '$id_profissional'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
			    	// sim, o profissional está atendendo
			    	$CheckPaciente = 1;
			    }
			} else {
				$CheckPaciente = 2;
			}

			echo '<tr>';
			echo '<td style="width: 100px;">'.$DataSessao1.'</td>';
			echo '<td>'.$DiaSemana.'</td>';
			echo '<td style="width: 60px;">'.$Hora.'</td>';
			echo '<td>'.$NomeCategoriaX.'</td>';
			
			if (($_SESSION['UsuarioNivel'] > 1) OR ($CheckPaciente == 1)) {
				echo '<td><a href="../paciente/paciente.php?id_paciente='.$id_pacienteX.'" class="Link">'.$NomeCurtoX.'</a></td>';
			} else {
				echo '<td>'.$NomeCurtoX.'</td>';
			}

			echo '<td>'.$NomeUnidade.'</td>';
			echo '<td style="width:180px;">';
			
			echo '<a href="" class="btn btn-default">Agendado</a>';
			echo '</td>';
			echo '</tr>';
	    }
	    echo '</tbody>';
		echo '</table>';
	} else {
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
