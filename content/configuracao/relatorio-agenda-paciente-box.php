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
$DataAtualBr = date("d/m/Y", strtotime($DataAtual));

// input
$id_agenda_paciente = $_GET['id_agenda_paciente'];

// buscar xxx
$sql = "SELECT paciente.NomeCompleto, paciente.id_paciente
FROM agenda_paciente
INNER JOIN paciente ON agenda_paciente.id_paciente = paciente.id_paciente
WHERE agenda_paciente.id_agenda_paciente = '$id_agenda_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$_SESSION['id_paciente'] = $id_paciente;
		$NomePaciente = $row['NomeCompleto'];
    }
} else {
	// não tem
}

// buscar xxx
$sql = "SELECT agenda_paciente.*, profissional.NomeCompleto, profissional.id_profissional, hora.Hora, categoria.NomeCategoria, unidade.NomeUnidade
FROM agenda_paciente
INNER JOIN profissional ON agenda_paciente.id_profissional = profissional.id_profissional
INNER JOIN hora ON agenda_paciente.id_hora = hora.id_hora
INNER JOIN categoria ON agenda_paciente.id_categoria = categoria.id_categoria
INNER JOIN unidade ON agenda_paciente.id_unidade = unidade.id_unidade
WHERE agenda_paciente.id_agenda_paciente = '$id_agenda_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_profissional = $row['id_profissional'];
		$NomeProfissional = $row['NomeCompleto'];
		$id_hora = $row['id_hora'];
		$Hora = $row['Hora'];
		$id_categoria = $row['id_categoria'];
		$id_unidade = $row['id_unidade'];
		$Data = $row['Data'];
		$NomeCategoria = $row['NomeCategoria'];
		$NomeUnidade = $row['NomeUnidade'];
    }
} else {
	// não tem
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
	td:hover {
		background-color: #fcf8e3;
		transition: all ease 0.3s;
    	cursor: pointer;
	}
</style>

<body>
<div class="wrapper">
    <?php include '../menu-lateral/menu-lateral.php';?>

    <div id="content">
        <?php include '../menu-superior/menu-superior.php';?>

        <div id="conteudo">

<h2>Agenda da criança</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="relatorio-agenda-base.php">Paciente</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-profissional.php">Terapeuta</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-dia-semana.php">Dia</a></li>
    <li class="inactive"><a href="relatorio-agenda-base-analise.php">Análise</a></li>
    <li class="inactive"><a href="criar-agenda-da-semana.php">Criar agenda</a></li>
    <li class="inactive"><a href="relatorio-agenda-do-dia.php">Agenda dia</a></li>
    <li class="active"><a href="relatorio-agenda-paciente.php">Agenda criança</a></li>
    <li class="inactive"><a href="relatorio-agenda-profissional.php">Agenda terapeuta</a></li>
</ul>

<div class="janela">

	<h4>Alterar terapeuta</h4>
	<li><label>Nome do paciente:</label> <?php echo $NomePaciente;?></li>
	<li><label>Data:</label> <?php echo $Data;?></li>
	<li><label>Horário:</label> <?php echo $Hora;?></li>
	<li><label>Categoria:</label> <?php echo $NomeCategoria;?></li>
	<li><label>Unidade</label> <?php echo $NomeUnidade;?></li>

	<form action="agenda-paciente-agendar-terapeuta-3.php" method="post" class="form-inline" style="margin-bottom: 5px;">
		<div class="form-group">
			<label>Terapeuta</label>
			<select class="form-control" name="id_profissionalX" required>
				<option value="<?php echo $id_profissional;?>"><?php echo $NomeProfissional;?></option>
				<?php
				// buscar xxx
				$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora' AND Status = 1";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						// tem
						$PeriodoY = $row['Periodo'];
				    }
				} else {
					// não tem
				}
			
				// buscar xxx
				$sql = "SELECT profissional.* FROM categoria_profissional INNER JOIN profissional ON categoria_profissional.id_profissional = profissional.id_profissional WHERE categoria_profissional.id_categoria = '$id_categoria' AND categoria_profissional.id_periodo = '$PeriodoY' AND categoria_profissional.id_unidade = '$id_unidade' AND profissional.Status = 1 ORDER BY profissional.NomeCompleto ASC";
				
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
						// tem
						$id_profissionalX = $row['id_profissional'];
						$NomeProfissionalX = $row['NomeCompleto'];

						// verificar se o profissional está agendado neste horário
						$sqlA = "SELECT * FROM agenda_paciente WHERE id_profissional = '$id_profissionalX' AND Data = '$Data' AND id_unidade ='$id_unidade' AND id_hora = '$id_hora' AND id_categoria = '$id_categoria'";
						$resultA = $conn->query($sqlA);
						if ($resultA->num_rows > 0) {
						    while($rowA = $resultA->fetch_assoc()) {
								// tem
								echo '<option value="">--- '.$NomeProfissionalX.' ---</option>';
						    }
						} else {
							// não tem
							echo '<option value="'.$id_profissionalX.'">'.$NomeProfissionalX.'</option>';
						}
				    }
				} else {
					// não tem
				}
				?>
			</select>
		</div>
		<input type="text" hidden name="id_categoria" value="<?php echo $id_categoria;?>">
		<input type="text" hidden name="id_unidade" value="<?php echo $id_unidade;?>">
		<input type="text" hidden name="id_hora" value="<?php echo $id_hora;?>">
		<input type="text" hidden name="id_agenda_paciente" value="<?php echo $id_agenda_paciente;?>">

		<button type="submit" class="btn btn-success">Confirmar</button>
	</form>
	<a class="btn btn-default" data-toggle="modal" data-target="#CancelarAgenda">Cancelar agenda do paciente</a>
</div>
		</div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="CancelarAgenda" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Apagar agenda da criança</h4>
            </div>
            <div class="modal-body" style="background-color: #fafafa;">
                <b>Cuidado</b>, a agenda da criança será removida do sistema.<br>
                Deseja continuar?

            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <a href="apagar-agenda-paciente.php?id_agenda_paciente=<?php echo $id_agenda_paciente;?>" class="btn btn-danger">Apagar</a>
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