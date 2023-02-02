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
$id_treino_paciente = $_GET['id_treino_paciente'];
$id_paciente = $_GET['id_paciente'];

// buscar xxx
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCompleto = $row['NomeCompleto'];
    }
} else {
}

// buscar xxx
$sql = "SELECT * FROM prog_treino_paciente WHERE id_treino_paciente = '$id_treino_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_objetivo_paciente = $row['id_objetivo_paciente'];

		// buscar xxx
		$sqlA = "SELECT prog_objetivo.* FROM prog_objetivo_paciente INNER JOIN prog_objetivo ON prog_objetivo_paciente.id_objetivo = prog_objetivo.id_objetivo WHERE prog_objetivo_paciente.id_objetivo_paciente = '$id_objetivo_paciente'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$id_objetivo = $rowA['id_objetivo'];
				$NomeObjetivo = $rowA['NomeObjetivo'];
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
    <?php include '../menu-lateral/menu-lateral-intervencao.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior-intervencao.php';?>

        <div id="conteudo">

			<div class="row">
<div class="col-sm-6">
	<h3>Alterar treino</h3>
	<label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>

	<!-- objetivo -->
	<form action="alterar-treino-objetivo-2.php?id_treino_paciente=<?php echo $id_treino_paciente;?>&id_paciente=<?php echo $id_paciente;?>" method="post" class="form-inline">
		<div class="form-group">
			<label>Objetivo comportamental:</label>
				<select class="form-control" name="id_objetivo" required>
					<option value="<?php echo $id_objetivo;?>"><?php echo $NomeObjetivo;?></option>
					<?php
					// buscar xxx
					$sql = "SELECT * FROM prog_objetivo ORDER BY NomeObjetivo ASC";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					    while($row = $result->fetch_assoc()) {
							$id_objetivo = $row['id_objetivo'];
							$NomeObjetivo = $row['NomeObjetivo'];
							echo '<option value="'.$id_objetivo.'">'.$NomeObjetivo.'</option>';
					    }
					} else {
					}
					?>
				</select>
			<button type="submit" class="btn btn-success">Confirmar</button>
		</div>
	</form>

	<!-- procedimento -->
	<div style="margin-top: 15px;">
		<?php
		// buscar xxx
		$sql = "SELECT prog_procedimento.* FROM prog_procedimento_paciente INNER JOIN prog_procedimento ON prog_procedimento_paciente.id_procedimento = prog_procedimento.id_procedimento WHERE prog_procedimento_paciente.id_objetivo_paciente = '$id_objetivo_paciente' ORDER BY prog_procedimento.NomeProcedimento ASC";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			echo '<table class="table table-striped table-hover table-condensed">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Procedimento</th>';
			echo '<th style="width: 80px;">Ação</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
		    while($row = $result->fetch_assoc()) {
				$id_procedimento = $row['id_procedimento'];
				$NomeProcedimento = $row['NomeProcedimento'];
				echo '<tr>';
				echo '<td>'.$NomeProcedimento.'</td>';
				echo '<td>';
				echo '<a href="alterar-treino-apagar-procedimento-2.php?id_treino_paciente='.$id_treino_paciente.'&id_paciente='.$id_paciente.'&id_procedimento='.$id_procedimento.'" class="btn btn-default">Apagar</a>';
				echo '</td>';
				echo '</tr>';
		    }
		    echo '</tbody>';
			echo '</table>';
		} else {
		}
		?>
	</div>

	<!-- adicionar procedimento -->
	<form action="alterar-treino-adicionar-procedimento-2.php?id_treino_paciente=<?php echo $id_treino_paciente;?>&id_paciente=<?php echo $id_paciente;?>" method="post" class="form-inline">
		<div class="form-group">
			<label>Adicionar procedimento:</label>
			<select class="form-control" name="id_procedimento" required>
				<option value="">Selecionar</option>
				<?php
				// buscar xxx
				$sql = "SELECT * FROM prog_procedimento ORDER BY NomeProcedimento ASC";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						$id_procedimento = $row['id_procedimento'];
						$NomeProcedimento = $row['NomeProcedimento'];
						echo '<option value="'.$id_procedimento.'">'.$NomeProcedimento.'</option>';
				    }
				} else {
				}
				?>
			</select>
			<button type="submit" class="btn btn-success">Confirmar</button>
		</div>
	</form>

	<!-- reforcador -->
	<div style="margin-top: 15px;">
		<?php
		// buscar xxx
		$sql = "SELECT prog_reforcador.* FROM prog_reforcador_paciente INNER JOIN prog_reforcador ON prog_reforcador_paciente.id_reforcador = prog_reforcador.id_reforcador WHERE prog_reforcador_paciente.id_objetivo_paciente = '$id_objetivo_paciente' ORDER BY prog_reforcador.NomeReforcador ASC";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			echo '<table class="table table-striped table-hover table-condensed">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Reforcador</th>';
			echo '<th style="width: 80px;">Ação</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
		    while($row = $result->fetch_assoc()) {
				$id_reforcador = $row['id_reforcador'];
				$NomeReforcador = $row['NomeReforcador'];
				echo '<tr>';
				echo '<td>'.$NomeReforcador.'</td>';
				echo '<td>';
				echo '<a href="alterar-treino-apagar-reforcador-2.php?id_treino_paciente='.$id_treino_paciente.'&id_paciente='.$id_paciente.'&id_reforcador='.$id_reforcador.'" class="btn btn-default">Apagar</a>';
				echo '</td>';
				echo '</tr>';
		    }
		    echo '</tbody>';
			echo '</table>';
		} else {
		}
		?>
	</div>

	<!-- adicionar reforcador -->
	<form action="alterar-treino-adicionar-reforcador-2.php?id_treino_paciente=<?php echo $id_treino_paciente;?>&id_paciente=<?php echo $id_paciente;?>" method="post" class="form-inline">
		<div class="form-group">
			<label>Adicionar reforçador:</label>
			<select class="form-control" name="id_reforcador" required>
				<option value="">Selecionar</option>
				<?php
				// buscar xxx
				$sql = "SELECT * FROM prog_reforcador ORDER BY NomeReforcador ASC";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						$id_reforcador = $row['id_reforcador'];
						$NomeReforcador = $row['NomeReforcador'];
						echo '<option value="'.$id_reforcador.'">'.$NomeReforcador.'</option>';
				    }
				} else {
				}
				?>
			</select>
			<button type="submit" class="btn btn-success">Confirmar</button>
		</div>
	</form>
	
	<!-- voltar -->
	<a href="treino.php?id_treino_paciente=<?php echo $id_treino_paciente;?>&id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Fechar alteração</a>
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
