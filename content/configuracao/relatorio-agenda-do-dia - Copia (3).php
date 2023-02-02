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
$Origem  = 'relatorio-agenda-do-dia.php';

if (isset($_POST['DataAgenda'])) {
	$DataAgenda = $_POST['DataAgenda'];
	$_SESSION['DataAgenda'] = $DataAgenda;
} elseif (isset($_SESSION['DataAgenda'])) {
	$DataAgenda = $_SESSION['DataAgenda'];
} else {
	$_SESSION['DataAgenda'] = $DataAtual;
	$DataAgenda = $DataAtual;
}
$DataAgendaX = date("d/m/Y", strtotime($DataAgenda));

// dia da semana
setlocale(LC_TIME,"pt");
$DiaSemana = strftime("%A", strtotime($DataAgenda));

if (isset($_POST['PesquisaPaciente'])) {
	$PesquisaPaciente = $_POST['PesquisaPaciente'];
	$_SESSION['PesquisaPaciente'] = $PesquisaPaciente;
	$FiltroPaciente = 'AND paciente.NomeCompleto LIKE "%'.$PesquisaPaciente.'%"';
} elseif (isset($_SESSION['PesquisaPaciente'])) {
	$PesquisaPaciente = $_SESSION['PesquisaPaciente'];
	$FiltroPaciente = 'AND paciente.NomeCompleto LIKE "%'.$PesquisaPaciente.'%"';
} else {
	$PesquisaPaciente = NULL;
	$FiltroPaciente = NULL;
}

if (isset($_POST['PesquisaTerapeuta'])) {
	$PesquisaTerapeuta = $_POST['PesquisaTerapeuta'];
	$_SESSION['PesquisaTerapeuta'] = $PesquisaTerapeuta;
	$FiltroTerapeuta = 'AND profissional.NomeCompleto LIKE "%'.$PesquisaTerapeuta.'%"';
} elseif (isset($_SESSION['PesquisaTerapeuta'])) {
	$PesquisaTerapeuta = $_SESSION['PesquisaTerapeuta'];
	$FiltroTerapeuta = 'AND profissional.NomeCompleto LIKE "%'.$PesquisaTerapeuta.'%"';
} else {
	$PesquisaTerapeuta = NULL;
	$FiltroTerapeuta = NULL;
}
if (empty($_SESSION['id_hora'])) {
	unset($_SESSION['id_hora']);
}

if (isset($_POST['id_hora'])) {
	$id_hora = $_POST['id_hora'];
	if (empty($id_hora)) {
		$FiltroHora = NULL;
		$Hora = NULL;
		unset($_SESSION['id_hora']);
	} else {
		$_SESSION['id_hora'] = $id_hora;
		$FiltroHora = 'AND agenda_paciente.id_hora ='.$id_hora;
		// buscar xxx
		$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$Hora = $row['Hora'];
		    }
		} else {
			// não tem
		}
	}
		
} elseif (isset($_SESSION['id_hora'])) {
	$id_hora = $_SESSION['id_hora'];
	$FiltroHora = 'AND agenda_paciente.id_hora ='.$id_hora;
	// buscar xxx
	$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$Hora = $row['Hora'];
	    }
	} else {
		// não tem
	}
} else {
	$id_hora = NULL;
	$FiltroHora = NULL;
	$Hora = NULL;
}

$sql = "SELECT COUNT(agenda_paciente.id_paciente) AS Soma
FROM agenda_paciente
INNER JOIN paciente ON agenda_paciente.id_paciente = paciente.id_paciente
INNER JOIN profissional ON agenda_paciente.id_profissional = profissional.id_profissional
WHERE agenda_paciente.Data = '$DataAgenda'
$FiltroPaciente $FiltroTerapeuta $FiltroHora";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// tem
	while($row = $result->fetch_assoc()) {
		$Soma = $row['Soma'];
	}
// não tem
} else {
}

// print_r($_SESSION); 
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

<h2>Agenda</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="relatorio-agenda-base.php">Paciente</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-profissional.php">Terapeuta</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-dia-semana.php">Dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-analise.php">Análise</a></li>
    <li class="inactive"><a href="criar-agenda-da-semana.php">Criar agenda</a></li>
    <li class="active"><a href="relatorio-agenda-do-dia.php">Agenda dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-paciente.php">Agenda criança</a></li>
    <li class="inactive"><a href="relatorio-agenda-profissional.php">Agenda terapeuta</a></li>
    <li class="inactive"><a href="ajuda.php">Ajuda</a></li>
</ul>

