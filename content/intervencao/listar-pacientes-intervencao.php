<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// filtro por paciente
if (empty($_SESSION['PesquisaPaciente'])) {
	$PesquisaPaciente = NULL;
	$FiltroPaciente = NULL;
} else {
	$PesquisaPaciente = $_SESSION['PesquisaPaciente'];
	$FiltroPaciente = 'AND NomeCompleto LIKE "%'.$PesquisaPaciente.'%"';
}

if (empty($_SESSION['StatusPaciente'])) {
	$StatusPaciente = NULL;
	$FiltroStatus = 'WHERE Status = 1';
	$NomeStatusPaciente = 'Ativo';
} else {
	$StatusPaciente = $_SESSION['StatusPaciente'];
	if ($StatusPaciente == 1) {
		$NomeStatusPaciente = 'Ativo';
		$FiltroStatus = 'WHERE Status = '. $StatusPaciente;
	} elseif ($StatusPaciente == 3) {
		$NomeStatusPaciente = 'Ativos e inativos';
		$FiltroStatus = NULL;
	} else {
		$NomeStatusPaciente = 'Inativo';
		$FiltroStatus = 'WHERE Status = '. $StatusPaciente;
	}
}

$sql = "SELECT COUNT(id_paciente) AS Soma FROM paciente $FiltroStatus $FiltroPaciente";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// tem
	while($row = $result->fetch_assoc()) {
		$Soma = $row['Soma'];
	}
// não tem
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
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">
<div>
	<h3>Pacientes</h3>
	<form action="aplicar-filtro-lista-pacientes-intervencao.php" method="post" class="form-inline" style="margin-bottom: 5px;">     	
    	<label>Paciente:</label>
    	<input type="text" name="PesquisaPaciente" class="form-control" value="<?php echo $PesquisaPaciente;?>" placeholder="Nome">

    	<label>Status</label>
    	<select name="StatusPciente" class="form-control">
    		<option value="<?php echo $StatusPaciente;?>"><?php echo $NomeStatusPaciente;?></option>
    		<option value="1">Ativo</option>
    		<option value="2">Inativo</option>
    		<option value="3">Todos</option>
    	</select>

    	<button type="submit" class="btn btn-success">Confirmar</button>
    </form>

    <?php
	if ((empty($_SESSION['PageOffset']))) {
	    $PageOffset = NULL;
	    $PageOffset1 = NULL;
	} else {
	    $PageOffset = $_SESSION['PageOffset'];
	    $PageOffset1 = 'OFFSET '.$PageOffset;
	}

	// buscar xxx
	$id_usuario = $_SESSION['UsuarioID'];
	$sql = "SELECT * FROM configuracao WHERE Variavel = 'ItensPorPagina' AND id_usuario = '$id_usuario'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        // tem
	        $ItensPorPagina = $row['Valor'];
	    }
	} else {
	    // não tem
	    $ItensPorPagina = 10;
	}

	$TotalPaginas = round($Soma / $ItensPorPagina);
	if ($TotalPaginas == 0) {
		$TotalPaginas = 1;
	}
	$Razao = $Soma / $TotalPaginas;
	if ($Razao < 1) {
		$TotalPaginas = 1;
	}
	$NumeroPagina = ($PageOffset / $ItensPorPagina) + 1; 

	echo '<p><span style="margin-right: 15px;"><label>Total:</label> '.$Soma.'</span><label>Página:</label> '.$NumeroPagina.'/'.$TotalPaginas.'</p>';

	echo '<div id="Paginacao">';
	echo '<a href="listar-pacientes-paginacao.php?Page=3" class="btn btn-default">&lsaquo;&lsaquo;</a>';
	echo '<a href="listar-pacientes-paginacao.php?Page=1&ItensPorPagina='.$ItensPorPagina.'&PageOffset='.$PageOffset.'&Soma='.$Soma.'" class="btn btn-default">&lsaquo; Anterior</a>';
	echo '<a href="listar-pacientes-paginacao.php?Page=2&ItensPorPagina='.$ItensPorPagina.'&PageOffset='.$PageOffset.'&Soma='.$Soma.'" class="btn btn-default">Próximo &rsaquo;</a>';
	echo '</div>';
	?>
    <div class="row">
	<div class="col-lg-6">
	<?php
	// buscar dados
	$sql = "SELECT * FROM paciente $FiltroPaciente ORDER BY NomeCurto ASC LIMIT $ItensPorPagina $PageOffset1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<table class="table table-striped table-hover table-condensed">';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Nome completo</th>';
		echo '<th>Programa intervenção</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	    while($row = $result->fetch_assoc()) {
	    	$id_paciente = $row['id_paciente'];
			$NomeCompleto = $row['NomeCompleto'];
			$NomeCurto = $row['NomeCurto'];
			$Status = $row['Status'];

			// buscar xxx
			$sqlA = "SELECT * FROM prog_treino_paciente WHERE id_paciente = '$id_paciente'";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
					$CheckTreino = 1;
			    }
			} else {
				// não tem
				$CheckTreino = 2;
			}

			echo '<tr>';
			echo '<td style="vertical-align: middle;"><a href="../paciente/paciente.php?id_paciente='.$id_paciente.'" class="Link">'.$NomeCompleto.'</a></td>';
			echo '<td style="text-align: right;">';
			if ($CheckTreino == 1) {
				echo '<a href="../intervencao/listar-treinos-paciente.php?id_paciente='.$id_paciente.'" class="btn btn-default">Ver treino</a>';
			} else {
			}
			
			echo '</td>';
			echo '</tr>';
	    }
		echo '</tbody>';
		echo '</table>';
	} else {
		echo 'Não encontramos nenhum paciente.';
	}
	?>
	</div>
	</div>
</div>

<div>
    <?php
    // configurar nº de itens por página
    // buscar xxx
    $sql = "SELECT * FROM configuracao WHERE Variavel = 'ItensPorPagina' AND id_usuario = '$id_usuario'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // tem
            $Valor = $row['Valor'];
        }
    } else {
        // não tem
    }
    ?>
    <p>Alterar o nº de pacientes mostrados por página.</p>
    <form action="../configuracao/configurar-itens-por-pagina-2.php?Origem=../intervencao/listar-pacientes-intervencao.php" method="post" class="form-inline">
        <input type="number" name="Valor" class="form-control" value="<?php echo $Valor;?>" style="margin-bottom: 5px;">
        <button type="submit" class="btn btn-success">Confirmar</button>
    </form>
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
