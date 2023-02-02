<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
$id_paciente = $_GET['id_paciente'];

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

        	<h3>Diagnósticos</h3>
			<div class="row">
<div class="col-lg-6">
	<label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>

	<?php
	if (empty($_SESSION['AtivarAlteracaoDiagnostico'])) {
		// buscar xxx
		$sql = "SELECT DISTINCT diagnostico.* FROM diagnostico_paciente INNER JOIN diagnostico ON diagnostico_paciente.id_diagnostico = diagnostico.id_diagnostico WHERE id_paciente = '$id_paciente' ORDER BY diagnostico.NomeDiagnostico ASC ";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			echo '<table class="table table-striped table-hover table-condensed">';
			echo '<thead>';
			echo '<tr>';
			if (empty($_SESSION['AtivarAlteracaoDiagnostico'])) {
			} else {
				echo '<th>Ação</th>';
			}
			echo '<th>Diagnóstico</th>';
			echo '<th>Nome</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
		    while($row = $result->fetch_assoc()) {
				$id_diagnostico = $row['id_diagnostico'];
				$NomeDiagnostico = $row['NomeDiagnostico'];
				$Cid = $row['Cid'];
				if (empty($row['Cid'])) {$Cid = NULL;} else {$Cid = $row['Cid'];}
				echo '<tr>';
				echo '<td>'.$NomeDiagnostico.'</td>';
				echo '<td>'.$Cid.'</td>';
				echo '</tr>';
		    }
		    echo '</tbody>';
			echo '</table>';
		} else {
		}
	} else {
		echo '<h3>Selecione os diagnósticos</h3>';
		// buscar xxx
		$sql = "SELECT * FROM diagnostico ORDER BY NomeDiagnostico ASC ";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			echo '<table class="table table-striped table-hover table-condensed">';
			echo '<thead>';
			echo '<tr>';
			
			echo '<th>Diagnóstico</th>';
			echo '<th>Nome</th>';
			if (empty($_SESSION['AtivarAlteracaoDiagnostico'])) {
			} else {
				echo '<th>Ação</th>';
			}

			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
		    while($row = $result->fetch_assoc()) {
				$id_diagnostico = $row['id_diagnostico'];
				$NomeDiagnostico = $row['NomeDiagnostico'];
				$Cid = $row['Cid'];
				if (empty($row['Cid'])) {$Cid = NULL;} else {$Cid = $row['Cid'];}

				echo '<tr>';

				echo '<td>'.$NomeDiagnostico.'</td>';
				echo '<td>'.$Cid.'</td>';

				// buscar xxx
				$sqlA = "SELECT * FROM diagnostico_paciente WHERE id_diagnostico = '$id_diagnostico' AND id_paciente = '$id_paciente'";
				$resultA = $conn->query($sqlA);
				if ($resultA->num_rows > 0) {
				    while($rowA = $resultA->fetch_assoc()) {
						echo '<td><a href="selecionar-diagnostico.php?id_diagnostico='.$id_diagnostico.'&id_paciente='.$id_paciente.'" class="btn btn-default">Selecionado</a></td>';
				    }
				} else {
					echo '<td><a href="selecionar-diagnostico.php?id_diagnostico='.$id_diagnostico.'&id_paciente='.$id_paciente.'" class="btn btn-default">Selecionar</a></td>';
				}
			
				echo '</tr>';
		    }
		    echo '</tbody>';
			echo '</table>';
		} else {
		}
	}

	if (empty($_SESSION['AtivarAlteracaoDiagnostico'])) {
		// buscar xxx
		$sql = "SELECT * FROM diagnostico_paciente WHERE id_paciente = '$id_paciente'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				$CheckDiagnostico = 1;
		    }
		} else {
			$CheckDiagnostico = 2;
		}

		if ($_SESSION['UsuarioNivel'] > 1) {
		    if ($CheckDiagnostico == 1) {
				echo '<a href="ativar-alteracao-diagnostico.php?id_paciente='.$id_paciente.'" class="btn btn-default" style="margin-right: 5px;">Alterar</a>';
				echo '<a href="https://cid10.com.br/" target="blank" class="btn btn-default">Consultar CID</a>';
			} else {
				echo '<a href="ativar-alteracao-diagnostico.php?id_paciente='.$id_paciente.'" class="btn btn-default">Adicionar diagnóstico</a>';
			}
		} else {
		}

			
	} else {
		$Origem = '../paciente/diagnostico-paciente.php';
		echo '<a href="ativar-alteracao-diagnostico.php?id_paciente='.$id_paciente.'" class="btn btn-default" style="margin-right: 5px;">Fechar alteração</a>';
		echo '<a href="../configuracao/configurar-diagnostico.php?id_paciente='.$id_paciente.'&Origem='.$Origem.'&id_paciente='.$id_paciente.'" class="btn btn-default" style="margin-right: 5px;">Cadastrar/alterar diagnóstico</a>';
		echo '<a href="https://cid10.com.br/" target="blank" class="btn btn-default">Consultar CID</a>';
	}
	?>
