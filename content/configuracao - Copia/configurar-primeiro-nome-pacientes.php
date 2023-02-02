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

			<div class="row">
				<h3>Primeiro nome</h3>
				<p>Obter somente o primeiro nome da partir um nome completo.</p>
<div class="row">
<div class="col-sm-8">
	<h3>Pacientes</h3>
	<?php
	// buscar xxx
	$sql = "SELECT * FROM paciente ORDER BY NomeCompleto ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Nome completo</th>';
		echo '<th>Nome social</th>';
		echo '<th style="width: 250px;">Ação</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	    while($row = $result->fetch_assoc()) {
			$id_paciente = $row['id_paciente'];
			$NomeCompleto = $row['NomeCompleto'];
			$NomeCurto = $row['NomeCurto'];	
			echo '<form action="alterar-primeiro-nome-paciente.php?id_paciente='.$id_paciente.'" method="post">';
			echo '<tr>';
			echo '<td><input type="text" class="form-control" name="NomeCompleto" value="'.$NomeCompleto.'"></td>';
			echo '<td style="width: 180px;"><input type="text" class="form-control" name="NomeCurto" value="'.$NomeCurto.'"></td>';
			echo '<td>';
			echo '<button type="submit" class="btn btn-default">Alterar</button>';
			echo '<a href="obter-primeiro-nome-pacientes.php?id_paciente='.$id_paciente.'&NomeCompleto='.$NomeCompleto.'" class="btn btn-default">Obter primeiro nome</a>';
			echo '</td>';
			echo '</tr>';
			echo '</form>';
	    }
	    echo '</tbody>';
		echo '</table>';
	} else {
	}
	?>
</div>
</div>

			</div>
		</div>
    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

<script type="text/javascript">
	
</script>
</body>
</html>
