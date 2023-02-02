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
$tmp = 'tmp_'.$_SESSION['UsuarioID'];
$Origem = 'relatorio-convenio.php';

if (!empty($_SESSION['FiltroSemConvenio'])) {
	$FiltroConvenio = NULL;
	$FiltroSemConvenio = 1;
	$NomeConvenio = 'Sem convênio';
	$id_convenio = 99;
} else {
	if (!empty($_SESSION['id_convenio'])) {
		$id_convenio = $_SESSION['id_convenio'];
		// buscar xxx
		$sql = "SELECT * FROM convenio WHERE id_convenio = '$id_convenio'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$NomeConvenio = $row['NomeConvenio'];
		    }
		} else {
			// não tem
		}
		$FiltroConvenio = 'AND convenio_paciente.id_convenio = '.$id_convenio;
	} else {
		$FiltroConvenio = NULL;
		$id_convenio = NULL;
		$NomeConvenio = 'Selecionar';
	}
	$FiltroSemConvenio = NULL;
}

if (!empty($_SESSION['FiltroSemConvenio'])) {
	// pacientes sem convenio

	// apagar tabela
	$sql = "DROP TABLE $tmp";
	if ($conn->query($sql) === TRUE) {
	} else {
	}

	// criar tabela temporária
	$sql = "CREATE TABLE $tmp (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	id_paciente VARCHAR(30)
	)";
	if ($conn->query($sql) === TRUE) {
	} else {
	}

	// buscar pacientes sem convenio e inserir na tabela temporária
	$sql = "SELECT * FROM paciente WHERE Status = 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_paciente = $row['id_paciente'];

			// buscar xxx
			$sqlA = "SELECT convenio_paciente.*, convenio.NomeConvenio FROM convenio_paciente
			INNER JOIN convenio ON convenio.id_convenio = convenio_paciente.id_convenio
			WHERE convenio_paciente.id_paciente = '$id_paciente' AND convenio_paciente.StatusConvenio = 1
			$FiltroConvenio";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
			    }
			} else {
				// não tem convenio
				// inserir na tabela temporaria
				$sqlB = "INSERT INTO $tmp (id_paciente) VALUES ('$id_paciente')";
				if ($conn->query($sqlB) === TRUE) {
				} else {
				}
			}		
	    }
	} else {
		// não tem
	}

	// buscar o último id e utilizar como soma
	$sql = "SELECT * FROM $tmp ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$Soma = $row['id'];
	    }
	} else {
		// não tem
	}
} else {
	// pacientes com convenio ou filtro sem convenio

	// apagar tabela
	$sql = "DROP TABLE $tmp";
	if ($conn->query($sql) === TRUE) {
	} else {
	}

	if (!empty($_SESSION['id_convenio'])) {
		// buscar pacientes com convenio
		$sql = "SELECT COUNT(paciente.id_paciente) AS Soma 
		FROM paciente
		INNER JOIN convenio_paciente ON paciente.id_paciente = convenio_paciente.id_paciente
		WHERE paciente.Status = 1 AND convenio_paciente.StatusConvenio = 1 AND convenio_paciente.id_convenio = '$id_convenio'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			// tem
			while($row = $result->fetch_assoc()) {
				$Soma = $row['Soma'];
			}
		// não tem
		} else {
		}
	} else {
		// buscar todos os pacientes
		$sql = "SELECT COUNT(paciente.id_paciente) AS Soma 
		FROM paciente
		WHERE paciente.Status = 1";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			// tem
			while($row = $result->fetch_assoc()) {
				$Soma = $row['Soma'];
			}
		// não tem
		} else {
		}
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
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Convênio/paciente</h2>

<ul class="nav nav-tabs">
	<!-- <li class="inactive"><a href="index.php">Agenda do dia</a></li>
	<li class="inactive"><a href="relatorio-convenio-paciente.php">Criança</a></li>
	<li class="inactive"><a href="convenio-paciente.php">Convênios da criança</a></li> -->
	<li class="active"><a href="relatorio-convenio.php">Home</a></li>
	<!-- <li class="inactive"><a href="listar-paciente-sem-convenio.php">Sem convênio</a></li> -->
	<!-- <li class="inactive"><a href="relatorio-presenca.php">Presença</a></li>
	<li class="inactive"><a href="ajuda.php">Ajuda</a></li> -->
</ul>

<div class="janela">
<form action="relatorio-convenio-filtro-2.php" method="post" class="form-inline">
	<div class="form-group">
		<label>Filtrar por convênio:</label>
		<select class="form-control" name="id_convenio">
			<?php
			echo '<option value="'.$id_convenio.'">'.$NomeConvenio.'</option>';
			// buscar xxx
			$sql = "SELECT * FROM convenio WHERE StatusConvenio = 1 ORDER By NomeConvenio ASC";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
					// tem
					$id_convenioX = $row['id_convenio'];
					$NomeConvenioX = $row['NomeConvenio'];
					echo '<option value="'.$id_convenioX.'">'.$NomeConvenioX.'</option>';
			    }
			} else {
				// não tem
			}
			echo '<option value="99">Sem convênio</option>';
			echo '<option value="">Limpar convênio</option>';
			?>
		</select>
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-success">Confirmar</button>
	</div>
</form>

<label>Total de itens:</label> <?php echo $Soma;?>

<?php
// buscar xxx
$sql = "SELECT * FROM paciente WHERE Status = 1
ORDER BY paciente.NomeCompleto ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>ID</th>';
	echo '<th>Nome</th>';
	echo '<th>Convênio</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$NomeCompleto = $row['NomeCompleto'];
		// buscar xxx
		$sqlA = "SELECT convenio_paciente.*, convenio.NomeConvenio FROM convenio_paciente
		INNER JOIN convenio ON convenio.id_convenio = convenio_paciente.id_convenio
		WHERE convenio_paciente.id_paciente = '$id_paciente' AND convenio_paciente.StatusConvenio = 1
		$FiltroConvenio";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeConvenio = $rowA['NomeConvenio'];
				if (empty($FiltroSemConvenio)) {
					echo '<tr>';
					echo '<td>'.$id_paciente.'</td>';
					echo '<td>'.$NomeCompleto.'</td>';
					echo '<td>'.$NomeConvenio.'</td>';
					echo '</tr>';
				}
		    }
		} else {
			// não tem
			if (empty($FiltroConvenio)) {
				echo '<tr>';
				echo '<td>'.$id_paciente.'</td>';
				echo '<td>'.$NomeCompleto.'</td>';
				echo '<td></td>';
				echo '</tr>';
			}
		}		
    }
    echo '</tbody>';
	echo '</table>';
} else {
	// não tem
}
?>
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