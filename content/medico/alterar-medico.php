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

// data atual
date_default_timezone_set("America/Sao_Paulo");
$DataAtual = date("Y-m-d");

// buscar dados
$sql = "SELECT * FROM medico WHERE id_medico = '$id_medico'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeMedico = $row['NomeMedico'];
		$Crm = $row['Crm'];
		$Anotacao = $row['Anotacao'];
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

<h3>Alterar dados do medico</h3>
<form action="alterar-medico-2.php?id_medico=<?php echo $id_medico;?>" method="post" class="form-horizontal">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="control-label col-lg-3">Nome:</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" name="NomeMedico" value="<?php echo $NomeMedico;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-3">Registro CRM:</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" name="Crm" value="<?php echo $Crm;?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-3">E-mail:</label>
                <div class="col-lg-9">
                    <input type="email" class="form-control" name="EmailMedico" value="<?php echo $EmailMedico;?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-3">Celular:</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" name="Celular" value="<?php echo $Celular;?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-3">Telefone:</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" name="Telefone" value="<?php echo $Telefone;?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-3">Observação:</label>
                <div class="col-lg-9">
                    <textarea rows="5" class="form-control" name="Anotacao"><?php echo $Anotacao;?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-3"></label>
                <div class="col-lg-9">
                    <a href="medico.php?id_medico=<?php echo $id_medico;?>" class="btn btn-default">Fechar</a>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</form>

</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
