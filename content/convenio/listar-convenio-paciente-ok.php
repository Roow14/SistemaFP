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
if (empty($_SESSION['PesquisaPaciente'])) {
	$PesquisaPaciente = NULL;
	$FiltroPaciente = NULL;
} else {
	$PesquisaPaciente = $_SESSION['PesquisaPaciente'];
	$FiltroPaciente = 'AND paciente.NomeCompleto LIKE "%'.$PesquisaPaciente.'%"';
}

if (empty($_SESSION['id_convenio'])) {
	$id_convenio = NULL;
	$FiltroConvenio = NULL;
	$NomeConvenio = 'Selecionar';
} else {
	$id_convenio = $_SESSION['id_convenio'];
	$FiltroConvenio = 'AND convenio_paciente.id_convenio = '.$id_convenio;
	$sql = "SELECT * FROM convenio WHERE id_convenio = '$id_convenio'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$NomeConvenio = $row['NomeConvenio'];
			$FiltroConvenio = 'AND convenio_paciente.id_convenio = '.$id_convenio;
	    }
	} else {
		// não tem
		$FiltroConvenio = NULL;
	}
}

if (empty($_SESSION['StatusConvenio'])) {
	$StatusConvenio = NULL;
	$NomeStatusConvenio = 'Todos';
	$FiltroStatusConvenio = NULL;
} else {
	$StatusConvenio = $_SESSION['StatusConvenio'];
	$FiltroStatusConvenio = 'AND convenio_paciente.StatusConvenio = '.$StatusConvenio;
	if ($StatusConvenio == 1) {
		$NomeStatusConvenio = 'Ativo';
	} else {
		$NomeStatusConvenio = 'Inativo';
	}

}

// input
$sql = "SELECT COUNT(DISTINCT paciente.id_paciente) AS Soma1 FROM paciente
INNER JOIN convenio_paciente ON convenio_paciente.id_paciente = paciente.id_paciente
WHERE paciente.Status = 1 
$FiltroPaciente 
$FiltroConvenio
$FiltroStatusConvenio
";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// tem
	while($row = $result->fetch_assoc()) {
		$Soma1 = $row['Soma1'];
	}
// não tem
} else {
}

// input
$sql = "SELECT COUNT(paciente.id_paciente) AS Soma FROM convenio_paciente
INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
INNER JOIN paciente ON convenio_paciente.id_paciente = paciente.id_paciente
WHERE paciente.Status = 1 $FiltroPaciente $FiltroConvenio $FiltroStatusConvenio
";
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
	<li class="inactive"><a href="index.php">Agenda do dia</a></li>
	<li class="inactive"><a href="relatorio-convenio-paciente.php">Criança</a></li>
	<li class="inactive"><a href="convenio-paciente.php">Convênios da criança</a></li>
	<li class="inactive"><a href="listar-convenio.php">Convênios</a></li>
	<li class="active"><a href="listar-convenio-paciente.php">Com convênio</a></li>
	<li class="inactive"><a href="listar-paciente-sem-convenio.php">Sem convênio</a></li>
	<li class="inactive"><a href="relatorio-presenca.php">Presença</a></li>
	<li class="inactive"><a href="ajuda.php">Ajuda</a></li>
</ul>

<div class="janela">
<h3>Crianças com convênio associado</h3>
<form action="listar-convenio-paciente-filtro-2.php" method="post" class="form-inline">
	<div class="form-group">
		<label>Filtrar por criança:</label>
		<input type="text" name="PesquisaPaciente" class="form-control" value="<?php echo $PesquisaPaciente;?>" placeholder="Nome">
	</div>

	<div class="form-group">
    	<label>Convênio: </label>
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

    <div class="form-group">
    	<label>Status do convênio: </label>
    	<select class="form-control" name="StatusConvenio">
    		<option value="<?php echo $StatusConvenio;?>"><?php echo $NomeStatusConvenio;?></option>
    		<option value="1">Ativo</option>
    		<option value="2">Inativo</option>
    		<option value="">Todos</option>
    	</select>
    </div>

	<button type="submit" class="btn btn-success">Confirmar</button>
</form>
<li><span style="margin-right: 15px;"><label>Total de itens: </label> <?php echo $Soma;?></span> <label>Total de crianças: </label> <?php echo $Soma1;?></li>

<?php
// buscar xxx
$sql = "SELECT convenio_paciente.*, convenio.NomeConvenio, paciente.NomeCompleto
FROM convenio_paciente
INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
INNER JOIN paciente ON convenio_paciente.id_paciente = paciente.id_paciente
WHERE paciente.Status = 1 $FiltroPaciente $FiltroConvenio $FiltroStatusConvenio
ORDER BY paciente.NomeCompleto ASC
";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Nome</th>';
	echo '<th>Convênio</th>';
	echo '<th>Status</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$NomeCompleto = $row['NomeCompleto'];
		$id_convenio = $row['id_convenio'];
		$StatusConvenio = $row['StatusConvenio'];
		if ($StatusConvenio == 1) {
			$NomeStatusConvenio = 'Ativo';
		} else {
			$NomeStatusConvenio = 'Inativo';
		}
		$NomeConvenio = $row['NomeConvenio'];

		echo '<tr>';
		echo '<td><a href="relatorio-convenio-paciente.php?id_paciente='.$id_paciente.'" class="Link" target="blank">'.$NomeCompleto.'</a></td>';
		echo '<td>'.$NomeConvenio.'</td>';
		echo '<td>'.$NomeStatusConvenio.'</td>';
		echo '</tr>';
    }
    echo '</tbody>';
	echo '</table>';
} else {
	// não tem
	echo 'Não foi encontrado nenhum paciente.';
}
?>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>
