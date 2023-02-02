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
if (!empty($_POST['PesquisaBairro'])) {
	$PesquisaBairro = $_POST['PesquisaBairro'];
	$FiltroBairro = 'AND endereco_paciente.Bairro LIKE "%'.$PesquisaBairro.'%"';
} else {
	$FiltroBairro = NULL;
	$PesquisaBairro = NULL;
}

if (!empty($_POST['PesquisaCidade'])) {
	$PesquisaCidade = $_POST['PesquisaCidade'];
	$FiltroCidade = 'AND endereco_paciente.Cidade LIKE "%'.$PesquisaCidade.'%"';
} else {
	$FiltroCidade = NULL;
	$PesquisaCidade = NULL;
}

// filtro
if (!empty($_POST['StatusPaciente'])) {
	$StatusPaciente = $_POST['StatusPaciente'];
	if ($StatusPaciente == 1) {
		$NomeStatusPaciente = 'Ativo';
		$FiltroStatus = 'WHERE paciente.Status = '. $StatusPaciente;
	} elseif ($StatusPaciente == 3) {
		$NomeStatusPaciente = 'Ativos e inativos';
		$FiltroStatus = 'WHERE (paciente.Status = 1 OR paciente.Status = 2)';
	} else {
		$NomeStatusPaciente = 'Inativo';
		$FiltroStatus = 'WHERE paciente.Status = '. $StatusPaciente;
	}
} else {
	$StatusPaciente = 1;
	$FiltroStatus = 'WHERE paciente.Status = 1';
	$NomeStatusPaciente = 'Ativo';	
}

$sql = "SELECT COUNT(id_endereco_paciente) AS Soma FROM endereco_paciente
INNER JOIN paciente ON paciente.id_paciente = endereco_paciente.id_paciente
$FiltroStatus $FiltroBairro $FiltroCidade
";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// tem
	while($row = $result->fetch_assoc()) {
		$Soma = $row['Soma'];
	}
// não tem
} else {
	$Soma = NULL;
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

<h2>Relatório</h2>

<ul class="nav nav-tabs">
	<li class="active"><a href="index.php">Pacientes/região</a></li>
	<li class="inactive"><a href="pacientes-idade.php">Por idade</a></li>
	<li class="inactive"><a href="terapeutas-regiao.php">Terapeutas/região</a></li>
	<li class="inactive"><a href="terapeutas-funcao.php">Terapeutas/função</a></li>
	<li class="inactive"><a href="terapeutas-disponiveis.php">Terapeutas disponíveis</a></li>
	<li class="inactive"><a href="terapeutas-login.php">Terapeutas c/login</a></li>
</ul>

<div class="janela">
<h3>Pacientes por região</h3>

<form action="" method="post" class="form-inline">

	<div class="form-group">
    	<label>Filtrar por bairro:</label>
        <input type="text" class="form-control" name="PesquisaBairro" value="<?php echo $PesquisaBairro;?>">
    </div>

    <div class="form-group">
    	<label>Município:</label>
        <input type="text" class="form-control" name="PesquisaCidade" value="<?php echo $PesquisaCidade;?>">
    </div>

    <div class="form-group">
    	<label>Status:</label>
		<select name="StatusPaciente" class="form-control">
			<option value="<?php echo $StatusPaciente;?>"><?php echo $NomeStatusPaciente;?></option>
			<option value="1">Ativo</option>
			<option value="2">Inativo</option>
			<option value="3">Todos</option>
		</select>
    </div>

	<button type="submit" class="btn btn-success">Confirmar</button>
</form>

<li><label>Total:</label> <?php echo $Soma;?></li>
	
<?php
// buscar xxx
$sql = "SELECT endereco_paciente.*, paciente.NomeCompleto FROM endereco_paciente
INNER JOIN paciente ON paciente.id_paciente = endereco_paciente.id_paciente
$FiltroStatus $FiltroBairro $FiltroCidade
";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Nome</th>';
	echo '<th>Endereço</th>';
	echo '<th>CEP</th>';
	echo '<th>Bairro</th>';
	echo '<th>Cidade</th>';
	echo '<th>Estado</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$Endereco = $row['Endereco'];
		$Numero = $row['Numero'];
		$Complemento = $row['Complemento'];
		$Cep = $row['Cep'];
		$Bairro = $row['Bairro'];
		$Cidade = $row['Cidade'];
		$Estado = $row['Estado'];
		$NomeCompleto = $row['NomeCompleto'];
		
		if (empty($Complemento)) {
			$Endereco1 = $Endereco.', '.$Numero;
		} else {
			$Endereco1 = $Endereco.', '.$Numero.' - '.$Complemento;
		}

		// buscar xxx
		$sqlA = "SELECT * FROM estado WHERE Estado = '$Estado'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$NomeEstado = $rowA['NomeEstado'];
		    }
		} else {
			$NomeEstado = NULL;
		}

		echo '<tr>';
		echo '<td><a href="../paciente/paciente.php?id_paciente='.$id_paciente.'" class="Link" target="blank">'.$NomeCompleto.'</a></td>';
		echo '<td>'.$Endereco1.'</td>';
		
		echo '<td style="width:100px">'.$Cep.'</td>';
		echo '<td>'.$Bairro.'</td>';
		echo '<td style="width:200px">'.$Cidade.'</td>';
		echo '<td style="width:100px">'.$NomeEstado.'</td>';
		echo '</tr>';
    }
    echo '</tbody>';
	echo '</table>';
} else {
	// não tem
}
?>

<!-- footer -->
<?php include '../footer/footer.php';?>

<!-- jquery -->
<?php include '../../js/jquery-custom.php';?>
</body>
</html>