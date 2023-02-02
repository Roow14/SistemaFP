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

if (empty($_SESSION['DataAgenda'])) {
	$_SESSION['DataAgenda'] = $DataAtual;
	$DataAgenda = $DataAtual;
} else {
	$DataAgenda = $_SESSION['DataAgenda'];
}
$DataAgendaX = date("d/m/Y", strtotime($DataAgenda));

// dia da semana
setlocale(LC_TIME,"pt");
$DiaSemana = strftime("%A", strtotime($DataAgenda));

if (empty($_SESSION['PesquisaPaciente'])) {
	$PesquisaPaciente = NULL;
	$FiltroPaciente = NULL;
} else {
	$PesquisaPaciente = $_SESSION['PesquisaPaciente'];
	$FiltroPaciente = 'AND paciente.NomeCompleto LIKE "%'.$PesquisaPaciente.'%"';
}

// verificar em agenda_paciente se o exite id_convenio
if (empty($_SESSION['id_convenio'])) {
	$id_convenio = NULL;
	$FiltroConvenio = NULL;
	$NomeConvenio = 'Selecionar';
} else {
	$id_convenio = $_SESSION['id_convenio'];
	$FiltroConvenio = 'AND agenda_paciente.id_convenio = '.$id_convenio;
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
}

if (empty($_SESSION['Presenca'])) {
	$Presenca = NULL;
	$FiltroPresenca = NULL;
	$NomePresenca = 'Selecionar';
} else {
	$Presenca = $_SESSION['Presenca'];
	$FiltroPresenca = 'AND agenda_paciente.Presenca ='.$Presenca;
	if ($Presenca == 1) {
		$NomePresenca = 'Agendado';
	} elseif ($Presenca == 2) {
		$NomePresenca = 'Realizado';
	} elseif ($Presenca == 3) {
		$NomePresenca = 'Faltou';
	} else {
		$NomePresenca = 'Outros';
	}

}

$sql = "SELECT COUNT(DISTINCT paciente.id_paciente) AS Soma
FROM paciente
INNER JOIN agenda_paciente ON paciente.id_paciente = agenda_paciente.id_paciente
WHERE agenda_paciente.Data = '$DataAgenda'
$FiltroPaciente $FiltroPresenca";
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


<div class="hidden-print">
	<h2>Convênio médico</h2>
	<ul class="nav nav-tabs">
		<li class="inactive"><a href="index.php">Agenda do dia</a></li>
		<li class="inactive"><a href="relatorio-convenio-paciente.php">Criança</a></li>
		<li class="inactive"><a href="convenio-paciente.php">Convênios da criança</a></li>
		<li class="inactive"><a href="listar-convenio.php">Convênios</a></li>
		<li class="inactive"><a href="listar-convenio-paciente.php">Com convênio</a></li>
		<li class="inactive"><a href="listar-paciente-sem-convenio.php">Sem convênio</a></li>
		<li class="active"><a href="relatorio-presenca.php">Presença</a></li>
		<li class="inactive"><a href="ajuda.php">Ajuda</a></li>
	</ul>
</div>

<div class="janela">

<div class="hidden-print">
	<h3>Validação do convênio no dia</h3>
	<form action="relatorio-presenca-filtro-2.php" method="post" class="form-inline">
		<div class="form-group">
			<label>Filtrar por data:</label>
			<input type="date" name="DataAgenda" class="form-control" value="<?php echo $DataAgenda;?>">
		</div>

		<div class="form-group">
			<label>crianças:</label>
			<input type="text" name="PesquisaPaciente" class="form-control" value="<?php echo $PesquisaPaciente;?>" placeholder="Nome">
		</div>

		<div class="form-group">
	    	<label>Presença</label>
	        <select class="form-control" name="Presenca">
	        	<option value="<?php echo $Presenca;?>"><?php echo $NomePresenca;?></option>
	        	<option value="1">Agendado</option>
	        	<option value="2">Realizado</option>
	        	<option value="3">Faltou</option>
	        	<option value="4">Outros</option>
	        	<option value="">Limpar filtro</option>
	        </select>
	    </div>

		<div class="form-group">
	    	<label>Convênio</label>
	        <select class="form-control" name="id_convenio">
	        	<?php
	        	echo '<option value="'.$id_convenio.'">'.$NomeConvenio.'</option>';
				// buscar xxx
				$sql = "SELECT * FROM convenio WHERE StatusConvenio = 1";
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
				echo '<option value="">Limpar filtro</option>';
				?>
	        </select>
	    </div>

		<button type="submit" class="btn btn-success">Confirmar</button>
	</form>
	<li><label>Dia da semana: </label> <?php echo $DiaSemana;?></li>
	<li><label>Total de itens: </label> <?php echo $Soma;?></li>
</div>

<div class="visible-print">
	<h3>Convênio médico</h3>
	<p>Validação do convênio no dia</p>
	<span><label>Data: </label> <?php echo $DataAgenda;?></span>
	<span><label>Dia da semana: </label> <?php echo $DiaSemana;?></span>
	<span><label>Total de itens: </label> <?php echo $Soma;?></span>
	<br>
	<span><label>Filtro por nome: </label> <?php echo $PesquisaPaciente;?></span>
	<span><label>Presença: </label> <?php echo $NomePresenca;?></span>
	<span><label>Convênio: </label> <?php echo $NomeConvenio;?></span>
</div>


<?php
// buscar xxx
$sql = "SELECT agenda_paciente.*, paciente.NomeCompleto, hora.Hora
FROM agenda_paciente
INNER JOIN paciente ON paciente.id_paciente = agenda_paciente.id_paciente
INNER JOIN hora ON hora.id_hora = agenda_paciente.id_hora
WHERE agenda_paciente.Data = '$DataAgenda'
$FiltroPaciente $FiltroConvenio $FiltroPresenca
ORDER BY paciente.NomeCompleto ASC, hora.Hora ASC
";
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
	echo '</tr>';


    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$NomeCompleto = $row['NomeCompleto'];
		$Hora = $row['Hora'];
		$id_agenda_paciente = $row['id_agenda_paciente'];
		$Convenio = $row['Convenio'];
		$id_convenio = $row['id_convenio'];
		$PresencaY = $row['Presenca'];
		if ($PresencaY == 1) {
			$NomePresencaY = 'Agendado';
		} 
		if ($PresencaY == 2) {
			$NomePresencaY = 'Realizado';
		} 
		if ($PresencaY == 3) {
			$NomePresencaY = 'Faltou';
		}
		if ($PresencaY == 4) {
			$NomePresencaY = 'Outros';
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

		echo '<tr>';
		echo '<td>'.$id_paciente.'</td>';
		echo '<td class="hidden-print"><a href="relatorio-convenio-paciente.php?id_paciente='.$id_paciente.'" method="post" class="Link">'.$NomeCompleto.'</a></td>';
		echo '<td class="visible-print">'.$NomeCompleto.'</td>';
		echo '<td>'.$Hora.'</td>';
		
		echo '<td>'.$NomePresencaY.'</td>';
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
?>

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