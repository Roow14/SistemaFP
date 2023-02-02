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
		$ObsTerapiaRealizada = $row['ObsTerapiaRealizada'];
    }
} else {
	$ObsTerapiaRealizada = NULL;
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
    <h3>Terapias realizadas</h3>
    <label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>
<div class="row">
<div class="col-lg-6">
	
    <?php
	// buscar xxx
	$sql = "SELECT terapia_paciente.*, terapia.* FROM terapia_paciente INNER JOIN terapia ON terapia_paciente.id_terapia = terapia.id_terapia WHERE terapia_paciente.id_paciente = '$id_paciente' ORDER BY terapia.NomeTerapia";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Terapias solciitadas</th>';
		echo '<th style="width: 150px; text-align: right;">Horas semanais solicitadas</th>';
		echo '<th style="width: 150px; text-align: right;">Horas realizadas</th>';
		echo '<th>Ação</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	    while($row = $result->fetch_assoc()) {
			$id_terapia_paciente = $row['id_terapia_paciente'];
			$NomeTerapia = $row['NomeTerapia'];
			$HorasTerapia = $row['HorasTerapia'];
			$HorasTerapiaRealizada = $row['HorasTerapiaRealizada'];
			$Origem = 'listar-terapias-realizadas.php';

			echo '<form action="terapias-realizadas-2.php?id_paciente='.$id_paciente.'&id_terapia_paciente='.$id_terapia_paciente.'&Origem='.$Origem.'" method="post">';
			echo '<tr>';
			echo '<td>'.$NomeTerapia.'</td>';
			echo '<td style="text-align: right;">'.$HorasTerapia.'</td>';
			echo '<td><input type="number" class="form-control" style="text-align: right;" name="HorasTerapiaRealizada" value="'.$HorasTerapiaRealizada.'"></td>';
			echo '<td><button type="submit" class="btn btn-default">Confirmar</button></td>';
			echo '</tr>';
			echo '</form>';
	    }
	    echo '</tbody>';
		echo '</table>';
		
	} else {
		echo 'Não encontramos nenhuma terapia selecionada.';
	}
	?>
	
	<form action="terapia-observacao-realizada-2.php?id_paciente=<?php echo $id_paciente;?>&Origem=<?php echo 'listar-terapias-realizadas.php';?>" method="post">
		<div class="form-group">
			<label>Observação</label>
			<textarea rows="4" class="form-control" name="ObsTerapiaRealizada"><?php echo $ObsTerapiaRealizada;?></textarea>
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
