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

			<div class="">
<div class="">
	<div>
		<h3>Avaliações</h3>
		<label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>

		<form action="adicionar-avaliacao.php?id_paciente=<?php echo $id_paciente;?>" method="post" style="margin-bottom: 25px;">
			<div class="row">
				<div class="form-group col-lg-6">
					<label>Título da avaliação</label>
					<input type="text" class="form-control" name="TituloAvaliacao" required>
				</div>
				<div class="form-group col-lg-3">
					<label>Data</label>
					<input type="date" class="form-control" name="DataAvaliacao" required>
				</div>
			</div>
			<div class="form-group">
				<label>Observação</label>
				<textarea rows="10" class="form-control" name="Avaliacao"></textarea>
			</div>
			<button type="submit" class="btn btn-success">Confirmar</button>
		</form>
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