<div class="janela">
<p>Agenda real dos pacientes por data.</p>
<form action="" method="post" class="form-inline">
	<label>Filtrar por data:</label>
	<input type="date" name="DataAgenda" class="form-control" value="<?php echo $DataAgenda;?>">
	<label>hora:</label>
	<select class="form-control" name="id_hora">
		<option value="<?php echo $id_hora;?>"><?php echo $Hora;?></option>
		<?php
		// buscar xxx
		$sql = "SELECT * FROM hora WHERE Status = 1 ORDER BY Hora ASC";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				// tem
				$id_horaX = $row['id_hora'];
				$HoraX = $row['Hora'];
				echo '<option value="'.$id_horaX.'">'.$HoraX.'</option>';
		    }
		} else {
			// não tem
		}
		?>
		<option value="">Limpar</option>
	</select>

	<label>paciente:</label>
	<input type="text" name="PesquisaPaciente" class="form-control" value="<?php echo $PesquisaPaciente;?>">

	<label>terapeuta:</label>
	<input type="text" name="PesquisaTerapeuta" class="form-control" value="<?php echo $PesquisaTerapeuta;?>">
	<button type="submit" class="btn btn-success">Confirmar</button>
</form>
<li><label>Dia da semana: </label> <?php echo $DiaSemana;?></li>
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

<div>
<label>Total de itens:</label> <?php echo $Soma;?><span style="margin-right: 15px;"></span><label>Página:</label> <?php echo $NumeroPagina;?>/<?php echo $TotalPaginas;?><span style="margin-right: 15px;"></span>
<a href="listar-pacientes-paginacao.php?Page=3&Origem=<?php echo $Origem;?>" class="btn btn-default">&lsaquo;&lsaquo;</a>
<a href="listar-pacientes-paginacao.php?Page=1&ItensPorPagina=<?php echo $ItensPorPagina;?>&PageOffset=<?php echo $PageOffset;?>&Soma=<?php echo $Soma;?>&Origem=<?php echo $Origem;?>" class="btn btn-default">&lsaquo; Anterior</a>
<a href="listar-pacientes-paginacao.php?Page=2&ItensPorPagina=<?php echo $ItensPorPagina;?>&PageOffset=<?php echo $PageOffset;?>&Soma=<?php echo $Soma;?>&Origem=<?php echo $Origem;?>" class="btn btn-default">Próximo &rsaquo;</a>

<a href="" class="btn btn-default" data-toggle="modal" data-target="#AlterarStatus">Alterar status</a>
</div>


