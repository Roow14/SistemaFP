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

if (empty($_SESSION['DataSessao'])) {
	$DataSessaoX = $DataAtual;
	$_SESSION['DataSessao'] = $DataAtual;
} else {
	$DataSessaoX = $_SESSION['DataSessao'];
}

// input
$id_paciente = $_GET['id_paciente'];
$id_pedido_medico = $_GET['id_pedido_medico'];
$id_categoria = $_GET['id_categoria'];

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
			$NomeDoutor = 'Selecionar';
		}
		// buscar xxx
		$sqlA = "SELECT * FROM diagnostico WHERE id_diagnostico = '$id_diagnostico'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeDiagnostico = $rowA['NomeDiagnostico'];
		    }
		} else {
			$NomeDiagnostico = 'Selecionar';
		}
    }
} else {
}


$sql = "SELECT * FROM pedido_medico_atividade WHERE id_pedido_medico = '$id_pedido_medico' AND id_categoria = '$id_categoria'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$NumeroSessoes = $row['NumeroSessoes'];
		$TotalHoras = $row['TotalHoras'];
		$id_categoria = $row['id_categoria'];
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
    }
} else {
}

if (empty($_SESSION['id_unidade'])) {
    $NomeUnidade = 'Selecionar';

} else {
    $id_unidade = $_SESSION['id_unidade'];
	// buscar xxx
	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$NomeUnidade = $row['NomeUnidade'];
	    }
	} else {
		$NomeUnidade = 'Selecionar';
	}
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

        <div id="conteudo" style="margin-top: -25px;">
<div class="row">
<div class="col-sm-3">
    <h3>Sessão</h3>
    <label>Nome do paciente:</label> <?php echo $NomeCompleto;?><br>
	<label>Nome social:</label> <?php echo $NomeCurto;?><br>
	<label>Nº pedido médido:</label> <?php echo $id_pedido_medico;?><br>
	<label>Categoria:</label> <?php echo $NomeCategoria;?><br>
	<label>Nº de sessões:</label> <?php echo $NumeroSessoes;?><br>
	<label>Total de horas:</label> <?php echo $TotalHoras;?><br>
	<a href="pedidos-medicos.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Voltar</a>
	<a href="agendar-sessao-1.php?id_paciente=<?php echo $id_paciente;?>& id_pedido_medico=<?php echo $id_pedido_medico;?>&id_categoria=<?php echo $id_categoria;?>" class="btn btn-default">Agendar sessão</a>

</div>
<div class="col-sm-9">
	<h3>Agenda</h3>
	<?php
	// buscar xxx
	$sql = "SELECT * FROM sessao WHERE id_paciente = '$id_paciente' AND id_pedido_medico = '$id_pedido_medico' ORDER BY DataSessao ASC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Data</th>';
		echo '<th>Hora</th>';
		echo '<th>Categoria</th>';
		echo '<th>Nº pedido</th>';
		echo '<th>Profissional</th>';
		echo '<th>Unidade</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	    while($row = $result->fetch_assoc()) {
			$DataSessao = $row['DataSessao'];
			$DataSessao1 = date("d/m/Y", strtotime($DataSessao));
			$id_hora = $row['id_hora'];
			$id_categoriaX = $row['id_categoria'];
			$id_pedido_medicoX = $row['id_pedido_medico'];
			$id_unidade = $row['id_unidade'];
			$id_profissionalX = $row['id_profissional'];
			// buscar xxx
			$sqlA = "SELECT * FROM categoria WHERE id_categoria = '$id_categoriaX'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$NomeCategoriaX = $rowA['NomeCategoria'];
			    }
			} else {
			}
			// buscar xxx
			$sqlA = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$Hora = $rowA['Hora'];
			    }
			} else {
			}
			// buscar xxx
			$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$NomeUnidade = $rowA['NomeUnidade'];
			    }
			} else {
			}
			// buscar xxx
			$sqlA = "SELECT * FROM profissional WHERE id_profissional = '$id_profissionalX'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					$NomeCompletoX = $rowA['NomeCompleto'];
					$NomeCurtoX = $rowA['NomeCurto'];
			    }
			} else {
			}
			echo '<tr>';
			echo '<td style="width: 100px;">'.$DataSessao1.'</td>';
			echo '<td style="width: 60px;">'.$Hora.'</td>';
			echo '<td>'.$NomeCategoriaX.'</td>';
			echo '<td>'.$id_pedido_medicoX.'</td>';
			echo '<td>'.$NomeCurtoX.'</td>';
			echo '<td>'.$NomeUnidade.'</td>';
			echo '</tr>';
	    }
	    echo '</tbody>';
		echo '</table>';
	} else {
		echo 'Não foi encontrado nenhuma sessão agendada.';
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
