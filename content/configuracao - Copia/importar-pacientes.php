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

<h3>Importar dados de pacientes</h3>
<p>Importar dados da planilha excel em formato csv para o banco de dados.</p>
<p>Salvar a planilha como UTF-8 delimitado por vírgulas e sem o cabeçalho.</p>

<form class="form-inline" action="importar-pacientes-2.php" method="post" name="upload_excel" enctype="multipart/form-data">
    <div class="form-group">
        <label>Selecionar arquivo .csv</label>
        <input type="file" name="file" id="file" class="form-control">
    </div>
    <div class="form-group">
        <button type="submit" id="submit" name="Import" class="btn btn-success button-loading" data-loading-text="Loading...">Importar</button>
    </div>
</form>

<div style="margin-top: 25px;">
	<h3>Dados importados</h3>
	<p>Dados importados para a tabela <b>tmp_paciente</b>.</p>
	<p>Salvar os dados na tabela definitiva <b>paciente</b> <a href="importar-pacientes-3.php" class="btn btn-warning">Confirmar</a>
	<div class="">
		<div class="">
			
			<?php
			// buscar xxx
			$sql = "SELECT * FROM tmp_paciente ORDER BY NomeCompleto ASC";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo '<table class="table table-striped table-hover table-condensed">';
				echo '<thead>';
				echo '<tr>';
				echo '<th style="width: 120px;">Original</th>';
				echo '<th>Nome final</th>';
				echo '<th style="width: 120px;">Pais original</th>';
				echo '<th>Pai</th>';
				echo '<th>Mãe</th>';
				echo '<th style="width:80px;">Data de nascimento</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			    while($row = $result->fetch_assoc()) {
					$id_tmp_paciente = $row['id_tmp_paciente'];
					$NomeTmp = $row['NomeTmp'];
					$NomeCompleto = $row['NomeCompleto'];
					$Pais = $row['Pais'];
					$Pai = $row['Pai'];
					$Mae = $row['Mae'];
					$DataNascimento = $row['DataNascimento'];
					echo '<form action="alterar-dados-importar-pacientes.php?id_tmp_paciente='.$id_tmp_paciente.'" method="post">';
					echo '<tr id='.$id_tmp_paciente.'>';
					echo '<td>'.$NomeTmp.'</td>';
					echo '<td><input type="text" class="form-control" name="NomeCompleto" value="'.$NomeCompleto.'"></td>';
					echo '<td>'.$Pais.'</td>';
					echo '<td><input type="text" class="form-control" name="Pai" value="'.$Pai.'"></td>';
					echo '<td><input type="text" class="form-control" name="Mae" value="'.$Mae.'"></td>';
					echo '<td>'.$DataNascimento.'</td>';
					echo '<td><button type="submit" class="btn btn-default">Alterar</button></td>';
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

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

</body>
</html>
