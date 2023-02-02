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
$id_convenio_paciente = $_GET['id_convenio_paciente'];

// buscar xxx
$sql = "SELECT convenio_paciente.*, convenio.NomeConvenio, paciente.NomeCompleto
FROM convenio_paciente
INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
INNER JOIN paciente ON convenio_paciente.id_paciente = paciente.id_paciente
WHERE convenio_paciente.id_convenio_paciente = '$id_convenio_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_convenio = $row['id_convenio'];
		$id_paciente = $row['id_paciente'];
		$NomeConvenio = $row['NomeConvenio'];
		$NomeCompleto = $row['NomeCompleto'];
		$NumeroConvenio = $row['NumeroConvenio'];
		$NotaConvenio = $row['NotaConvenio'];
		$Total = $row['Total'];
		$StatusConvenio = $row['StatusConvenio'];
		if ($StatusConvenio == 1) {
			$NomeStatus = 'Ativo';
		} else {
			$NomeStatus = 'Inativo';
		}
    }
} else {
}

// verificar se foi utilizado na agenda
$sql = "SELECT * FROM agenda_paciente WHERE id_convenio = '$id_convenio' LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$Check = 1;
    }
} else {
	// não tem
	$Check = 2;
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

<h2>Pacientes</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../paciente/">Lista</a></li>
	<li class="inactive"><a href="../paciente/paciente.php">Paciente</a></li>
	<li class="inactive"><a href="../paciente/escola-paciente.php">Escola</a></li>
	<li class="active"><a href="../paciente/convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Avaliação</a></li>
	<li class="inactive"><a href="../configuracao/relatorio-agenda-paciente.php">Agenda</a></li>
</ul>
	
<div class="janela">
	<h3>Convênio do paciente</h3>

	<li><label>Nome do paciente:</label> <?php echo $NomeCompleto;?></li>
	<li><label>Convênio:</label> <?php echo $NomeConvenio;?></li>
	<li><label>Nº carteirinha:</label> <?php echo $NumeroConvenio;?></li>
	<li><label>Status:</label> <?php echo $NomeStatus;?></li>
	<li><label>Horas liberadas:</label> <?php echo $Total;?></li>
	<li><label>Observação:</label> <?php echo $NotaConvenio;?></li>
	<a href="alterar-convenio-paciente.php?id_convenio_paciente=<?php echo $id_convenio_paciente;?>" class="btn btn-default">Fechar</a>
	<li><label>Histórico de horas adicionadas:</label></li>

	<?php
	// buscar xxx
	$sql = "SELECT * FROM convenio_horas_liberadas WHERE id_convenio_paciente = '$id_convenio_paciente' ORDER BY Data DESC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Data</th>';
		echo '<th>Horas</th>';
		echo '<th>Nota</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	    while($row = $result->fetch_assoc()) {
			// tem
			$Horas = $row['Horas'];
			$Nota = $row['Nota'];
			$Data = $row['Data'];
			$Data = date("d/m/Y", strtotime($Data));
			echo '<tr>';
			echo '<td>'.$Data.'</td>';
			echo '<td>'.$Horas.'</td>';
			echo '<td>'.$Nota.'</td>';
			echo '</tr>';
	    }
	    echo '</tbody>';
		echo '</table>';
	} else {
		// não tem
	}
	?>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>