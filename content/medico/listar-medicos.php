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

			<div class="row">
				<div class="col-sm-6">
					<h3>Médicos</h3>
					<?php
					// buscar dados
					$sql = "SELECT * FROM medico";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						?>
						<table class="table table-striped table-hover table-condensed">
						<thead>
						<tr>
						<th>Nome</th>
						</tr>
						</thead>
						<tbody>
							<?php
					    while($row = $result->fetch_assoc()) {
					    	$id_medico = $row['id_medico'];
							$NomeMedico = $row['NomeMedico'];

							echo '<tr>';
							echo '<td><a href="medico.php?id_medico='.$id_medico.'" class="Link">'.$NomeMedico.'</a></td>';
							echo '</tr>';
					    }
					    ?>
						</tbody>
						</table>
						<?php
					} else {
						echo 'Não encontramos nenhum médico cadastrado no sistema.';
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
