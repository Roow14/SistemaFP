<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

date_default_timezone_set("America/Sao_Paulo");
$DataAtualX = date("d/m/Y");
$DataAtual = date("Y-m-d");

// conexão com banco
include '../conexao/conexao.php';

// input 
unset($_SESSION['Origem']);
$Origem = 'relatorio-agenda-base.php';

// limpar filtro por nome
if (empty($_GET['Limpar'])) {
} else {
	unset($_SESSION['Paciente']);
}

// pesquisar por nome
if (isset($_POST['Paciente'])) {
	$Paciente = $_POST['Paciente'];
	$_SESSION['Paciente'] = $Paciente;
	$FiltroPaciente = 'AND NomeCompleto LIKE "%'.$Paciente.'%"';
} elseif (isset($_SESSION['Paciente'])) {
	$Paciente = $_SESSION['Paciente'];
	$FiltroPaciente = 'AND NomeCompleto LIKE "%'.$Paciente.'%"';
} else {
	$Paciente = NULL;
	$FiltroPaciente = NULL;
	unset($_SESSION['Paciente']);
}

// filtrar por status
if (empty($_POST['Status'])) {
	$Status = NULL;
	$NomeStatus = 'Ativo';
	$FiltroStatus = 'WHERE Status = 1';
} else {
	$Status = $_POST['Status'];
	if ($Status == 1) {
		$NomeStatus = 'Ativo';
		$FiltroStatus = 'WHERE Status = '.$Status;
	} elseif ($Status == 2) {
		$NomeStatus = 'Inativo';
		$FiltroStatus = 'WHERE Status = '.$Status;
	} else {
		$NomeStatus = 'Ativo e inativo';
		$FiltroStatus = 'WHERE (Status = 1 OR Status = 2)';
	}
}

$sql = "SELECT COUNT(id_paciente) AS Soma FROM paciente $FiltroStatus $FiltroPaciente ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// tem
	while($row = $result->fetch_assoc()) {
		$Soma = $row['Soma'];
	}
// não tem
} else {
	$Soma = 0;
}

// filtrar por unidade
if (isset($_POST['id_unidade'])) {
	if (empty($_POST['id_unidade'])) {
		$id_unidade = NULL;
		$NomeUnidade = 'Não definido';
		$FiltroUnidade = 'AND paciente.id_unidade is NULL';
	} elseif ($_POST['id_unidade'] == 99) {
		$id_unidade = NULL;
		$NomeUnidade = 'Todos';
		$FiltroUnidade = NULL;
	} else {
		$id_unidade = $_POST['id_unidade'];
		$_SESSION['id_unidade'] = $id_unidade;
		// buscar xxx
		$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$NomeUnidade = $row['NomeUnidade'];
				$FiltroUnidade = 'AND paciente.id_unidade ='.$id_unidade;
		    }
		} else {
			// não tem
		}
	}
} elseif (isset($_SESSION['id_unidade'])) {
	$id_unidade = $_SESSION['id_unidade'];
	// buscar xxx
	$sql = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeUnidade = $row['NomeUnidade'];
			$FiltroUnidade = 'AND paciente.id_unidade ='.$id_unidade;
	    }
	} else {
		// não tem
	}
} else {
	$id_unidade = NULL;
	$NomeUnidade = 'Todos';
	$FiltroUnidade = NULL;
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
li {
	list-style: none;
}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Agenda base</h2>

<ul class="nav nav-tabs">
	<li class="active"><a href="relatorio-agenda-base.php">Paciente</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-profissional.php">Terapeuta</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-dia-semana.php">Dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-analise.php">Análise</a></li>
    <li class="inactive"><a href="criar-agenda-da-semana.php">Criar agenda</a></li>
    <li class="inactive"><a href="relatorio-agenda-do-dia.php">Agenda dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-paciente.php">Agenda criança</a></li>
    <li class="inactive"><a href="relatorio-agenda-profissional.php">Agenda terapeuta</a></li>
    <li class="inactive"><a href="ajuda.php">Ajuda</a></li>
</ul>

<div class="janela">
<p>Relatório das agendas base dos pacientes.</p>
<li><label>Data do relatório: </label> <?php echo $DataAtualX;?></li>
<form action="" method="post" class="form-inline">
	<label>Filtrar por paciente:</label>
	<input type="text" class="form-control" name="Paciente" value="<?php echo $Paciente;?>" placeholder="Digite o nome">
	<select class="form-control" name="Status">
		<option value="<?php echo $Status;?>"><?php echo $NomeStatus;?></option>
		<option value="1">Ativo</option>
		<option value="2">Inativo</option>
		<option value="">Ativo e inativo</option>
	</select>
	<label>Unidade:</label>
	<select class="form-control" name="id_unidade">
		<option value="<?php echo $id_unidade;?>"><?php echo $NomeUnidade;?></option>
		<?php
		// buscar xxx
		$sql = "SELECT * FROM unidade ORDER BY NomeUnidade ASC";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$id_unidadeX = $row['id_unidade'];
				$NomeUnidadeX = $row['NomeUnidade'];
				echo '<option value="'.$id_unidadeX.'">'.$NomeUnidadeX.'</option>';
		    }
		} else {
			// não tem
		}
		?>
		<option value="">Não definido</option>
		<option value="99">Limpar filtro</option>
	</select>
	<button type="submit" class="btn btn-success">Pesquisar</button>
	<a href="relatorio-agenda-base.php?Limpar=1" class="btn btn-default">Limpar filtro</a>
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

