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

// input
$id_paciente = $_GET['id_paciente'];

// buscar dados
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCurto = $row['NomeCurto'];
		$NomeCompleto = $row['NomeCompleto'];
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
<h3>Cadastrar exame</h3>
<p><label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>

<!-- salvar sessão do doutor, data e diagnóstico -->
<div>
	<form action="cadastrar-pedido-medico-2.php?id_paciente=<?php echo $id_paciente;?>" method="post" class="form-horizontal">
        <div class="">
        	<div class="">
            	<div class="form-group">
					<label class="control-label col-lg-2">Nome:</label>
					<div class="col-lg-4">
						<select class="form-control" name="id_medico" required>
							<option value="">Selecionar</option>						
							<?php
							// buscar xxx
							$sql = "SELECT * FROM medico ORDER BY NomeMedico ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									$id_medico = $row['id_medico'];
									$NomeMedico = $row['NomeMedico'];
									echo '<option value="'.$id_medico.'">'.$NomeMedico.'</option>';
							    }
							} else {
							}
							?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-2">Data:</label>
					<div class="col-lg-4">
						<input type="date" class="form-control" name="DataPedidoMedico" value="<?php echo $DataAtual;?>">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-lg-2">Exames solicitados:</label>
					<div class="col-lg-9">
						<div class="checkbox">
							<?php
							// buscar xxx
							$sql = "SELECT * FROM exame ORDER BY NomeExame ASC ";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									$id_exame = $row['id_exame'];
									$NomeExame = $row['NomeExame'];
									echo '<label><input type="checkbox" name="Exame[]" value="'.$id_exame.'">'.$NomeExame.'</label><br>';
							    }
							} else {
							}
							?>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-lg-2">Observação:</label>
					<div class="col-lg-9">
						<textarea rows="6" class="form-control" name="Observacao"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-2"></label>
					<div class="col-lg-9">
						<button type="submit" class="btn btn-success">Confirmar</button>
					</div>
				</div>
			</div>
        </div>
    </form>

    <?php
    if (empty($_SESSION['ErroSelecaoMedico'])) {

    } else {
    	?>
    	<div class="alert alert-info col-lg-6">
	    	<a href="cancelar-mensagem.php?id_paciente=<?php echo $id_paciente;?>&Origem=cadastrar-pedido-medico.php" style="float: right;">&#x2715;</a>
	    	<b>Erro:</b> o nome do médico não foi selecionado.
	    </div>
	    <?php
    }
    ?>

    
</div>

		</div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
