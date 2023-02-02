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

if (empty($_SESSION['DataAgenda'])) {
	$DataAgenda = $DataAtual;
	$_SESSION['DataAgenda'] = $DataAtual;
} else {
	$DataAgenda = $_SESSION['DataAgenda'];
}
$DataAgendaX = date("d/m/Y", strtotime($DataAgenda));
$Data = $DataAgenda;

// verificar se o input dia é segunda
include '../agenda/verificar-dia-semana.php';

// terça
$date = date_create($DataAgenda);
$Segunda = date_format($date,"Y-m-d");
$SegundaBr = date("d/m/Y", strtotime($Segunda));

// terça
$date = date_create($DataAgenda);
date_add($date,date_interval_create_from_date_string("1 day"));
$Terca = date_format($date,"Y-m-d");
$TercaBr = date("d/m/Y", strtotime($Terca));

// quarta
$date = date_create($DataAgenda);
date_add($date,date_interval_create_from_date_string("2 day"));
$Quarta = date_format($date,"Y-m-d");
$QuartaBr = date("d/m/Y", strtotime($Quarta));

// quinta
$date = date_create($DataAgenda);
date_add($date,date_interval_create_from_date_string("3 day"));
$Quinta = date_format($date,"Y-m-d");
$QuintaBr = date("d/m/Y", strtotime($Quinta));

// sexta
$date = date_create($DataAgenda);
date_add($date,date_interval_create_from_date_string("4 day"));
$Sexta = date_format($date,"Y-m-d");
$SextaBr = date("d/m/Y", strtotime($Sexta));

// input
if (isset($_POST['id_profissional'])) {
	$id_profissional = $_POST['id_profissional'];
	$_SESSION['id_profissional'] = $_POST['id_profissional'];
	
	// buscar xxx
	$sql = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeProfissional = $row['NomeCompleto'];
	    }
	} else {
		// não tem
	}
} elseif (isset($_GET['id_profissional'])) {
	$id_profissional = $_GET['id_profissional'];
	$_SESSION['id_profissional'] = $_GET['id_profissional'];
	
	// buscar xxx
	$sql = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeProfissional = $row['NomeCompleto'];
	    }
	} else {
		// não tem
	}
} elseif (isset($_SESSION['id_profissional'])) {
	$id_profissional = $_SESSION['id_profissional'];
	
	// buscar xxx
	$sql = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeProfissional = $row['NomeCompleto'];
	    }
	} else {
		// não tem
	}
} else {
	// não tem
	$id_profissional = NULL;
	$NomeProfissional = 'Selecionar profissional';
	$FiltroPeriodo = NULL;
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
		padding: 0;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Agenda do terapeuta</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="relatorio-agenda-base.php">Paciente</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-profissional.php">Terapeuta</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-dia-semana.php">Dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-analise.php">Análise</a></li>
    <li class="inactive"><a href="criar-agenda-da-semana.php">Criar agenda</a></li>
    <li class="inactive"><a href="relatorio-agenda-do-dia.php">Agenda dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-paciente.php">Agenda criança</a></li>
    <li class="active"><a href="relatorio-agenda-profissional.php">Agenda terapeuta</a></li>
</ul>

<div class="janela">
	<form action="" method="post" class="form-inline" style="margin-bottom: 15px;">
		<label>Filtrar por terapeuta:</label>
		<select class="form-control" name="id_profissional">
			<option value="<?php echo $id_profissional;?>"><?php echo $NomeProfissional;?></option>
			<?php
			$sql = "SELECT * FROM profissional WHERE Status = 1 ORDER BY NomeCompleto ASC";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					// tem
					$id_profissionalX = $row['id_profissional'];
					$NomeProfissionalX = $row['NomeCompleto'];
					echo '<option value="'.$id_profissionalX.'">'.$NomeProfissionalX.'</option>';
			    }
			} else {
				// não tem
			}
			?>
		</select>
		<label>data:</label>
		<input type="date" class="form-control" data-toggle="tooltip" title="Dia da semana" name="DataAgenda" value="<?php echo $Data;?>" required>
		<button type="submit" class="btn btn-success">Confirmar</button>
	</form>

	<!-- paciente -->
	<table class="table table-striped table-hover table-condensed table-bordered">
	<thead>
	<tr>
	<th>Hora</th>
	<th class="largura-col">Segunda <span><?php echo $SegundaBr;?></span></th>
	<th class="largura-col">Terça <span><?php echo $TercaBr;?></span></th>
	<th class="largura-col">Quarta <span><?php echo $QuartaBr;?></span></th>
	<th class="largura-col">Quinta <span><?php echo $QuintaBr;?></span></th>
	<th class="largura-col">Sexta <span><?php echo $SextaBr;?></span></th>
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

				echo '<tr>';
				echo '<td>'.$Hora.'</td>';

				echo '<td>';
				$DiaSemana = 2;
				$Data = $Segunda;
				include 'agenda-profissional-paciente.php';
				echo '</td>';

				echo '<td>';
				$DiaSemana = 3;
				$Data = $Terca;
				include 'agenda-profissional-paciente.php';
				echo '</td>';

				echo '<td>';
				$DiaSemana = 4;
				$Data = $Quarta;
				include 'agenda-profissional-paciente.php';
				echo '</td>';

				echo '<td>';
				$DiaSemana = 5;
				$Data = $Quinta;
				include 'agenda-profissional-paciente.php';
				echo '</td>';

				echo '<td>';
				$DiaSemana = 6;
				$Data = $Sexta;
				include 'agenda-profissional-paciente.php';
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
