<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input 
if (empty($_SESSION['PesquisaPaciente'])) {
	$PesquisaPaciente = NULL;
	$FiltroPaciente = NULL;
} else {
	$PesquisaPaciente = $_SESSION['PesquisaPaciente'];
	$FiltroPaciente = 'AND paciente.NomeCompleto LIKE "%'.$PesquisaPaciente.'%"';
}

if (empty($_SESSION['id_convenio'])) {
	$id_convenio = NULL;
	$FiltroConvenio = NULL;
	$NomeConvenio = 'Selecionar';
} else {
	$id_convenio = $_SESSION['id_convenio'];
	$FiltroConvenio = 'AND convenio_paciente.id_convenio = '.$id_convenio;
	$sql = "SELECT * FROM convenio WHERE id_convenio = '$id_convenio'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeConvenio = $row['NomeConvenio'];
			$FiltroConvenio = 'AND convenio_paciente.id_convenio = '.$id_convenio;
	    }
	} else {
		// não tem
		$FiltroConvenio = NULL;
	}
}

if (empty($_SESSION['Status'])) {
	$Status = NULL;
	$NomeStatus = 'Todos';
	$FiltroStatus = NULL;
} else {
	$Status = $_SESSION['Status'];
	$FiltroStatus = 'AND paciente.Status = '.$Status;
	if ($Status == 1) {
		$NomeStatus = 'Ativo';
	} else {
		$NomeStatus = 'Inativo';
	}

}

// filtrar por unidade
if (!empty($_SESSION['id_unidade'])) {
	$id_unidade = $_SESSION['id_unidade'];
	$FiltroUnidade = 'AND paciente.id_unidade = '.$id_unidade;

	if ($id_unidade == 5) {
		// conexão com banco
		include '../conexao/conexao-coral.php';
	} else {
		// conexão com banco
		include '../conexao/conexao.php';
	}

	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$NomeUnidade = $row['NomeUnidade'];
	    }
	} else {
	}
} else {
	$id_unidade = NULL;
	$NomeUnidade = 'Selecionar';
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
	.Link {
		background-color: transparent;
		border: none;
	}
	input[type=checkbox] {
	    transform: scale(1.3);
        margin: 5px 10px;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Convênio médico</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="index.php">Agenda do dia</a></li>
	<li class="inactive"><a href="relatorio-convenio-paciente.php">Criança</a></li>
	<li class="inactive"><a href="convenio-paciente.php">Convênios da criança</a></li>
	<li class="inactive"><a href="listar-convenio.php">Convênios</a></li>
	<li class="inactive"><a href="listar-convenio-paciente.php">Com convênio</a></li>
	<li class="active"><a href="listar-paciente-sem-convenio.php">Sem convênio</a></li>
	<li class="inactive"><a href="relatorio-presenca.php">Presença</a></li>
	<li class="inactive"><a href="ajuda.php">Ajuda</a></li>
</ul>

<div class="janela">
<h3>Crianças sem convênio associado</h3>
<form action="listar-paciente-sem-convenio-filtro-2.php" method="post" class="form-inline">
	<div class="form-group">
		<label>Filtrar por criança:</label>
		<input type="text" name="PesquisaPaciente" class="form-control" value="<?php echo $PesquisaPaciente;?>" placeholder="Nome">
	</div>

    <div class="form-group">
    	<label>Status da criança: </label>
    	<select class="form-control" name="Status">
    		<option value="<?php echo $Status;?>"><?php echo $NomeStatus;?></option>
    		<option value="1">Ativo</option>
    		<option value="2">Inativo</option>
    		<option value="">Todos</option>
    	</select>
    </div><div class="form-group">
    	<label>Unidade:</label>
        <select name="id_unidade" class="form-control" required>
			<option value="<?php echo $id_unidade;?>"><?php echo $NomeUnidade;?></option>
			<?php
			$sqlA = "SELECT * FROM unidade ORDER BY NomeUnidade ASC";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$id_unidadeX = $rowA['id_unidade'];
					$NomeUnidadeX = $rowA['NomeUnidade'];
					echo '<option value="'.$id_unidadeX.'">'.$NomeUnidadeX.'</option>';
			    }
			} else {
				// não tem
				$NomeUnidadeX = NULL;
			}
			?>
		</select>
    </div>

	<button type="submit" class="btn btn-success">Confirmar</button>
</form>
<p>Dica: clique no nome da criança e em seguida associe o convênio.</p>
<?php
// buscar xxx
$sql = "SELECT *
FROM paciente
WHERE paciente.Status = 1 $FiltroPaciente $FiltroStatus $FiltroUnidade
ORDER BY paciente.NomeCompleto ASC
";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Nome</th>';
	echo '<th>Status</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
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

		// buscar xxx
		$sqlA = "SELECT * FROM convenio_paciente WHERE id_paciente = '$id_paciente' LIMIT 1";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				// $aa = $rowA['aa'];
		    }
		} else {
			// não tem
			echo '<tr>';
			echo '<td><a href="convenio-paciente.php?id_paciente='.$id_paciente.'" class="Link" target="blank">'.$NomeCompleto.'</a></td>';
			echo '<td>'.$NomeStatus.'</td>';
			echo '</tr>';
		}

			
    }
    echo '</tbody>';
	echo '</table>';
} else {
	// não tem
	echo 'Não foi encontrado nenhum paciente.';
}
?>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
