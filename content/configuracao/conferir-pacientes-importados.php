<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';
	
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

			<div class="">
<div class="">
	<h3>Pacientes</h3>
	<p>Conferir os dados da tabela temporária e salvar para a tabela definitiva <b>paciente</b>.<a href="conferir-pacientes-importados-2.php" class="btn btn-default">Salvar na tabela definitiva</a></p>
	<?php
	// buscar dados
	$sql = "SELECT * FROM tmp_paciente_1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Nome social</th>';
		echo '<th>Nome completo</th>';
		echo '<th>Pai</th>';
		echo '<th>Mãe</th>';
		echo '<th>Data de nascimento</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	    while($row = $result->fetch_assoc()) {
	    	$id_tmp_paciente_1 = $row['id_tmp_paciente_1'];
			$NomeCompleto = $row['NomeCompleto'];
			$NomeCurto = $row['NomeCurto'];
			$Pai = $row['Pai'];
			$Mae = $row['Mae'];
			$DataNascimento = $row['DataNascimento'];
			$Status = $row['Status'];

			echo '<tr>';
			echo '<td>'.$NomeCurto.'</td>';
			echo '<td>'.$NomeCompleto.'</td>';
			echo '<td>'.$Pai.'</td>';
			echo '<td>'.$Mae.'</td>';
			echo '<td>'.$DataNascimento.'</td>';

			echo '</tr>';
	    }
		echo '</tbody>';
		echo '</table>';
	} else {
		echo 'Não encontramos nenhum paciente.';
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