$TotalPaginas = round($Soma / $ItensPorPagina) + 1;
$NumeroPagina = ($PageOffset / $ItensPorPagina) + 1; 

?>

<div style="margin-top: 5px; margin-bottom: 25px;">
<label>Total:</label> <?php echo $Soma;?><span style="margin-right: 15px;"></span><label>Página:</label> <?php echo $NumeroPagina;?>/<?php echo $TotalPaginas;?><span style="margin-right: 15px;"></span>
<a href="listar-pacientes-paginacao.php?Page=3&Origem=<?php echo $Origem;?>" class="btn btn-default">&lsaquo;&lsaquo;</a>
<a href="listar-pacientes-paginacao.php?Page=1&ItensPorPagina=<?php echo $ItensPorPagina;?>&PageOffset=<?php echo $PageOffset;?>&Soma=<?php echo $Soma;?>&Origem=<?php echo $Origem;?>" class="btn btn-default">&lsaquo; Anterior</a>
<a href="listar-pacientes-paginacao.php?Page=2&ItensPorPagina=<?php echo $ItensPorPagina;?>&PageOffset=<?php echo $PageOffset;?>&Soma=<?php echo $Soma;?>&Origem=<?php echo $Origem;?>" class="btn btn-default">Próximo &rsaquo;</a>
</div>

<?php
// buscar xxx
$sql = "SELECT * FROM paciente $FiltroStatus $FiltroPaciente $FiltroUnidade ORDER BY NomeCompleto ASC LIMIT $ItensPorPagina $PageOffset1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$NomeCompleto = $row['NomeCompleto'];
		$Status = $row['Status'];
		if ($Status == 1) {
			$NomeStatus = 'Ativo';
		} else {
			$NomeStatus = 'Inativo';
		}
		echo '<label>Nome do paciente:</label> '.$id_paciente.' - '.$NomeCompleto.'<br>';
		echo '<label>Status:</label> '.$NomeStatus;
		echo '<br>';
		// buscar xxx
		$sqlA = "SELECT * FROM agenda_paciente_base WHERE id_paciente = '$id_paciente'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
			echo '<table class="table table-striped table-hover table-condensed">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Dia da semana</th>';
			echo '<th>Hora</th>';
			echo '<th>Terapeuta</th>';
			echo '<th>Categoria</th>';
			echo '<th>Unidade</th>';
			echo '<th>ID</th>';
			echo '</tr>';
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_agenda_paciente_base = $rowA['id_agenda_paciente_base'];
				$id_profissional = $rowA['id_profissional'];
				$DiaSemana = $rowA['DiaSemana'];
				$id_hora = $rowA['id_hora'];
				$id_categoria = $rowA['id_categoria'];
				$id_unidade = $rowA['id_unidade'];

				if ($DiaSemana == 2) {
					$Semana = 'Segunda';
				} elseif ($DiaSemana == 3) {
					$Semana = 'Terça';
				} elseif ($DiaSemana == 4) {
					$Semana = 'Quarta';
				} elseif ($DiaSemana == 5) {
					$Semana = 'Quinta';
				} elseif ($DiaSemana == 6) {
					$Semana = 'Sexta';
				} elseif ($DiaSemana == 7) {
					$Semana = 'Sábado';
				}  else {
					$Semana = NULL;
				}

				// buscar xxx
				$sqlB = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
				$resultB = $conn->query($sqlB);
				if ($resultB->num_rows > 0) {
				    while($rowB = $resultB->fetch_assoc()) {
						// tem
						$NomeCompletoProf = $rowB['NomeCompleto'];
				    }
				} else {
					// não tem
					$NomeCompletoProf = NULL;
				}

				// buscar xxx
				$sqlB = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
				$resultB = $conn->query($sqlB);
				if ($resultB->num_rows > 0) {
				    while($rowB = $resultB->fetch_assoc()) {
						// tem
						$Hora = $rowB['Hora'];
				    }
				} else {
					// não tem
					$Hora = NULL;
				}

				// buscar xxx
				$sqlB = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
				$resultB = $conn->query($sqlB);
				if ($resultB->num_rows > 0) {
				    while($rowB = $resultB->fetch_assoc()) {
						// tem
						$NomeUnidade = $rowB['NomeUnidade'];
				    }
				} else {
					// não tem
					$NomeUnidade = NULL;
				}

				// buscar xxx
				$sqlB = "SELECT * FROM categoria WHERE id_categoria = '$id_categoria'";
				$resultB = $conn->query($sqlB);
				if ($resultB->num_rows > 0) {
				    while($rowB = $resultB->fetch_assoc()) {
						// tem
						$NomeCategoria = $rowB['NomeCategoria'];
				    }
				} else {
					// não tem
					$NomeCategoria = NULL;
				}

				echo '<tr>';
				echo '<td>'.$Semana.'</td>';
				echo '<td>'.$Hora.'</td>';
				echo '<td>'.$NomeCompletoProf.'</td>';
				echo '<td>'.$NomeCategoria.'</td>';
				echo '<td>'.$NomeUnidade.'</td>';
				echo '<td>'.$id_agenda_paciente_base.'</td>';
				echo '</tr>';
		    }
		    echo '</tbody>';
			echo '</table>';
		} else {
			// não tem
			echo 'Sem agenda';
			echo '<br>';
		}
		echo '<br>';
    }
} else {
	// não tem
	echo '<br>';
	echo 'Não foi encontrado nenhum paciente';
}
?>
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
    <form action="../configuracao/configurar-itens-por-pagina-2.php?Origem=<?php echo $Origem;?>" method="post" class="form-inline">
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