<?php
// buscar xxx
$sql = "SELECT agenda_paciente.*, agenda_paciente.Status
FROM agenda_paciente
INNER JOIN paciente ON agenda_paciente.id_paciente = paciente.id_paciente
INNER JOIN profissional ON agenda_paciente.id_profissional = profissional.id_profissional
WHERE agenda_paciente.Data = '$DataAgenda'
$FiltroPaciente $FiltroTerapeuta $FiltroHora
ORDER BY agenda_paciente.id_hora ASC
LIMIT $ItensPorPagina $PageOffset1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {

	if (isset($_SESSION['Status'])) {
		$Status = $_SESSION['Status'];
	} else {
		$Status = 2;
	}
	echo '<form action="relatorio-agenda-do-dia-status-2.php?Status='.$Status.'" method="post">';

	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Hora</th>';
	echo '<th>Paciente</th>';
	echo '<th>Profissional</th>';
	echo '<th>Categoria</th>';
	echo '<th>Unidade</th>';
	echo '<th>Convênio validado</th>';
	echo '<th>Status</th>';

	if ((empty($_SESSION['Status'])) OR ($_SESSION['Status'] == 2)) {
		echo '<th><button type="submit" class="btn btn-success" >Realizado</button></th>';
	} elseif ($_SESSION['Status'] == 3) {
		echo '<th><button type="submit" class="btn btn-warning" >Faltou</button></th>';
	} elseif ($_SESSION['Status'] == 4) {
		echo '<th><button type="submit" class="btn btn-warning" >Outros</button></th>';
	} else {
		echo '<th><button type="submit" class="btn btn-info" >Agendado</button></th>';
	}

	echo '</tr>';
	
    while($row = $result->fetch_assoc()) {
		// tem
		$id_agenda_paciente = $row['id_agenda_paciente'];
		$id_paciente = $row['id_paciente'];
		$id_profissional = $row['id_profissional'];
		$id_hora = $row['id_hora'];
		$id_categoria = $row['id_categoria'];
		$id_unidade = $row['id_unidade'];
		$Convenio = $row['Convenio'];
		$id_convenio = $row['id_convenio'];
		$Presenca = $row['Presenca'];
		if ($Presenca == 2) {
			$NomePresenca = 'Realizado';
		} elseif ($Presenca == 3) {
			$NomePresenca = 'Faltou';
		} elseif ($Presenca == 4) {
			$NomePresenca = 'Outros';
		} else {
			$NomePresenca = 'Agendado';
		}

		// buscar xxx
		$sqlA = "SELECT * FROM paciente WHERE id_paciente = '$id_paciente'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeCompleto = $rowA['NomeCompleto'];
		    }
		} else {
			// não tem
			$NomeCompleto = NULL;
		}

		// buscar xxx
		$sqlA = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeCompletoProf = $rowA['NomeCompleto'];
		    }
		} else {
			// não tem
			$NomeCompletoProf = NULL;
		}

		// buscar xxx
		$sqlA = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$Hora = $rowA['Hora'];
		    }
		} else {
			// não tem
			$Hora = NULL;
		}

		// buscar xxx
		$sqlA = "SELECT * FROM unidade WHERE id_unidade = '$id_unidade'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeUnidade = $rowA['NomeUnidade'];
		    }
		} else {
			// não tem
			$NomeUnidade = NULL;
		}

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

		// buscar xxx
		$sqlA = "SELECT * FROM convenio	WHERE id_convenio = '$id_convenio'";
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

		// buscar xxx
		$sqlA = "SELECT * FROM convenio_paciente
		INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
		WHERE convenio_paciente.id_paciente = '$id_paciente' AND convenio_paciente.StatusConvenio = 1
		ORDER BY convenio_paciente.Ordem ASC
		LIMIT 1";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeConvenioAtual = $rowA['NomeConvenio'];
		    }
		} else {
			// não tem
			$NomeConvenioAtual = NULL;
		}

		echo '<tr>';
		echo '<td>'.$Hora.'</td>';
		echo '<td><a href="relatorio-agenda-paciente-box.php?id_agenda_paciente='.$id_agenda_paciente.'" method="post" class="Link">'.$NomeCompleto.'</a></td>'; 
		echo '<td><a href="relatorio-agenda-profissional.php?id_agenda_paciente='.$id_agenda_paciente.'" method="post" class="Link">'.$NomeCompletoProf.'</a></td>'; 
		echo '<td>'.$NomeCategoria.'</td>';
		echo '<td style="width: 150px;">'.$NomeUnidade.'</td>';
		
		echo '<td>'.$NomeConvenio.'</td>';
		echo '<td>'.$NomePresenca.'</td>';
		
		echo '<td>';
		echo '<input type="checkbox" name="id_agenda_paciente[]" value="'.$id_agenda_paciente.'">';
		echo '</td>';

		echo '</tr>';
    }
    
    echo '</tbody>';
	
	echo '<thead>';
	echo '<tr>';
	echo '<th></th>';
	echo '<th></th>';
	echo '<th></th>';
	echo '<th></th>';
	echo '<th></th>';
	echo '<th></th>';
	if ((empty($_SESSION['Status'])) OR ($_SESSION['Status'] == 2)) {
		echo '<th><button type="submit" class="btn btn-success" >Realizado</button></th>';
	} elseif ($_SESSION['Status'] == 3) {
		echo '<th><button type="submit" class="btn btn-warning" >Faltou</button></th>';
	} elseif ($_SESSION['Status'] == 4) {
		echo '<th><button type="submit" class="btn btn-warning" >Cancelado</button></th>';
	} else {
		echo '<th><button type="submit" class="btn btn-info" >Agendado</button></th>';
	}
	echo '</tr>';
	echo '</thead>';

	echo '</table>';

    echo '</form>';
} else {
	// não tem
	echo '<br>';
	echo 'Não foi encontrado nenhum paciente';
}

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
<p>Alterar o nº de crianças mostradas por página.</p>
<form action="../configuracao/configurar-itens-por-pagina-2.php?Origem=../configuracao/relatorio-agenda-do-dia.php" method="post" class="form-inline">
    <input type="number" name="Valor" class="form-control" value="<?php echo $Valor;?>" style="margin-bottom: 5px;">
    <button type="submit" class="btn btn-success">Confirmar</button>
</form>
</div>
			</div>
    </div>
</div>

<!-- alterar status -->
<div class="modal fade" id="AlterarStatus" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="relatorio-agenda-do-dia-filtro-status-2.php" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alterar status</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <select class="form-control" name="Status">
                    	<option value="">Selecionar</option>
                    	<option value="1">Agendado</option>
                    	<option value="2">Realizado</option>
                    	<option value="3">Faltou</option>
                    	<option value="4">Outros</option>
                    </select>

                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>    
        </div>

    </div>
</div>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>