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
$Origem = 'convenio-paciente.php';

if (isset($_GET['id_paciente'])) {
	$id_paciente = $_GET['id_paciente'];
	$_SESSION['id_paciente'] = $id_paciente;
} elseif (isset($_SESSION['id_paciente'])) {
	$id_paciente = $_SESSION['id_paciente'];
} elseif (!empty($_POST['id_paciente']))	{
	$id_paciente = $_POST['id_paciente'];
	$_SESSION['id_paciente'] = $id_paciente;
} else {
	unset($_SESSION['id_paciente']);
}

if (isset($_POST['limpar'])) {
	unset($_SESSION['id_paciente']);
}

if (isset($id_paciente)) {
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
	.ajuste-botao {
		float: right;
		margin-top: -30px;
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
	<li class="inactive"><a href="index.php">Agenda do dia</a></li>
	<li class="inactive"><a href="relatorio-convenio-paciente.php">Criança</a></li>
	<li class="active"><a href="convenio-paciente.php">Convênios da criança</a></li>
	<li class="inactive"><a href="listar-convenio.php">Convênios</a></li>
	<li class="inactive"><a href="ajuda.php">Ajuda</a></li>
</ul>

<div class="janela">
	<h3>Convênio da criança</h3>

	<?php 
	if (isset($id_paciente)) {
		?>
		<li><label>Nome:</label> <?php echo $NomeCompleto;?></li>
		<div class="ajuste-botao">
			<form action="limpar-paciente-convenio-2.php" method="post">
				<input type="text" hidden name="limpar">
				<input type="text" hidden name="Origem" value="<?php echo $Origem;?>">
				<button type="submit" class="btn btn-default">Ver outra criança</button>
			</form>
		</div>
		<?php
	} else {
		?>
		
		<form action="" method="post" class="form-inline"><a href=""></a>
			<div class="form-group">
				<label>Nome da criança</label>
				<select class="form-control" name="id_paciente">
					<option value="">Selecionar</option>
					<?php
					// buscar xxx
					$sql = "SELECT * FROM paciente WHERE Status = 1 ORDER BY NomeCompleto ASC";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					    while($row = $result->fetch_assoc()) {
							// tem
							$id_pacienteX = $row['id_paciente'];
							$NomeCompletoX = $row['NomeCompleto'];
							echo '<option value="'.$id_pacienteX.'">'.$NomeCompletoX.'</option>';
					    }
					} else {
						// não tem
					}
					?>
				</select>
			</div>
			<button type="submit" class="btn btn-success">Confirmar</button>
		</form>
		<?php
	}

	if (isset($id_paciente)) {
		// buscar xxx
		$sql = "SELECT convenio_paciente.*, convenio.NomeConvenio
		FROM convenio_paciente
		INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
		WHERE convenio_paciente.id_paciente = '$id_paciente'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			echo '<table class="table table-striped table-hover table-condensed">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>ID</th>';
			echo '<th>Nome do convênio</th>';
			echo '<th>Observação</th>';
			// echo '<th>Ordem</th>';
			echo '<th>Status</th>';
			echo '<th style="width: 100px;">Ação</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
		    while($row = $result->fetch_assoc()) {
				// tem
				$id_convenio_paciente = $row['id_convenio_paciente'];
				$id_convenio = $row['id_convenio'];
				$NomeConvenio = $row['NomeConvenio'];
				$NotaConvenio = $row['NotaConvenio'];
				// $Ordem = $row['Ordem'];
				$StatusConvenio = $row['StatusConvenio'];
				if ($StatusConvenio == 1) {
					$NomeStatus = 'Ativo';
				} else {
					$NomeStatus = 'Inativo';
				}
				echo '<tr>';
				echo '<td>'.$id_convenio.'</td>';
				echo '<td>'.$NomeConvenio.'</td>';
				echo '<td>'.$NotaConvenio.'</td>';
				// echo '<td>'.$Ordem.'</td>';
				echo '<td>'.$NomeStatus.'</td>';
				echo '<td>';
				echo '<a href="alterar-convenio-paciente.php?id_convenio_paciente='.$id_convenio_paciente.'" class="btn btn-default">Alterar</a>';
				echo '</td>';
				echo '</tr>';
		    }
		    echo '</tbody>';
			echo '</table>';

			echo 'Nota: somente um convênio deve estar como ativo.';
		} else {
			echo '<br>';
			echo '<b>Nota:</b> Não foi encontrado nenhum convênio';
		}

		echo '<br>';
		echo '<br>';
		echo '<a href="" class="btn btn-default" data-toggle="modal" data-target="#cadastrar">Associar convênio</a>';	
	}
	?>
	
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
							$sql = "SELECT * FROM convenio WHERE StatusConvenio = 1";
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