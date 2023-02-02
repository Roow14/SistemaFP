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

<h3>Importar dados de atendimento</h3>
<p>Importar dados da planilha excel em formato csv para o banco de dados.</p>
<p>Salvar a planilha como UTF-8 delimitado por vírgulas e sem o cabeçalho.</p>

<form class="form-inline" action="importar-atendimento-2.php" method="post" name="upload_excel" enctype="multipart/form-data">
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
	</p>
	<p>Dados importados na tabela <b>agenda_paciente_tmp</b>. 
	<a href="importar-atendimento-4.php" class="btn btn-default">Obter ids</a>
	<a href="importar-atendimento-3.php" class="btn btn-warning">Salvar os dados na tabela definitiva</a></p>
	<div class="">
		<div class="">			
			<?php
			// buscar xxx
			$sql = "SELECT * FROM agenda_paciente_tmp";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo '<table class="table table-striped table-hover table-condensed">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>id_paciente</th>';
				echo '<th>Paciente</th>';
				echo '<th>id_hora</th>';
				echo '<th>Hora</th>';
				echo '<th>DiaSemana</th>';
				echo '<th>id_categoria</th>';
				echo '<th>Categoria</th>';
				echo '<th>id_profissional</th>';
				echo '<th>Profissional</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			    while($row = $result->fetch_assoc()) {
					$id_agenda_paciente_tmp = $row['id_agenda_paciente_tmp'];
					$NomePaciente = $row['NomePaciente'];
					$Hora = $row['Hora'];
					$DiaSemana = $row['DiaSemana'];
					$NomeCategoria = $row['NomeCategoria'];
					$NomeProfissional = $row['NomeProfissional'];
					$id_hora = $row['id_hora'];
					$id_categoria = $row['id_categoria'];
					$id_paciente = $row['id_paciente'];
					$id_profissional = $row['id_profissional'];

					echo '<tr id='.$id_agenda_paciente_tmp.'>';
					echo '<td>'.$id_paciente.'</td>';
					echo '<td>'.$NomePaciente.'</td>';
					echo '<td>'.$id_hora.'</td>';
					echo '<td>'.$Hora.'</td>';
					echo '<td>'.$DiaSemana.'</td>';
					echo '<td>'.$id_categoria.'</td>';
					echo '<td>'.$NomeCategoria.'</td>';
					echo '<td>'.$id_profissional.'</td>';
					echo '<td>'.$NomeProfissional.'</td>';
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

</body>
</html>
