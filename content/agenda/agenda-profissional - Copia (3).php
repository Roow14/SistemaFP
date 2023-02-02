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
$DataAtualBr = date("d/m/Y", strtotime($DataAtual));

if (!empty($_SESSION['DataAgenda'])) {
	$DataAgenda = $_SESSION['DataAgenda'];
} else {
	$DataAgenda = $DataAtual;
	$_SESSION['DataAgenda'] = $DataAtual;
}

// vem de pesquisas gerais > terapeutas disponiveis
if (!empty($_SESSION['Data'])) {
	$DataAgenda = $_SESSION['Data'];
}

// verificar se o input dia é segunda
include 'verificar-dia-semana.php';

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
if (empty($_GET['id_profissional'])) {
	// não tem
	$id_profissional = NULL;
	$NomeProfissional = 'Selecionar profissional';
	$FiltroPeriodo = NULL;
} else {
	$id_profissional = $_GET['id_profissional'];
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
}

if (empty($_SESSION['id_unidade'])) {
	// não tem
	$id_unidade = NULL;
	$NomeUnidade = 'Todos';
	$FiltroUnidade = NULL;
} else {
	$id_unidade = $_SESSION['id_unidade'];
	$FiltroUnidade = 'AND id_unidade = '.$id_unidade;
	// buscar xxx
	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeUnidade = $row['NomeUnidade'];
	    }
	} else {
		// não tem
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
	.Link {
		background-color: transparent;
		border: none;
	}
	.btn-custom {
		padding: 6px 8px;
		border-radius: 50%;
	}
</style>

<body>
<div class="wrapper">
    <?php
    if ($_SESSION['UsuarioNivel'] > 1) {
    	include '../menu-lateral/menu-lateral.php';
    } else {
    	include '../menu-lateral/menu-lateral-profissional.php';
    }
    ?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">
        	
<h2>Terapeutas</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../profissional/listar-profissionais.php">Lista</a></li>
	<li class="inactive"><a href="../profissional/profissional.php?id_profissional=<?php echo $id_profissional;?>">Terapeuta</a></li>
	<li class="active"><a href="../agenda/agenda-profissional.php?id_profissional=<?php echo $id_profissional;?>">Agenda</a></li>
	<li class="inactive"><a href="../agenda/agenda-base-profissional.php?id_profissional=<?php echo $id_profissional;?>">Agenda base</a></li>
</ul>

<div class="janela">
	<div>
		<span style="margin-right: 25px;"><label>Nome:</label> <?php echo $NomeProfissional;?></span>
		<span class="hidden-print form-group">
			<span data-toggle="tooltip" title="Semana anterior"><a href="alterar-inicio-da-semana-anterior-profissional.php?DataAgenda=<?php echo $DataAgenda;?>&id_profissional=<?php echo $id_profissional;?>" class="btn btn-default">&lsaquo;</a></span>
			<span data-toggle="tooltip" title="Próxima semana"><a href="alterar-inicio-da-semana-proximo-profissional.php?DataAgenda=<?php echo $DataAgenda;?>&id_profissional=<?php echo $id_profissional;?>>" class="btn btn-default">&rsaquo;</a></span>
			<span data-toggle="tooltip" title="Alterar terapeuta e semana"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Filtro</button></span>

			<a href="agenda-paciente-ativar-remocao-paciente.php?id_profissional=<?php echo $id_profissional;?>" class="btn btn-default" data-toggle="tooltip" title="Ativar / desativar botão para cancelar criança">Remover</a>

			<button onclick="window.print()" class="btn btn-default hidden-print">Imprimir</button>
		</span>
	</div>

	<!-- paciente -->
	<div>
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

<!-- ajuda -->
<div id="Ajuda" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Agendar terapeuta</h4>
			</div>
			<div class="modal-body">
				<p>Primeiramente, verfique se existe um terapeuta agendado no horário desejado. Se existir, clique no botão "X" e cancele o terapeuta.</p>
				<p>Em seguida selecione a data, hora, categoria, unidade e clique em confirmar.</p>
	            <p>Para finalizar, selecione o terapeuta e clique em confirmar.</p>
	            <p><b>Notas:</b></p>
	            <p>No <b>campo terapeuta</b> aparecerão somente os terapeutas que preenchem os requisitos do filtro aplicado: data, categoria e unidade.<br>
	            O sinal --- indica que o terapeuta já tem uma agenda para este horário.</p>
	            <p><b>Limpar filtro</b>: remove os filtros de hora, categoria e unidade.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

<!-- filtro -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Aplicar filtro</h4>
			</div>
			<form action="agenda-profissional-2.php" method="post">
				<div class="modal-body">
		            <!-- filtros -->
					<div class="form-group">
						<label>Nome do terapeuta</label>
						<select class="form-control" name="id_profissionalX" required>
							<option value="<?php echo $id_profissional;?>"><?php echo $NomeProfissional;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM profissional WHERE Status = 1 ORDER BY NomeCompleto ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_profissionalX = $row['id_profissional'];
									$NomeProfissional = $row['NomeCompleto'];
									echo '<option value="'.$id_profissionalX.'">'.$NomeProfissional.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>

					<div class="form-group">
						<label>Unidade</label>
						<select class="form-control" name="id_unidadeX">
							<option value="<?php echo $id_unidade;?>"><?php echo $NomeUnidade;?></option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM unidade ORDER BY NomeUnidade ASC ";
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
							<option value="">Todos</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Confirmar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</form>
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
