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
$id_convenio_paciente = $_GET['id_convenio_paciente'];
// if (isset($_SESSION['Origem'])) {
// 	$Origem = $_SESSION['Origem'];
// } else {
// 	$Origem = 'convenio-paciente.php';
// }

// buscar xxx
$sql = "SELECT convenio_paciente.*, convenio.NomeConvenio, paciente.NomeCompleto
FROM convenio_paciente
INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
INNER JOIN paciente ON convenio_paciente.id_paciente = paciente.id_paciente
WHERE convenio_paciente.id_convenio_paciente = '$id_convenio_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_convenio = $row['id_convenio'];
		$id_paciente = $row['id_paciente'];
		$NomeConvenio = $row['NomeConvenio'];
		$NomeCompleto = $row['NomeCompleto'];
		$NumeroConvenio = $row['NumeroConvenio'];
		$NotaConvenio = $row['NotaConvenio'];
		$HorasConvenio = $row['HorasConvenio'];
		$Total = $row['Total'];
		$StatusConvenio = $row['StatusConvenio'];
		if ($StatusConvenio == 1) {
			$NomeStatus = 'Ativo';
		} else {
			$NomeStatus = 'Inativo';
		}
		$LiberacaoAT = $row['LiberacaoAT'];
		if ($LiberacaoAT == 2) {
			$NomeLiberacaoAT = 'Social';
		} elseif ($LiberacaoAT == 3) {
			$NomeLiberacaoAT = 'Escolar';
		}
		else {
			$NomeLiberacaoAT = 'Nenhum';
		}
    }
} else {
}

// verificar se foi utilizado na agenda
$sql = "SELECT * FROM agenda_paciente WHERE id_convenio = '$id_convenio' LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$Check = 1;
    }
} else {
	// não tem
	$Check = 2;
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

<h2>Pacientes</h2>

<ul class="nav nav-tabs">
	<li class="inactive"><a href="../paciente/">Lista</a></li>
	<li class="inactive"><a href="../paciente/paciente.php">Paciente</a></li>
	<li class="inactive"><a href="../paciente/escola-paciente.php">Escola</a></li>
	<li class="active"><a href="../paciente/convenio-paciente.php">Convênio</a></li>
	<li class="inactive"><a href="../avaliacao/">Plano terapêutico</a></li>
	<li class="inactive"><a href="../exame/">Dados médicos</a></li>
	<li class="inactive"><a href="../configuracao/relatorio-agenda-paciente.php">Agenda</a></li>
</ul>
	
<div class="janela">
	<h3>Convênio do paciente</h3>
	<li><label>Nome do paciente:</label> <?php echo $NomeCompleto;?></li>
	<li><label>Convênio:</label> <?php echo $NomeConvenio;?></li>
	<div class="row">
		<form action="alterar-convenio-paciente-2.php" method="post" class="">
			<input type="text" hidden name="id_convenio_paciente" value="<?php echo $id_convenio_paciente;?>">
			<input type="text" hidden name="id_paciente" value="<?php echo $id_paciente;?>">
			<input type="text" hidden name="id_convenio" value="<?php echo $id_convenio;?>">		

			<div class="form-group col-sm-3">
				<label>Nº carteirinha</label>
				<input type="text" class="form-control" name="NumeroConvenio" value="<?php echo $NumeroConvenio;?>" required>
			</div>

			<div class="form-group col-sm-3">
				<label>Status</label>
				<select class="form-control" name="StatusConvenio">
					<option value="<?php echo $StatusConvenio;?>"><?php echo $NomeStatus;?></option>
					<option value="1">Ativo</option>
					<option value="2">Inativo</option>
				</select>
			</div>

			<div class="form-group col-sm-3">
				<label>Liberação AT</label>
				<select class="form-control" name="LiberacaoAT" required>
					<option value="<?php echo $LiberacaoAT;?>"><?php echo $NomeLiberacaoAT;?></option>
					<option value="1">Nenhum</option>
					<option value="2">Social</option>
					<option value="3">Escolar</option>

				</select>
			</div>

			<div class="form-group col-sm-3">
				<label>Horas liberadas por semana</label>
				<input type="text" class="form-control" name="HorasConvenio" value="<?php echo $HorasConvenio;?>">
			</div>

			<div class="form-group col-sm-12">
				<label>Observação</label>
				<textarea rows="3" class="form-control" name="NotaConvenio"><?php echo $NotaConvenio;?></textarea>
			</div>

			<div class="form-group col-sm-12">
				<p>Importante: Somente 1 convênio do paciente deve ter o status ativo. Ao alterar o status deste convênio para ativo, os demais convênios serão alterados para inativo.</p>
				<a href="convenio-paciente.php?id_paciente=<?php echo $id_paciente;?>" class="btn btn-default">Voltar</a>
				<button type="submit" class="btn btn-success">Confirmar</button>
				<?php
				if ($Check == 1) {
					echo '<a href="" class="btn btn-default" data-toggle="modal" data-target="#naoapagar">Apagar</a>';
				} else {
					echo '<a href="" class="btn btn-default" data-toggle="modal" data-target="#apagar">Apagar</a>';
				}
				?>
				<!-- <a href="" data-toggle="modal" data-target="#adicionarhoras" class="btn btn-default">Adicionar horas</a> -->
				<!-- <a href="historico-horas-liberadas.php?id_convenio_paciente=<?php echo $id_convenio_paciente;?>" class="btn btn-default">Histórico de horas liberadas</a> -->
				<a href="<?php echo $id_paciente;?>.log" target="blank" class="btn btn-default">Histórico</a>
			</div>
		</form>
	</div>
</div>
			</div>
    </div>
</div>

<!-- adicionar horas -->
<div class="modal fade" id="adicionarhoras" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="adicionar-horas-2.php" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Adicionar horas</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    <div class="form-group">
                    	<label>Horas:</label>
                    	<input type="number" name="AdicionarHoras" class="form-control" required>
                    </div>
                    <div class="form-group">
                    	<label>Observação:</label>
                    	<textarea rows="3" class="form-control" name="Nota" required></textarea>
                    </div>
                    <div>
                    	<b>Notas</b>:
                    	<li>As <b>horas serão somadas no total</b> de horas liberadas existente.</li>
                    	<li>Digite um valor negativo para correção.</li>
                    </div>
                </div>

                <input type="text" hidden name="id_paciente" value="<?php echo $id_paciente;?>">
                <input type="text" hidden name="id_convenio_paciente" value="<?php echo $id_convenio_paciente;?>">
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>    
        </div>

    </div>
</div>

<!-- apagar -->
<div class="modal fade" id="apagar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="apagar-convenio-paciente-2.php" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Apagar convênio</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    O convênio será apagado. Deseja continuar?
                </div>

                <input type="text" hidden name="id_paciente" value="<?php echo $id_paciente;?>">
                <input type="text" hidden name="id_convenio_paciente" value="<?php echo $id_convenio_paciente;?>">
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-danger">Apagar</button>
                </div>
            </form>    
        </div>

    </div>
</div>

<!-- não apagar -->
<div class="modal fade" id="naoapagar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="f" method="post">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Apagar convênio</h4>
                </div>
                <div class="modal-body" style="background-color: #fafafa;">
                    O convênio não pode ser apagado porque foi utilizado em uma agenda do paciente.<br>
                    Altere o status do convênio para inativo.
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
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