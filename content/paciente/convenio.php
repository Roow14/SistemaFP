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
$id_convenio = $_GET['id_convenio'];

// buscar xxx
$sql = "SELECT * FROM convenio WHERE id_convenio = '$id_convenio'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_convenio = $row['id_convenio'];
		$NomeConvenio = $row['NomeConvenio'];
		$Nota = $row['Nota'];
		$StatusConvenio = $row['StatusConvenio'];
		if ($StatusConvenio == 1) {
			$NomeStatus = 'Ativo';
		} else {
			$NomeStatus = 'Inativo';
		}
    }
} else {
}

// verificar se foi utilizado em agenda
$sql = "SELECT * FROM agenda_paciente WHERE id_convenio = '$id_convenio'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$Check = 1;
    }
} else {
	// não tem
	$Check = 2;
}
?>

<!DOCTYPE html>
<html>
<!-- header -->
<?php include '../header/head.php';?>

<style type="text/css">
	.janela {
	    background-color: #fafafa;
	    /*min-height: 300px;*/
	    padding: 15px;
	    border-left: 1px solid #ddd;
	    border-right: 1px solid #ddd;
	    border-bottom: 1px solid #ddd;
	    border-radius: 4px;
	}
	.conteudo {

	}
	li {
		list-style: none;
	}
	.Link {
		background-color: transparent;
		border: none;
	}
	input[type=checkbox] {
	    transform: scale(1.3);
        margin: 5px 10px;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Pacientes</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../paciente/">Lista</a></li>
	<li class="inactive"><a href="../paciente/paciente.php">Paciente</a></li>
	<li class="inactive"><a href="../paciente/escola-paciente.php">Escola</a></li>
	<li class="active"><a href="../paciente/convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Plano terapêutico</a></li>
	<li class="inactive"><a href="../configuracao/relatorio-agenda-paciente.php">Agenda</a></li>
</ul>

<div class="janela">
	<h3>Convênio</h3>
	<li><label>Nome:</label> <?php echo $NomeConvenio;?></li>
	<li><label>Observação:</label> <?php echo $Nota;?></li>
	<li><label>Status:</label> <?php echo $NomeStatus;?></li>

	<a href="convenio-paciente.php" class="btn btn-default">Fechar</a>
	<a href="" class="btn btn-default" data-toggle="modal" data-target="#alterar">Alterar</a>
	<?php
	if ($Check == 1) {
		// foi utilizado na agenda
		echo '<a href="" class="btn btn-default" data-toggle="modal" data-target="#naoapagar">Apagar</a>';
	} else {
		echo '<a href="" class="btn btn-default" data-toggle="modal" data-target="#apagar">Apagar</a>';
	}
	?>
	
</div>
			</div>
    </div>
</div>

<!-- alterar -->
<div class="modal fade" id="alterar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="alterar-convenio-2.php?id_convenio=<?php echo $id_convenio;?>" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cadastrar convênio</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                	<div class="form-group">
	                	<label>Nome</label>
	                    <input type="text" name="NomeConvenio" class="form-control" value="<?php echo $NomeConvenio;?>" required>
	                </div>
	                <div class="form-group">
	                	<label>Observação</label>
	                    <textarea rows="3" class="form-control" name="Nota"><?php echo $Nota;?></textarea>
	                </div>
	                <div class="form-group">
	                	<label>Status</label>
	                    <select class="form-control" name="StatusConvenio">
	                    	<option value="<?php echo $StatusConvenio;?>"><?php echo $NomeStatus;?></option>
	                    	<option value="1">Ativo</option>
	                    	<option value="2">Inativo</option>
	                    </select>
	                </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>    
        </div>

    </div>
</div>

<!-- apagar -->
<div class="modal fade" id="apagar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="apagar-convenio-2.php?id_convenio=<?php echo $id_convenio;?>" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Apagar</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                	O convênio será removido, deseja continuar?
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-danger">Apagar</button>
                </div>
            </form>    
        </div>

    </div>
</div>

<!-- não apagar -->
<div class="modal fade" id="apagar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Não pode ser apagado</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                	O convênio não pode ser apagado porque foi utilizado em uma agenda do paciente.<br>
                	Altere o status do convênio para inativo.
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
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