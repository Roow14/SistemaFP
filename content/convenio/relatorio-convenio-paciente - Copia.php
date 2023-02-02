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
$Origem = 'relatorio-convenio-paciente.php';

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
	<li class="active"><a href="relatorio-convenio-paciente.php">Criança</a></li>
	<li class="inactive"><a href="convenio-paciente.php">Convênios da criança</a></li>
	<li class="inactive"><a href="listar-convenio.php">Convênios</a></li>
	<li class="inactive"><a href="listar-convenio-paciente.php">Com convênio</a></li>
	<li class="inactive"><a href="listar-paciente-sem-convenio.php">Sem convênio</a></li>
	<li class="inactive"><a href="relatorio-presenca.php">Presença</a></li>
	<li class="inactive"><a href="ajuda.php">Ajuda</a></li>
</ul>

<div class="janela">
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
	?>
	
<div>

<?php
if (isset($id_paciente)) {
	// buscar xxx
	$sql = "SELECT agenda_paciente.*, paciente.NomeCompleto, hora.Hora
	FROM agenda_paciente
	INNER JOIN paciente ON paciente.id_paciente = agenda_paciente.id_paciente
	INNER JOIN hora ON hora.id_hora = agenda_paciente.id_hora
	WHERE agenda_paciente.id_paciente = '$id_paciente'
	";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th style="width: 100px">Data</th>';
		echo '<th style="width: 100px">Hora</th>';
		echo '<th style="width: 250px">Categoria</th>';
		echo '<th style="width: 100px">Presença</th>';
		
		echo '<th>Convênio validado</th>';

	    while($row = $result->fetch_assoc()) {
			// tem
			$Data = $row['Data'];
			$DataX = date("d/m/Y", strtotime($Data));
			$NomeCompleto = $row['NomeCompleto'];
			$Hora = $row['Hora'];
			$id_agenda_paciente = $row['id_agenda_paciente'];
			// $Convenio = $row['Convenio'];
			// if ($Convenio == 2) {
			// 	$StatusConvenio = 'Validado';
			// } else {
			// 	$StatusConvenio = NULL;
			// }
			$id_convenio_validado = $row['id_convenio_validado'];
			$Presenca = $row['Presenca'];
			$id_categoria = $row['id_categoria'];
			// buscar xxx
			$sqlA = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$NomeCategoria = $rowA['NomeCategoria'];
			    }
			} else {
				// não tem
				$NomeCategoria = NULL;
			}


			if ($Presenca == 1) {
				$NomePresenca = 'Agendado';
			} 
			if ($Presenca == 2) {
				$NomePresenca = 'Realizado';
			} 
			if ($Presenca == 3) {
				$NomePresenca = 'Faltou';
			}
			if ($Presenca == 4) {
				$NomePresenca = 'Outros';
			}
			
			// buscar xxx
			$sqlA = "SELECT * FROM convenio WHERE id_convenio = '$id_convenio_validado'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$NomeConvenio = $rowA['NomeConvenio'];
			    }
			} else {
				// não tem
				$NomeConvenio = NULL;
			}

			echo '<tr>';
			echo '<td>'.$DataX.'</td>';
			echo '<td>'.$Hora.'</td>';
			echo '<td>'.$NomeCategoria.'</td>';
			echo '<td>'.$NomePresenca.'</td>';
			echo '<td>'.$NomeConvenio.'</td>';
			echo '</tr>';
	    }
	    echo '</tbody>';

	    echo '</table>';
	    echo '</form>';
	} else {
		// não tem
		echo '<div style="margin: 25px 0">';
		echo '<b>Nota:</b> Não foi encontrado nenhuma criança agendado para esta data.';
		echo '</div>';
	}
}
?>

			</div>
    </div>
</div>



<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>