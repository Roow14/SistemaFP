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
$id_diagnostico_paciente = $_GET['id_diagnostico_paciente'];

// buscar xxx
$sql = "SELECT * FROM diagnostico_paciente WHERE id_diagnostico_paciente = '$id_diagnostico_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_diagnostico = $row['id_diagnostico'];
		$DataDiagnostico = $row['DataDiagnostico'];
		$NotaDiagnostico = $row['NotaDiagnostico'];
    }
} else {
}

// buscar xxx
$sql = "SELECT * FROM diagnostico WHERE id_diagnostico = '$id_diagnostico'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeDiagnostico = $row['NomeDiagnostico'];
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
        	<h3>Alterar diagnóstico</h3>
        	
            <form action="alterar-diagnostico-paciente-2.php?id_paciente=<?php echo $id_paciente;?>&id_diagnostico_paciente=<?php echo $id_diagnostico_paciente;?>" method="post" required>
            	<div class="row">
	            	<div class="form-group col-sm-4">
	            		<label>Diagnóstico</label>
	            		<select class="form-control" name="id_diagnostico" required>
	            			<option value="<?php echo $id_diagnostico;?>"><?php echo $NomeDiagnostico;?></option>
	            			<?php
	            			// buscar xxx
							$sql = "SELECT * FROM diagnostico ORDER BY NomeDiagnostico ASC";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									$id_diagnostico = $row['id_diagnostico'];
									$NomeDiagnostico = $row['NomeDiagnostico'];
									echo '<option value="'.$id_diagnostico.'">'.$NomeDiagnostico.'</option>';
							    }
							} else {
							}
							?>
	            		</select>
	            		
	            	</div>
	            	<div class="form-group col-sm-3">
	            		<label>Data</label>
	        			<input type="date" class="form-control" name="DataDiagnostico" value="<?php echo $DataDiagnostico;?>" required>
	            	</div>
	            	<div class="form-group col-sm-12">
	            		<label>Nota</label>
	            		<textarea rows="5" class="form-control" name="NotaDiagnostico"><?php echo $NotaDiagnostico;?></textarea>
	            	</div>
	            </div>
	            <a href="diagnostico-paciente.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Voltar</a>
            	<button type="submit" class="btn btn-success">Confirmar</button>
            </form>
            
		</div>
    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
