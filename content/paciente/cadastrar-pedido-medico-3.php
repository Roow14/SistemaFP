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
$id_pedido_medico = $_GET['id_pedido_medico'];

// buscar dados
$sql = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NomeCurto = $row['NomeCurto'];
		$NomeCompleto = $row['NomeCompleto'];
    }
} else {
}

// buscar xxx
$sql = "SELECT * FROM pedido_medico WHERE id_pedido_medico = '$id_pedido_medico'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_doutor = $row['id_doutor'];
		$id_diagnostico = $row['id_diagnostico'];
		$DataPedidoMedico = $row['DataPedidoMedico'];
		// buscar xxx
		$sqlA = "SELECT * FROM doutor WHERE id_doutor = '$id_doutor'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeDoutor = $rowA['NomeDoutor'];
		    }
		} else {
		}
		// buscar xxx
		$sqlA = "SELECT * FROM diagnostico WHERE id_diagnostico = '$id_diagnostico'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeDiagnostico = $rowA['NomeDiagnostico'];
		    }
		} else {
		}
    }
} else {
}

// print_r($_SESSION);
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
<h3>Cadastrar pedido médico</h3>
<p><label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>
<label>Nome social:</label> <?php echo $NomeCurto;?></p>

<!-- salvar sessão do doutor, data e diagnóstico -->
<div>
	<form action="cadastrar-pedido-medico-4.php?id_paciente=<?php echo $id_paciente;?>&id_pedido_medico=<?php echo $id_pedido_medico;?>" method="post" class="form-inline">
		<label>Doutor:</label>
		<select class="form-control" name="id_doutor" required>
			<option value="<?php echo $id_doutor;?>"><?php echo $NomeDoutor;?></option>
			<?php
			// buscar xxx
			$sql = "SELECT * FROM doutor";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					$id_doutor = $row['id_doutor'];
					$NomeDoutor = $row['NomeDoutor'];
					echo '<option value="'.$id_doutor.'">'.$NomeDoutor.'</option>';
			    }
			} else {
			}
			?>
		</select>

    	<div class="form-group">
    		<label>Data</label>
			<input type="date" class="form-control" name="DataPedidoMedico" value="<?php echo $DataPedidoMedico;?>" required>
    	</div>

    	<div class="form-group">
    		<label>Diagnóstico</label>
    		<select class="form-control" name="id_diagnostico" required>
    			<option value="<?php echo $id_diagnostico;?>"><?php echo $NomeDiagnostico;?></option>
    			<?php
    			// buscar xxx
				$sql = "SELECT * FROM diagnostico_paciente WHERE id_paciente = '$id_paciente'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						$id_diagnostico = $row['id_diagnostico'];
						// buscar xxx
						$sqlA = "SELECT * FROM diagnostico WHERE id_diagnostico = '$id_diagnostico'";
						$resultA = $conn->query($sqlA);
						if ($resultA->num_rows > 0) {
						    while($rowA = $resultA->fetch_assoc()) {
								$NomeDiagnostico = $rowA['NomeDiagnostico'];
						    }
						} else {
						}
						echo '<option value="'.$id_diagnostico.'">'.$NomeDiagnostico.'</option>';
				    }
				} else {
				}
				?>
    		</select>
    	</div>
		<button type="submit" class="btn btn-default">Alterar</button>
	</form>
</div>

<h3>Categoria e sessões</h3>
<div class="row">
<div class="col-sm-8">
<?php
// buscar xxx
$sql = "SELECT * FROM pedido_medico_atividade WHERE id_pedido_medico = '$id_pedido_medico' ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	?>
	<table class="table table-striped table-hover table-condensed">
	<thead>
	<tr>
	<th>Categoria</th>
	<th>Nº sessões</th>
	<th>Total de horas</th>
	<th>Ação</th>
	</tr>
	</thead>
	<tbody>
	<?php
    while($row = $result->fetch_assoc()) {
		$id_pedido_medico_atividade = $row['id_pedido_medico_atividade'];
		$id_categoria = $row['id_categoria'];
		$NumeroSessoes = $row['NumeroSessoes'];
		$TotalHoras = $row['TotalHoras'];
		// buscar xxx
		$sqlA = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeCategoria = $rowA['NomeCategoria'];
		    }
		} else {
			$NomeCategoria = 'Selecionar';
		}
		echo '<form action="alterar-atividade-pedido-medico.php?id_pedido_medico_atividade='.$id_pedido_medico_atividade.'&id_pedido_medico='.$id_pedido_medico.'&id_paciente='.$id_paciente.'" method="post">';
		echo '<tr>';
		echo '<td>';
		?>
		<select class="form-control" name="id_categoria">
			<option value="<?php echo $id_categoria;?>"><?php echo $NomeCategoria;?></option>
			<?php
			// buscar xxx
			$sqlA = "SELECT * FROM categoria ORDER BY NomeCategoria ASC";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$id_categoria = $rowA['id_categoria'];
					$NomeCategoria = $rowA['NomeCategoria'];
					echo '<option value="'.$id_categoria.'">'.$NomeCategoria.'</option>';
			    }
			} else {
			}
			?>
		</select>
		<?php
		echo '</td>';
		echo '<td><input type="number" class="form-control" name="NumeroSessoes" value="'.$NumeroSessoes.'"></td>';
		echo '<td><input type="text" class="form-control" name="TotalHoras" value="'.$TotalHoras.'"></td>';
		echo '<td style="width: 180px;">
		<button type="submit" class="btn btn-default">Confirmar</button>
		<a href="apagar-atividade-pedido-medico.php?id_pedido_medico_atividade='.$id_pedido_medico_atividade.'&id_pedido_medico='.$id_pedido_medico.'&id_paciente='.$id_paciente.'" class="btn btn-default">apagar</a>
		</td>';
		echo '</tr>';
		echo '</form>';
    }
    ?>
    </tbody>
	</table>
    <?php
} else {
	echo 'Não encontramos nenhuma atividade cadastrada.';
}
?>
</div>
</div>
<div>
<a href="adicionar-linha-pedido-medico.php?id_pedido_medico=<?php echo $id_pedido_medico;?>&id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Adicionar atividade</a>
</div>
		</div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
