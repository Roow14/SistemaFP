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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral-profissional.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Terapeuta</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../profissional/listar-profissionais.php">Lista</a></li>
	<li class="inactive"><a href="../profissional/profissional.php?id_profissional=<?php echo $id_profissional;?>">Terapeuta</a></li>
	<li class="active"><a href="../profissional/categoria-profissional.php?id_profissional=<?php echo $id_profissional;?>">Categoria</a></li>
	<li class="inactive"><a href="../agenda/agenda-profissional.php?id_profissional=<?php echo $id_profissional;?>">Agenda</a></li>
	<li class="inactive"><a href="../agenda/agenda-base-profissional.php?id_profissional=<?php echo $id_profissional;?>">Agenda base</a></li>
</ul>

<div class="janela">
    <label>Nome completo:</label> <?php echo $NomeCompleto;?><br>
	<div class="row">
		<div class="col-lg-6">
			<?php
			// buscar xxx
			$sql = "SELECT * FROM categoria_profissional WHERE id_profissional = '$id_profissional'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo '<table class="table table-striped table-hover table-condensed">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>Categoria</th>';
				echo '<th>Unidade</th>';
				echo '<th>Período</th>';
				echo '<th>Ação</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			    while($row = $result->fetch_assoc()) {
					$id_categoria_profissional = $row['id_categoria_profissional'];
					$id_categoria = $row['id_categoria'];
					$id_unidade = $row['id_unidade'];
					$id_periodo = $row['id_periodo'];

					// buscar xxx
					$sqlA = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							$NomeCategoria = $rowA['NomeCategoria'];
					    }
					} else {
						$NomeCategoria = NULL;
					}

					// buscar xxx
					$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							$NomeUnidade = $rowA['NomeUnidade'];
					    }
					} else {
						$NomeUnidade = NULL;
					}

					// buscar xxx
					$sqlA = "SELECT * FROM periodo WHERE id_periodo = '$id_periodo'";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							$NomePeriodo = $rowA['NomePeriodo'];
					    }
					} else {
						$NomePeriodo = NULL;
					}

					echo '<tr>';
					echo '<td>'.$NomeCategoria.'</td>';
					echo '<td>'.$NomeUnidade.'</td>';
					echo '<td>'.$NomePeriodo.'</td>';

					// verificar se a foi utilizada anteriormente
					// if ((empty($id_unidade)) OR (empty($id_periodo))) {

					// } else {
					// 	$sqlA = "SELECT * FROM sessao WHERE id_profissional = '$id_profissional' AND Periodo = '$id_periodo' AND id_unidade = '$id_unidade' ";
					// 	$resultA = $conn->query($sqlA);
					// 	if ($resultA->num_rows > 0) {
					// 	    while($rowA = $resultA->fetch_assoc()) {
					// 	    	// sim
					// 			$CheckAgenda = 1;
					// 	    }
					// 	} else {
					// 		// não
					// 		$CheckAgenda = 2;
					// 	}
					// }

					// buscar xxx
					echo '<td>';
					$sqlA = "SELECT * FROM agenda_paciente_base WHERE id_profissional = '$id_profissional' AND id_categoria = '$id_categoria' AND id_unidade = '$id_unidade' AND id_periodo = '$id_periodo' LIMIT 1 ";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							// tem
							echo '<a href="" class="btn btn-default">Em uso</a>';
					    }
					} else {
						// não tem
						echo '<a href="apagar-categoria-profissional-2.php?id_profissional='.$id_profissional.'&id_categoria_profissional='.$id_categoria_profissional.'" class="btn btn-warning">Apagar</a>';
					}
					echo '</td>';
					echo '</tr>';
			    }
			    echo '</tbody>';
				echo '</table>';
			} else {
				$id_categoria = NULL;
				$id_unidade = NULL;
				$id_periodo = NULL;
				echo '<br>';
				echo 'Não encontramos nenhuma categoria cadastrada.<br>';
				echo '<br>';
			}
			?>
		</div>
	</div>
	<a href="profissional.php?id_profissional=<?php echo $id_profissional;?>" class="btn btn-default">Fechar</a>
	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#addcategoria">Adicionar categoria</button>
</div>

<!-- asicionar categoria -->
<div id="addcategoria" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<form action="adicionar-categoria-profissional.php?id_profissional=<?php echo $id_profissional;?>" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Associar categoria</h4>
				</div>
				<div class="modal-body">
					
					<div class="form-group">
						<label>Categoria:</label>
						<select class="form-control" name="id_categoria" required>
							<option value="">Selecionar</option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM categoria ORDER BY NomeCategoria ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									$id_categoria = $row['id_categoria'];
									$NomeCategoria = $row['NomeCategoria'];
									echo '<option value="'.$id_categoria.'">'.$NomeCategoria.'</option>';
							    }
							} else {
							}
							?>
						</select>
					</div>

					<div class="form-group">
						<label>Unidade:</label>
						<select class="form-control" name="id_unidade" required>
							<option value="">Selecionar</option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM unidade ORDER BY NomeUnidade ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									$id_unidade = $row['id_unidade'];
									$NomeUnidade = $row['NomeUnidade'];
									echo '<option value="'.$id_unidade.'">'.$NomeUnidade.'</option>';
							    }
							} else {
							}
							?>
						</select>
					</div>

					<div class="form-group">
						<label>Período:</label>
						<select class="form-control" name="id_periodo" required>
							<option value="">Selecionar</option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM periodo ORDER BY Periodo ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									$id_periodo = $row['id_periodo'];
									$NomePeriodo = $row['NomePeriodo'];
									echo '<option value="'.$id_periodo.'">'.$NomePeriodo.'</option>';
							    }
							} else {
							}
							?>
						</select>
					</div>		
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					<button type="submit" class="btn btn-success">Confirmar</button>
				</div>
			</form>
		</div>
	</div>
</div>		

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
