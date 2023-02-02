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

<h3>Inserir nome social de pacientes</h3>
<p>Apenas para pacientes que não tem o <b>nome social</b> cadastrado.</p>
<p>Adicionar apenas o primeiro nome. <a href="adicionar-nome-social-paciente-2.php" class="btn btn-success">Confirmar</a></p>
<div>
	<?php
	// buscar xxx
	$sql = "SELECT * FROM paciente WHERE Status = 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Nome social</th>';
		echo '<th>Nome completo</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	    while($row = $result->fetch_assoc()) {
			$id_paciente = $row['id_paciente'];
			$NomeCurto = $row['NomeCurto'];
			$NomeCompleto = $row['NomeCompleto'];
			echo '<tr>';
			echo '<td>'.$NomeCurto.'</td>';
			echo '<td>'.$NomeCompleto.'</td>';
			echo '</tr>';
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

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
