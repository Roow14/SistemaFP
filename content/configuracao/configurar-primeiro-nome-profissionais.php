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

			<div class="">
				<h3>Primeiro nome</h3>
				<p>Obter somente o primeiro nome a partir um nome completo.</p>
<div class="">
	<h3>Profissionais</h3>
	<?php
	// buscar xxx
	$sql = "SELECT * FROM profissional ORDER BY NomeCompleto ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="NomeCompleto">Nome completo</th>';
		echo '<th>Nome social</th>';
		echo '<th style="width: 250px;">Ação</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	    while($row = $result->fetch_assoc()) {
			$id_profissional = $row['id_profissional'];
			$NomeCompleto = $row['NomeCompleto'];
			$NomeCurto = $row['NomeCurto'];	
			echo '<form action="alterar-primeiro-nome-profissional.php?id_profissional='.$id_profissional.'" method="post">';
			echo '<tr id='.$id_profissional.'>';
			echo '<td><input type="text" class="form-control" name="NomeCompleto" value="'.$NomeCompleto.'"></td>';
			echo '<td style="width: 180px;"><input type="text" class="form-control" name="NomeCurto" value="'.$NomeCurto.'"></td>';
			echo '<td>';
			echo '<button type="submit" class="btn btn-default">Alterar</button>';
			echo '<a href="obter-primeiro-nome-profissionais.php?id_profissional='.$id_profissional.'&NomeCompleto='.$NomeCompleto.'" class="btn btn-default">Obter primeiro nome</a>';
			echo '</td>';
			echo '</form>';
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
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

<script type="text/javascript">
	
</script>
</body>
</html>
