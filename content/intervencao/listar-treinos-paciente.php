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

// buscar xxx
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$NomeCompleto = $row['NomeCompleto'];
    }
} else {
	// não tem
	$NomeCompleto = NULL;
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
    <?php include '../menu-lateral/menu-lateral-intervencao.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior-intervencao.php';?>

<div id="conteudo">
    <h3>Treinos por paciente</h3>
    <label>Nome do paciente:</label> <?php echo $NomeCompleto;?> 
    <div class="row">
	    <div class="col-lg-6">
	    	<?php
			// buscar xxx
			$sql = "SELECT * FROM prog_treino_paciente WHERE id_paciente = '$id_paciente'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo '<table class="table table-striped table-hover table-condensed">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>Treino</th>';
				echo '<th style="width: 60px;">Ação</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			    while($row = $result->fetch_assoc()) {
					$id_treino_paciente = $row['id_treino_paciente'];
					$id_objetivo_paciente = $row['id_objetivo_paciente'];

					// buscar xxx
					$sqlA = "SELECT prog_objetivo.* FROM prog_objetivo_paciente INNER JOIN prog_objetivo ON prog_objetivo_paciente.id_objetivo = prog_objetivo.id_objetivo WHERE prog_objetivo_paciente.id_objetivo_paciente = '$id_objetivo_paciente'";
					$resultA = $conn->query($sqlA);
					if ($resultA->num_rows > 0) {
					    while($rowA = $resultA->fetch_assoc()) {
							// tem
							$id_objetivo = $rowA['id_objetivo'];
							$NomeObjetivo = $rowA['NomeObjetivo'];
					    }
					} else {
						// não tem
					}

					echo '<tr>';
					echo '<td style="vertical-align: middle;">'.$NomeObjetivo.'</td>';
					echo '<td><a href="treino.php?id_treino_paciente='.$id_treino_paciente.'&id_paciente='.$id_paciente.'&Origem=listar-treinos-paciente.php" class="btn btn-default">Abrir</a></td>';
					echo '</tr>';
			    }
			    echo '</tbody>';
				echo '</table>';
			} else {
				echo 'Não foi encontrado nenhum treino.';
			}
			?>
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
