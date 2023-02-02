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

// input
$id_paciente = $_GET['id_paciente'];

// buscar dados
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
    }
} else {
}

// buscar dados
$sql = "SELECT * FROM terapia_observacao WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$ObsTerapiaSolicitada = $row['ObsTerapiaSolicitada'];
    }
} else {
	$ObsTerapiaSolicitada = NULL;
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
    <?php include '../menu-lateral/menu-lateral-paciente.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

<div id="conteudo">
    <h3>Encaminhamento médico</h3>
    <label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>
<div class="row">
<div class="col-lg-6">
    <?php
	// buscar xxx
	$sql = "SELECT * FROM terapia ORDER BY NomeTerapia ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Terapias solicitadas</th>';
		echo '<th style="width: 150px;">Qtde de horas semanais</th>';
		echo '<th>Ação</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	    while($row = $result->fetch_assoc()) {
			$id_terapia = $row['id_terapia'];
			$NomeTerapia = $row['NomeTerapia'];
			$Origem = 'listar-terapias-solicitadas.php';

			echo '<form action="terapias-solicitadas-2.php?id_paciente='.$id_paciente.'&id_terapia='.$id_terapia.'&Origem='.$Origem.'" method="post">';
			echo '<tr>';
			echo '<td>'.$NomeTerapia.'</td>';

			// buscar xxx
			$sqlA = "SELECT * FROM terapia_paciente WHERE id_paciente = '$id_paciente' AND id_terapia = '$id_terapia'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$HorasTerapia = $rowA['HorasTerapia'];
			    }
			} else {
				$HorasTerapia = NULL;
			}

			echo '<td><input type="number" class="form-control" name="HorasTerapia" value="'.$HorasTerapia.'"></td>';
			echo '<td><button type="submit" class="btn btn-default">Confirmar</button></td>';
			echo '</tr>';
			echo '</form>';
	    }
	    echo '</tbody>';
		echo '</table>';
	} else {
	}
	?>

	<form action="terapia-observacao-solicitada-2.php?id_paciente=<?php echo $id_paciente;?>&Origem=<?php echo 'listar-terapias-solicitadas.php';?>" method="post">
		<div class="form-group">
			<label>Observação</label>
			<textarea rows="4" class="form-control" name="ObsTerapiaSolicitada"><?php echo $ObsTerapiaSolicitada;?></textarea>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-success">Confirmar</button>
		</div>
	</form>
</div>
	
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
