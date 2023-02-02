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

// buscar xxx
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$NomeCompleto = $row['NomeCompleto'];
    }
} else {
	// não tem
}

// buscar xxx
$sql = "SELECT convenio_paciente.*, convenio.NomeConvenio
FROM convenio_paciente
INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
WHERE convenio_paciente.id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_convenio = $row['id_convenio'];
		$NomeConvenio = $row['NomeConvenio'];
    }
} else {
	$id_convenio = NULL;
	$NomeConvenio = 'Selecionar';
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

<h2>Convênio médico</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="index.php">Crianças</a></li>
	<li class="active"><a href="listar-convenio.php">Convênios</a></li>
</ul>

<div class="janela">
	<h3>Convênio da criança</h3>
	<li><label>Nome da criança:</label> <?php echo $NomeCompleto;?></li>
	<li>
		<form action="associar-convenio-paciente-2.php?id_paciente=<?php echo $id_paciente;?>" method="post" class="form-inline">
			<label>Convênio:</label>
			<select class="form-control" name="id_convenio">
			<?php
			echo '<option value="'.$id_convenio.'">'.$NomeConvenio.'</option>';
			// buscar xxx
			$sql = "SELECT * FROM convenio WHERE Status = 1 ORDER BY NomeConvenio ASC";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					// tem
					$id_convenio1 = $row['id_convenio'];
					$NomeConvenio1 = $row['NomeConvenio'];
					echo '<option value="'.$id_convenio1.'">'.$NomeConvenio1.'</option>';
			    }
			} else {
			}
			?>
			</select>
			<button type="submit" class="btn btn-success">Confirmar</button>
		</form>
	</li>
		
	<br>
	<!-- <a href="" class="btn btn-default" data-toggle="modal" data-target="#cadastrar">Associar convênio</a> -->
</div>
			</div>
    </div>
</div>

<!-- cadastrar -->
<div class="modal fade" id="cadastrar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="associar-convenio-paciente-2.php?id_paciente=<?php echo $id_paciente;?>" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Associar convênio para a criança</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
	                <div class="form-group">
	                	<label>Convênio</label>
	                    <select class="form-control" name="id_convenio">
	                    	<?php
							// buscar xxx
							$sql = "SELECT * FROM convenio WHERE Status = 1";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
							    while($row = $result->fetch_assoc()) {
									// tem
									$id_convenio = $row['id_convenio'];
									$NomeConvenio = $row['NomeConvenio'];
									echo '<option value="'.$id_convenio.'">'.$NomeConvenio.'</option>';
							    }
							} else {
								// não tem
							}
							?>
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

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>