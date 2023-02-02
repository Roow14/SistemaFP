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

// verificar se o input dia é segunda
include 'verificar-dia-semana.php';

// segunda
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
<style type="text/css">
    body {

        background-color: #fcf8e3;
    }
</style>
<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div style="padding: 0 25px;">

            <h3>Agenda equoterapia</h3>

            <!-- filtros -->
            <!-- alterar-inicio-da-semana -->
            <div>
	            <form action="agenda-equo-filtro.php?" method="post" class="form-inline">

	            	<label>2ª feira:</label>
					<input type="date" class="form-control" name="DataAgenda" value="<?php echo $DataAgenda;?>">
					<button class="btn btn-success">Confirmar</button>
					<a href="alterar-inicio-da-semana-anterior-equo.php?DataAgenda=<?php echo $DataAgenda;?>" class="btn btn-default">&lsaquo; Anterior</a>
					<a href="alterar-inicio-da-semana-proximo-equo.php?DataAgenda=<?php echo $DataAgenda;?>" class="btn btn-default">Próxima 2ª &rsaquo;</a>
					<a href="agenda-equo-ativar-agendamento.php" class="btn btn-default" data-toggle="tooltip" title="Ativar/desativar opção para cancelar profissional">&#x270E;</a>
					<a href="agenda-equo-ativar-remocao-profissional.php" class="btn btn-default" data-toggle="tooltip" title="Ativar/desativar cancelamento do profissional">&#x2715;</a>
	            </form>
	            <p><span style="margin-right: 15px;"><label>Notas:</label> P = paciente, T = terapeuta principal, A = auxiliar.</span> <label>Unidade:</label> Matriz</p>
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
				echo '<th class="largura-col">Segunda <span>'.$SegundaBr.'</span></th>';
				echo '<th class="largura-col">Terça <span>'.$TercaBr.'</span></th>';
				echo '<th class="largura-col">Quarta <span>'.$QuartaBr.'</span></th>';
				echo '<th class="largura-col">Quinta <span>'.$QuintaBr.'</span></th>';
				echo '<th class="largura-col">Sexta <span>'.$SextaBr.'</span></th>';
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
					$Data = $DataAgenda;
					include 'agenda-equo-paciente-profissional.php';
					echo '</td>';

					echo '<td>';
					$DiaSemana = 3;
					$Data = $Terca;
					include 'agenda-equo-paciente-profissional.php';
					echo '</td>';

					echo '<td>';
					$DiaSemana = 4;
					$Data = $Quarta;
					include 'agenda-equo-paciente-profissional.php';
					echo '</td>';

					echo '<td>';
					$DiaSemana = 5;
					$Data = $Quinta;
					include 'agenda-equo-paciente-profissional.php';
					echo '</td>';

					echo '<td>';
					$DiaSemana = 6;
					$Data = $Sexta;
					include 'agenda-equo-paciente-profissional.php';
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
