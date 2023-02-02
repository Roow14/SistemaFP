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

// filtro por categoria
$FiltroCategoria = 'WHERE id_categoria = 14';

// período
if (empty($_SESSION['id_periodo'])) {
	$id_periodo = NULL;
    $NomePeriodo = 'Todos';
    $FiltroPeriodo = NULL;
    $FiltroPeriodo1 = NULL;
} else {
    $id_periodo = $_SESSION['id_periodo'];
	// buscar xxx
	if ($id_periodo == 10) {
		$FiltroPeriodo = 'WHERE Periodo = 1 OR Periodo = 2' ;
		$FiltroPeriodo1 = 'AND categoria_profissional.id_periodo = 1 OR categoria_profissional.id_periodo = 2';
		$NomePeriodo = 'Manhã e tarde';
	} elseif ($id_periodo == 11) {
		$FiltroPeriodo = 'WHERE Periodo = 2 OR Periodo = 3' ;
		$FiltroPeriodo1 = 'AND categoria_profissional.id_periodo = 2 OR categoria_profissional.id_periodo = 3';
		$NomePeriodo = 'Tarde e noite';
	} elseif ($id_periodo == 92) {
		$FiltroPeriodo = NULL;
		$FiltroPeriodo1 = NULL;
		$NomePeriodo = 'Dia e noite';
	} else {
		$FiltroPeriodo = 'WHERE Periodo = '.$id_periodo;
		// buscar xxx
		$sql = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$id_periodo = $row['id_periodo'];
				$NomePeriodo = $row['NomePeriodo'];
				$FiltroPeriodo = 'WHERE Periodo = '.$id_periodo;
				$FiltroPeriodo1 = 'AND categoria_profissional.id_periodo = '.$id_periodo;
		    }
		} else {
			// não tem
			$id_periodo = 1;
		    $NomePeriodo = 'Manhã';
		    $FiltroPeriodo = NULL;
		    $FiltroPeriodo1 = 'AND categoria_profissional.id_periodo = 1';
		}
	}
}

// unidade
$id_unidadeX = 1;
$NomeUnidade = 'Matriz';
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
	.largura-col {
		width: 20%;
	}
	.largura-col span {
		font-weight: 300;
		font-size: 16px;
	}
	.link-apagar {
		color: orange;
	}
	.link-apagar:hover {
		color: red;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="" style="padding: 0 25px; margin-top: -25px;">
        	<h2>Agenda equoterapia base do paciente</h2>

            <!-- filtros -->
            <!-- alterar-inicio-da-semana -->
            <div>
	            <span style="margin-right: 15px;"><label>Notas:</label> P = paciente, T = terapeuta principal, A = auxiliar.</span> <label>Unidade:</label> Matriz
	            <a href="agenda-equo-base-ativar-agendamento.php" class="btn btn-default" data-toggle="tooltip" title="Ativar/desativar opção para cancelar profissional">&#x270E;</a>
				<a href="agenda-equo-base-ativar-remocao-profissional.php" class="btn btn-default" data-toggle="tooltip" title="Ativar/desativar cancelamento do profissional">&#x2715;</a>
			</div>
       
			<!-- tabela -->
			<?php
			// buscar xxx
			$sql = "SELECT * FROM hora";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo '<table class="table table-striped table-hover table-condensed">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>Hora</th>';
				echo '<th class="largura-col">Segunda</th>';
				echo '<th class="largura-col">Terça</th>';
				echo '<th class="largura-col">Quarta</th>';
				echo '<th class="largura-col">Quinta</th>';
				echo '<th class="largura-col">Sexta</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			    while($row = $result->fetch_assoc()) {
					// tem
					// tem
					$id_hora = $row['id_hora'];
					$Hora = $row['Hora'];
					$Periodo = $row['Periodo'];

					echo '<tr>';
					echo '<td>'.$Hora.'</td>';

					echo '<td>';
					$DiaSemana = 2;
					include 'agenda-equo-base-paciente-profissional.php';
					echo '</td>';

					echo '<td>';
					$DiaSemana = 3;
					include 'agenda-equo-base-paciente-profissional.php';
					echo '</td>';

					echo '<td>';
					$DiaSemana = 4;
					include 'agenda-equo-base-paciente-profissional.php';
					echo '</td>';

					echo '<td>';
					$DiaSemana = 5;
					include 'agenda-equo-base-paciente-profissional.php';
					echo '</td>';

					echo '<td>';
					$DiaSemana = 6;
					include 'agenda-equo-base-paciente-profissional.php';
					echo '</td>';

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
