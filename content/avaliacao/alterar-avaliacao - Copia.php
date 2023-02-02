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
$id_avaliacao = $_GET['id_avaliacao'];

// buscar dados
$sql = "SELECT * FROM fisiofor_agenda.paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
		$NomeCurto = $row['NomeCurto'];
    }
} else {
}

$sql = "SELECT * FROM avaliacao WHERE id_avaliacao = '$id_avaliacao'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$DataAvaliacao = $row['DataAvaliacao'];
		$DataInicio = $row['DataInicio'];
		$TituloAvaliacao = $row['TituloAvaliacao'];
		$Avaliacao = $row['Avaliacao'];
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

		<form action="alterar-avaliacao-2.php?id_paciente=<?php echo $id_paciente;?>&id_avaliacao=<?php echo $id_avaliacao;?>" method="post" style="margin-bottom: 25px;">
			<div class="row">
				<div class="form-group col-lg-6">
					<label>Título da avaliação</label>
					<input type="text" class="form-control" name="TituloAvaliacao" value="<?php echo $TituloAvaliacao;?>" required>
				</div>
				<div class="form-group col-lg-3">
					<label>Data da avaliação</label>
					<input type="date" class="form-control" name="DataAvaliacao" value="<?php echo $DataAvaliacao;?>" required>
				</div>
				<div class="form-group col-lg-3">
					<label>Data de início da terapia</label>
					<input type="date" class="form-control" name="DataInicio" value="<?php echo $DataInicio;?>">
				</div>
			</div>
			<div class="form-group">
				<label>Observação</label>
				<textarea id="editor" rows="15" class="form-control" name="Avaliacao"><?php echo $Avaliacao;?></textarea>
			</div>
			<p>Nota: Digite no final do parágrafo &lsaquo;br&rsaquo; para ir para o próximo parágrafo.</p>
			<a href="index.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Voltar</a>
			<button type="submit" class="btn btn-success">Confirmar</button>
			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Apagar">Apagar</button>
		</form>
	</div>
			</div>
		</div>
    </div>
</div>

<!-- Modal -->
<div id="Apagar" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Apagar a avaliação</h4>
			</div>
			<div class="modal-body">
				<p>Cuidado! A avaliação será removido do sistema.<br>Deseja continuar?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				<a href="apagar-avaliacao-2.php?id_paciente=<?php echo $id_paciente;?>&id_avaliacao=<?php echo $id_avaliacao;?>" class="btn btn-danger">Apagar</a>
			</div>
		</div>

	</div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>

<!-- editor de texto -->
<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
</body>
</html>
