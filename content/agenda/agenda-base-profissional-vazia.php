<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
if (isset($_SESSION['id_profissional'])) {
	// voltar
	header("Location: agenda-base-profissional.php");
	exit;
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
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="" style="padding: 0 25px;">
        	<h3>Agenda base do terapeuta</h3>

			<!-- xxx -->
			<div style="margin-bottom: 15px;">
				<form action="agenda-base-profissional-selecionar-terapeuta.php" method="post" class="form-inline">
					<div class="form-group">
						<label>Nome</label>
						<select class="form-control" name="id_profissional" required>
							<option value="">Selecionar</option>
							<?php
							// buscar xxx
							$sql = "SELECT * FROM profissional WHERE Status = 1 ORDER BY NomeCompleto ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_profissionalX = $row['id_profissional'];
									$NomeCompleto = $row['NomeCompleto'];
									echo '<option value="'.$id_profissionalX.'">'.$NomeCompleto.'</option>';
							    }
							} else {
								// não tem
							}
							?>
						</select>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-success">Confirmar</button>
					</div>
				</form>
			</div>
		</div>
    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
</body>
</html>
