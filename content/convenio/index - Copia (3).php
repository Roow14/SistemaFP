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
// unset($_SESSION['id_paciente']);

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

$sql = "SELECT COUNT(DISTINCT paciente.id_paciente) AS Soma
FROM paciente
INNER JOIN agenda_paciente ON paciente.id_paciente = agenda_paciente.id_paciente
WHERE agenda_paciente.Data = '$DataAgenda'
$FiltroPaciente";
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

<h2>Convênio médico</h2>

<ul class="nav nav-tabs">
	<li class="active"><a href="index.php">Agenda do dia</a></li>
	<li class="inactive"><a href="relatorio-convenio-paciente.php">Criança</a></li>
	<li class="inactive"><a href="convenio-paciente.php">Convênios da criança</a></li>
	<li class="inactive"><a href="listar-convenio.php">Convênios</a></li>
	<li class="inactive"><a href="ajuda.php">Ajuda</a></li>
</ul>

<div class="janela">
<p>Validação do convênio médico da criança</p>
<form action="" method="post" class="form-inline">
	<label>Filtrar por data:</label>
	<input type="date" name="DataAgenda" class="form-control" value="<?php echo $DataAgenda;?>">

	<label>crianças:</label>
	<input type="text" name="PesquisaPaciente" class="form-control" value="<?php echo $PesquisaPaciente;?>" placeholder="Nome">

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
<a href="listar-pacientes-paginacao.php?Page=3" class="btn btn-default">&lsaquo;&lsaquo;</a>
<a href="listar-pacientes-paginacao.php?Page=1&ItensPorPagina=<?php echo $ItensPorPagina;?>&PageOffset=<?php echo $PageOffset;?>&Soma=<?php echo $Soma;?>" class="btn btn-default">&lsaquo; Anterior</a>
<a href="listar-pacientes-paginacao.php?Page=2&ItensPorPagina=<?php echo $ItensPorPagina;?>&PageOffset=<?php echo $PageOffset;?>&Soma=<?php echo $Soma;?>" class="btn btn-default">Próximo &rsaquo;</a>

<a href="" class="btn btn-default" data-toggle="modal" data-target="#AlterarStatus">Alterar status</a>
</div>


<?php
// buscar xxx
$sql = "SELECT agenda_paciente.*, paciente.NomeCompleto, hora.Hora
FROM agenda_paciente
INNER JOIN paciente ON paciente.id_paciente = agenda_paciente.id_paciente
INNER JOIN hora ON hora.id_hora = agenda_paciente.id_hora
WHERE agenda_paciente.Data = '$DataAgenda'
$FiltroPaciente
ORDER BY paciente.NomeCompleto ASC, hora.Hora ASC
LIMIT $ItensPorPagina $PageOffset1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// StatusConvenio 1 cancelar validação, 2 validar
	if ((empty($_SESSION['StatusConvenio'])) OR ($_SESSION['StatusConvenio'] == 1)) {
		echo '<form action="validar-convenio-2.php?StatusConvenio=1" method="post">';
	} else {
		echo '<form action="validar-convenio-2.php?StatusConvenio=2" method="post">';
	}
	
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>ID</th>';
	echo '<th>Paciente</th>';
	echo '<th>Hora</th>';
	echo '<th>Presença</th>';
	echo '<th>Convênio validado</th>';
	
	echo '<th>';
	// StatusConvenio 1 cancelar validação, 2 validar
	if ((empty($_SESSION['StatusConvenio'])) OR ($_SESSION['StatusConvenio'] == 1)) {
		echo '<button type="submit" class="btn btn-success" >Validar</button>';
	} else {
		echo '<button type="submit" class="btn btn-warning" >Cancelar</button>';
	}
	echo '</th>';
	echo '</tr>';


    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$NomeCompleto = $row['NomeCompleto'];
		$Hora = $row['Hora'];
		$id_agenda_paciente = $row['id_agenda_paciente'];
		$Convenio = $row['Convenio'];
		$id_convenio = $row['id_convenio'];
		$Presenca = $row['Presenca'];
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
		echo '<td>'.$id_paciente.'</td>';
		echo '<td><a href="relatorio-convenio-paciente.php?id_paciente='.$id_paciente.'" method="post" class="Link">'.$NomeCompleto.'</a></td>';
		echo '<td>'.$Hora.'</td>';
		
		echo '<td>'.$NomePresenca.'</td>';
		echo '<td>'.$NomeConvenio.'</td>';
		echo '<td>';
		echo '<input type="checkbox" name="id_agenda_paciente[]" value="'.$id_agenda_paciente.'">'.$NomeConvenioAtual;
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

	echo '<th>';
	if ((empty($_SESSION['StatusConvenio'])) OR ($_SESSION['StatusConvenio'] == 1)) {
		echo '<button type="submit" class="btn btn-success" >Validar</button>';
	} else {
		echo '<button type="submit" class="btn btn-warning" >Cancelar validação</button>';
	}
	echo '</th>';
	
	echo '</tr>';
	echo '</thead>';

    echo '</table>';
    echo '</form>';
} else {
	// não tem
	echo '<div style="margin: 25px 0">';
	echo '<b>Nota:</b> Não foi encontrado nenhuma criança agendado para esta data.';
	echo '</div>';
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
<form action="configurar-itens-por-pagina-2.php" method="post" class="form-inline">
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
            <form action="filtro-validade-2.php" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alterar status</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <select class="form-control" name="StatusConvenio">
                    	<option value="">Selecionar</option>
                    	
                    	<option value="1">Botão Validar</option>
                    	<option value="2">Botão Cancelar</option>
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