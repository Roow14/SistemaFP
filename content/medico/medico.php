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
$id_medico = $_GET['id_medico'];

// buscar dados
$sql = "SELECT * FROM medico WHERE id_medico = '$id_medico'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeMedico = $row['NomeMedico'];
		if (empty($row['Crm'])) {$Crm = NULL;} else {$Crm = $row['Crm'];}
		if (empty($row['Anotacao'])) {$Anotacao = NULL;} else {$Anotacao = $row['Anotacao'];}
    }
} else {
}

// buscar dados
$sql = "SELECT * FROM email_medico WHERE id_medico = '$id_medico' AND Status = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$EmailMedico = $row['EmailMedico'];
    }
} else {
	$EmailMedico = NULL;
}

// buscar dados
$sql = "SELECT * FROM telefone_medico WHERE id_medico = '$id_medico' AND Tipo = 1 AND Status = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$Telefone = $row['Telefone'];
    }
} else {
	$Telefone = NULL;
}

// buscar dados
$sql = "SELECT * FROM telefone_medico WHERE id_medico = '$id_medico' AND Tipo = 3 AND Status = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$Celular = $row['Telefone'];
    }
} else {
	$Celular = NULL;
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

        <div id="conteudo">

			<div class="">

<div class="">
	<h3>Médico</h3>
	<label>Nome:</label> <?php echo $NomeMedico;?><br>
	<label>CRM:</label> <?php echo $Crm;?><br>
	<label>E-mail:</label> <?php echo $EmailMedico;?><br>
	<label>Celular:</label> <?php echo $Celular;?><br>
	<label>Telefone:</label> <?php echo $Telefone;?><br>
	<label>Observação:</label> <?php echo $Anotacao;?><br>
	<a href="alterar-medico.php?id_medico=<?php echo $id_medico;?>" class="btn btn-default">Alterar dados</a>
</div>

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
