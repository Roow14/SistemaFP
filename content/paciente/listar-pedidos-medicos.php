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
    <h3>Exames do paciente</h3>
    <label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>

    <?php
	// buscar xxx
	$sql = "SELECT * FROM pedido_medico WHERE id_paciente = '$id_paciente'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_pedido_medico = $row['id_pedido_medico'];
			$id_medico = $row['id_medico'];
			$DataPedidoMedico = $row['DataPedidoMedico'];
			$DataPedidoMedico1 = date("d/m/Y", strtotime($DataPedidoMedico));
			$Observacao = $row['Observacao'];

			// buscar xxx
			$sqlA = "SELECT * FROM medico WHERE id_medico = '$id_medico'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$NomeMedico = $rowA['NomeMedico'];
					
			    }
			} else {
			}
			?>
			<div id="<?php echo $id_pedido_medico;?>" style="margin-bottom: 25px;">
			<label>Data:</label> <?php echo $DataPedidoMedico1;?><br>
			<label>Médico:</label> <?php echo $NomeMedico;?><br>
			<?php
			// buscar xxx
			$sqlA = "SELECT DISTINCT exame.*, exame_paciente.* FROM exame_paciente INNER JOIN exame ON exame_paciente.id_exame = exame.id_exame WHERE exame_paciente.id_pedido_medico = '$id_pedido_medico'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$id_exame_paciente = $rowA['id_exame_paciente'];
					$id_exame = $rowA['id_exame'];
					$NomeExame = $rowA['NomeExame'];
					echo '<li>'.$NomeExame.'</li>';
			    }
			} else {
			}
			?>
			<label>Observação:</label> <?php echo $Observacao;?><br>
			<a href="pedido-medico.php?id_paciente=<?php echo $id_paciente;?>&id_pedido_medico=<?php echo $id_pedido_medico;?>" class="btn btn-default">Alterar dados e ver exames</a>
			</div>
			<?php
	    }
	} else {
		?>
		<a href="cadastrar-pedido-medico.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Cadastrar exame</a>
		<?php
	}
	?>
</div>
    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
