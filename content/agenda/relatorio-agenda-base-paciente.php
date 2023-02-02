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

// input
$id_paciente = $_SESSION['id_paciente'];
include '../paciente/dados-paciente.php';
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
	<li class="inactive"><a href="../avaliacao/">Plano terapêutico</a></li>
	<li class="inactive"><a href="../exame/">Dados médicos</a></li>
	<li class="inactive"><a href="../agenda/lista-agenda-paciente.php">Agenda</a></li>
	<li class="active"><a href="../agenda/relatorio-agenda-base-paciente.php">Agenda base</a></li>
</ul>

<div class="janela">
	<li><label>Nome completo:</label> <?php echo $NomeCompleto;?></li>
	<li><label>Horários de preferência:</label> <?php echo $PacientePreferencia;?></li>
    <li><a href="agendar-terapia-base.php" class="btn btn-default" >Agendar terapia</a></li>

	<?php
	// buscar xxx
	$sql = "SELECT * FROM agenda_paciente_base WHERE id_paciente = '$id_paciente' ORDER BY DiaSemana ASC, id_hora ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Dia da semana</a></th>';
		echo '<th>Hora</th>';
		echo '<th>Terapia</th>';
		echo '<th>Terapeuta</th>';
		echo '<th>Unidade</th>';
		echo '<th>Ação</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_agenda_paciente_base = $row['id_agenda_paciente_base'];
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

			echo '<tr>';
			echo '<td>'.$NomeDiaSemana.'</td>';
			echo '<td>'.$Hora.'</td>';
			echo '<td>'.$NomeCategoria.'</td>';
			echo '<td>'.$NomeTerapeuta.'</td>';
			echo '<td>'.$NomeUnidade.'</td>';
			echo '<td><a href="alterar-agenda-terapia-base.php?id_agenda_paciente_base='.$id_agenda_paciente_base.'" class="btn btn-default">Alterar</a></td>';
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

<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
</body>
</html>