</div>

<div class="col-sm-6">
	<label>Observação</label><br>
	<?php
	if (empty($_SESSION['AtivarObservacao'])) {
	} else {
		?>
		<form action="adicionar-observacao.php?id_paciente=<?php echo $id_paciente;?>" method="post">
			<div class="form-group">
				<textarea rows="10" class="form-control" name="Observacao"></textarea>
			</div>
			<div class="form-group">
				<a href="ativar-observacao.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Fechar</a>
				<button type="submit" class="btn btn-success">Confirmar</button>
			</div>
		</form>
		<?php
	}
	// buscar xxx
	$sql = "SELECT * FROM diagnostico_observacao WHERE id_paciente = '$id_paciente' ORDER BY DataObservacao DESC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_observacao = $row['id_observacao'];
			$Observacao = $row['Observacao'];

			if (empty($_SESSION['AtivarAlteracaoObservacao'])) {
				echo '<div>';
				echo $Observacao.'<br>';

				if ($_SESSION['UsuarioNivel'] > 1) {
				    echo '<a href="ativar-alteracao-observacao.php?id_paciente='.$id_paciente.'&id_observacao='.$id_observacao.'" class="btn btn-default">Alterar</a>';
				} else {
				}
				
				echo '</div>';
			} else {
				echo '<div>';
				?>
				<form action="alterar-observacao-2.php?id_paciente=<?php echo $id_paciente;?>&id_observacao=<?php echo $id_observacao;?>" method="post">
					<div class="form-group">
						<textarea rows="10" class="form-control" name="Observacao"><?php echo $Observacao;?></textarea>
					</div>
					<a href="ativar-alteracao-observacao.php?id_paciente=<?php echo $id_paciente;?>&id_observacao=<?php echo $id_observacao;?>" class="btn btn-default">Fechar</a>
					<button type="submit" class="btn btn-success">Confirmar</button>
					<a href="apagar-observacao.php?id_paciente=<?php echo $id_paciente;?>&id_observacao=<?php echo $id_observacao;?>" class="btn btn-default">Apagar</a>
				</form>
				<?php
				echo '</div>';
			}
	    }
	} else {
		if (empty($_SESSION['AtivarObservacao'])) {
			echo '<a href="ativar-observacao.php?id_paciente='.$id_paciente.'" class="btn btn-default">Adicionar observação</a>';
		} else {

		}
	}

	// mensagem antes de apagar
	if (empty($_SESSION['ApagarObservacao'])) {

	} else {
		?>
		<div id="ApagarObservacao" class="alert alert-danger" style="width: 100%; margin-top: 15px;">
			<b>Cuidado</b>, a observação será removida completamente do sistema.<br>
			Deseja continuar?<br>
			<div style="padding-top: 5px;">
				<a href="apagar-observacao.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default" style="margin-right: 5px;">Fechar</a>
				<a href="apagar-observacao-2.php?id_paciente=<?php echo $id_paciente;?>&id_observacao=<?php echo $id_observacao;?>" class="btn btn-danger">Apagar</a>
			</div>
		</div>
		<?php
	}
	?>
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
