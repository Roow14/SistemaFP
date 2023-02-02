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
$id_avaliacao = $_GET['id_avaliacao'];

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

// buscar xxx
$sql = "SELECT * FROM avaliacao WHERE id_avaliacao = '$id_avaliacao'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$DataAvaliacao = $row['DataAvaliacao'];
		$DataAvaliacao1 = date("d/m/Y", strtotime($DataAvaliacao));
		$Avaliacao = $row['Avaliacao'];
		$TituloAvaliacao = $row['TituloAvaliacao'];
    }
} else {
	$Avaliacao = NULL;
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
        if (empty($_SESSION['AtivarAlteracaoAvaliacao'])) {
        	?>
        	<h3>Avaliação</h3>
        	<label>Título:</label> <?php echo $TituloAvaliacao;?><br>
            <label>Data:</label> <?php echo $DataAvaliacao1;?><br>
            <label>Avaliação:</label> <?php echo $Avaliacao;?><br>

            <div style="margin-top: 15px;">
	            <a href="listar-avaliacoes.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Fechar</a>
	            <a href="ativar-alteracao-avaliacao.php?id_avaliacao=<?php echo $id_avaliacao;?>&id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Alterar</a>
	            
	            <?php
				if (empty($_SESSION['AtivarRemocaoAvaliacao'])) {
					echo '<a href="ativar-remocao-avaliacao.php?id_avaliacao='.$id_avaliacao.'&id_paciente='.$id_paciente.'" class="btn btn-default">Apagar</a>';
				} else {
				}
				?>            
	        </div>
            <?php
        } else {
			?>
			<div>
				<h3>Alterar avaliação</h3>
				<form action="alterar-avaliacao-2.php?id_paciente=<?php echo $id_paciente;?>&id_avaliacao=<?php echo $id_avaliacao;?>" method="post" class="form-horizontal">
			        <div class="">
			        	<div class="">
			            	
			            	<div class="form-group">
								<label class="control-label col-lg-2">Título:</label>
								<div class="col-lg-4">
									<input type="text" class="form-control" name="TituloAvaliacao" value="<?php echo $TituloAvaliacao;?>">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">Data:</label>
								<div class="col-lg-4">
									<input type="date" class="form-control" name="DataAvaliacao" value="<?php echo $DataAvaliacao;?>">
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-lg-2">Avaliação:</label>
								<div class="col-lg-9">
									<textarea rows="8" class="form-control" name="Avaliacao"><?php echo $Avaliacao;?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2"></label>
								<div class="col-lg-9">
									<a href="ativar-alteracao-avaliacao.php?id_avaliacao=<?php echo $id_avaliacao;?>&id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Fechar</a>
									<button type="submit" class="btn btn-success">Confirmar</button>
								</div>
							</div>
						</div>
			        </div>
			    </form>
			</div>
		<?php
        }
        if (empty($_SESSION['AtivarRemocaoAvaliacao'])) {
	    } else {
	    	?>
	    	<div style="clear: both; margin-bottom: 25px;"></div>
	    	<div class="alert alert-danger">
		    	<a href="cancelar-mensagem.php?id_paciente=<?php echo $id_paciente;?>&id_avaliacao=<?php echo $id_avaliacao;?>&Origem=avaliacao.php" style="float: right;">&#x2716;</a>
		    	<b>Cuidado:</b> a avaliação, relatórios e gráficos serão removidos completamente do sistema.<br>
		    	Deseja continuar?
		    	<div style="margin-top: 15px;">
			    	<a href="cancelar-mensagem.php?id_paciente=<?php echo $id_paciente;?>&id_avaliacao=<?php echo $id_avaliacao;?>&Origem=avaliacao.php" class="btn btn-default">Fechar</a>
			    	<a href="apagar-avaliacao-2.php?id_paciente=<?php echo $id_paciente;?>&id_avaliacao=<?php echo $id_avaliacao;?>" class="btn btn-danger">Apagar</a>
			    </div>
		    </div>
		    <?php
	    }         
        ?>
    </div>

	<div class="col-lg-6">
		<h3>Relatórios e gráficos</h3>

		<?php
		// buscar xxx
		$sql = "SELECT * FROM midia_avaliacao WHERE id_paciente = '$id_paciente' AND id_avaliacao = '$id_avaliacao'";
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
				$id_midia_avaliacao = $row['id_midia_avaliacao'];
				$ArquivoMidia = $row['ArquivoMidia'];

				echo '<tr>';
				echo '<td><a href="../../vault/avaliacao/'.$ArquivoMidia.'" class="Link" target="blank">'.$ArquivoMidia.'</a></td>';
				echo '<td><a href="ativar-remocao-arquivo-avaliacao.php?id_paciente='.$id_paciente.'&id_avaliacao='.$id_avaliacao.'" class="btn btn-default">Apagar avaliação</a></td>';
				echo '</tr>';
		    }
		    echo '</tbody>';
			echo '</table>';

			if (empty($_SESSION['ApagarArquivoAvaliacao'])) {

			} else {
				?>
				<div class="alert alert-danger">
					<b>Cuidado:</b> o arquivo será removido completamente do sistema.<br>
					Deseja continuar?
					<div style="margin-top: 15px;">
						<a href="ativar-remocao-arquivo-avaliacao.php?id_paciente=<?php echo $id_paciente;?>&id_avaliacao=<?php echo $id_avaliacao;?>" class="btn btn-default">Fechar</a>
						<a href="apagar-arquivo-avaliacao-2.php?id_midia_avaliacao=<?php echo $id_midia_avaliacao;?>&id_paciente=<?php echo $id_paciente;?>&id_avaliacao=<?php echo $id_avaliacao;?>" class="btn btn-danger">Apagar</a>
					</div>
				</div>
				<?php
			}

		} else {
		}
		?>
		<a href="importar-avaliacao.php?id_paciente=<?php echo $id_paciente;?>&id_avaliacao=<?php echo $id_avaliacao;?>" class="btn btn-default">Importar relatório ou gráfico</a>
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
