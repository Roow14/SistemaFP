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
$id_pedido_medico = $_GET['id_pedido_medico'];

// buscar xxx
$sql = "SELECT * FROM pedido_medico WHERE id_pedido_medico = '$id_pedido_medico'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_medico = $row['id_medico'];
		$DataPedidoMedico = $row['DataPedidoMedico'];
		$DataPedidoMedico1 = date("d/m/Y", strtotime($DataPedidoMedico));
		$Observacao = $row['Observacao'];

		// buscar xxx
		$sqlA = "SELECT * FROM medico WHERE id_medico = '$id_medico'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeMedico = $rowA['NomeMedico'];
		    }
		} else {
		}
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
<div class="row">
	<div class="col-lg-6">
        <?php
        if (empty($_SESSION['AtivarAlteracaoPedidoMedico'])) {
        	?>
        	<h3>Exames</h3>
        	<label>Médico:</label> <?php echo $NomeMedico;?><br>
            <label>Data:</label> <?php echo $DataPedidoMedico1;?><br>
            <label>Exames:</label><br>
            <?php
			// buscar xxx
			$sql = "SELECT DISTINCT exame.*, exame_paciente.* FROM exame_paciente INNER JOIN exame ON exame_paciente.id_exame = exame.id_exame WHERE exame_paciente.id_pedido_medico = '$id_pedido_medico'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					$id_exame_paciente = $row['id_exame_paciente'];
					$id_exame = $row['id_exame'];
					$NomeExame = $row['NomeExame'];
					echo '<li>'.$NomeExame.'</li>';
			    }
			} else {
			}
			?>
            <label>Observação:</label> <?php echo $Observacao;?><br>

            <div style="margin-top: 15px;">
	            <a href="listar-pedidos-medicos.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Fechar</a>
	            <a href="ativar-alteracao-pedido-medico.php?id_pedido_medico=<?php echo $id_pedido_medico;?>&id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Alterar</a>
	            
	            <?php
				if (empty($_SESSION['AtivarRemocaoPedidoMedico'])) {
					echo '<a href="ativar-remocao-pedido-medico.php?id_pedido_medico='.$id_pedido_medico.'&id_paciente='.$id_paciente.'" class="btn btn-default">Apagar</a>';
				} else {
				}
				?>            
	        </div>
            <?php
        } else {
			?>
			<div>
				<h3>Alterar exame</h3>
				<form action="alterar-pedido-medico-2.php?id_paciente=<?php echo $id_paciente;?>&id_pedido_medico=<?php echo $id_pedido_medico;?>" method="post" class="form-horizontal">
			        <div class="">
			        	<div class="">
			            	<div class="form-group">
								<label class="control-label col-lg-2">Nome:</label>
								<div class="col-lg-4">
									<select class="form-control" name="id_medico" required>
										<option value="<?php echo $id_medico;?>"><?php echo $NomeMedico;?></option>						
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
									<input type="date" class="form-control" name="DataPedidoMedico" value="<?php echo $DataPedidoMedico;?>">
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
												// buscar xxx
												$sqlA = "SELECT * FROM exame_paciente WHERE id_exame = '$id_exame' AND id_pedido_medico = '$id_pedido_medico'";
												$resultA = $conn->query($sqlA);
												if ($resultA->num_rows > 0) {
												    while($rowA = $resultA->fetch_assoc()) {

														echo '<a href="alterar-item-exame-2.php?id_exame='.$id_exame.'&id_paciente='.$id_paciente.'&id_pedido_medico='.$id_pedido_medico.'">&#x2611;</a> '.$NomeExame.'<br>';

												    }
												} else {
													echo '<a href="alterar-item-exame-2.php?id_exame='.$id_exame.'&id_paciente='.$id_paciente.'&id_pedido_medico='.$id_pedido_medico.'">&#x2610;</a> '.$NomeExame.'<br>';
												}
												
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
									<textarea rows="8" class="form-control" name="Observacao"><?php echo $Observacao;?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2"></label>
								<div class="col-lg-9">
									<a href="ativar-alteracao-pedido-medico.php?id_pedido_medico=<?php echo $id_pedido_medico;?>&id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Fechar</a>
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
		<?php
        }
        if (empty($_SESSION['AtivarRemocaoPedidoMedico'])) {
	    } else {
	    	?>
	    	<div style="clear: both; margin-bottom: 25px;"></div>
	    	<div class="alert alert-danger">
		    	<a href="cancelar-mensagem.php?id_paciente=<?php echo $id_paciente;?>&id_pedido_medico=<?php echo $id_pedido_medico;?>&Origem=pedido-medico.php" style="float: right;">&#x2716;</a>
		    	<b>Cuidado:</b> Os exames serão removidos completamente do sistema.<br>
		    	Deseja continuar?
		    	<div style="margin-top: 15px;">
			    	<a href="cancelar-mensagem.php?id_paciente=<?php echo $id_paciente;?>&id_pedido_medico=<?php echo $id_pedido_medico;?>&Origem=pedido-medico.php" class="btn btn-default">Fechar</a>
			    	<a href="apagar-pedido-medico-2.php?id_paciente=<?php echo $id_paciente;?>&id_pedido_medico=<?php echo $id_pedido_medico;?>" class="btn btn-danger">Apagar</a>
			    </div>
		    </div>
		    <?php
	    }         
        ?>
    </div>

    <div class="col-lg-6">
    	<h3>Arquivo</h3>
    	
    	<?php
		// buscar xxx
		$sql = "SELECT * FROM midia_exame WHERE id_paciente = '$id_paciente' AND id_pedido_medico = '$id_pedido_medico'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			echo '<table class="table table-striped table-hover table-condensed">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Arquivo</th>';
			echo '<th>Ação</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
		    while($row = $result->fetch_assoc()) {
				$id_midia_exame = $row['id_midia_exame'];
				$ArquivoMidia = $row['ArquivoMidia'];

				echo '<tr>';
				echo '<td><a href="https://localhost/fisiopeti/vault/exame/'.$ArquivoMidia.'" class="Link" target="blank">'.$ArquivoMidia.'</a></td>';
				echo '<td><a href="ativar-remocao-arquivo-exame.php?id_paciente='.$id_paciente.'&id_pedido_medico='.$id_pedido_medico.'" class="btn btn-default">Apagar exame</a></td>';
				echo '</tr>';
		    }
		    echo '</tbody>';
			echo '</table>';

			if (empty($_SESSION['ApagarArquivoExame'])) {

			} else {
				?>
				<div class="alert alert-danger">
					<b>Cuidado:</b> o arquivo será removido completamente do sistema.<br>
					Deseja continuar?
					<div style="margin-top: 15px;">
						<a href="ativar-remocao-arquivo-exame.php?id_paciente=<?php echo $id_paciente;?>&id_pedido_medico=<?php echo $id_pedido_medico;?>" class="btn btn-default">Fechar</a>
						<a href="apagar-exame-2.php?id_midia_exame=<?php echo $id_midia_exame;?>&id_paciente=<?php echo $id_paciente;?>&id_pedido_medico=<?php echo $id_pedido_medico;?>" class="btn btn-danger">Apagar</a>
					</div>
				</div>
				<?php
			}

		} else {
		}
		?>
		<a href="importar-exame.php?id_paciente=<?php echo $id_paciente;?>&id_pedido_medico=<?php echo $id_pedido_medico;?>" class="btn btn-default">Importar exame</a>
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
