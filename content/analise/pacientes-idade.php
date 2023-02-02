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
if (!empty($_POST['inicio'])) {
	$inicio = $_POST['inicio'];
	$fim = $_POST['fim'];

	if ($inicio > $fim) {
		// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: a data inicial deve ser menor do que a data final.\");
	    window.location = \"pacientes-idade.php\"
	    </script>";
	exit;
	}
	
	$FiltroData = 'AND paciente.DataNascimento BETWEEN "'.$inicio.'" AND "'.$fim.'"';
} else {
	$FiltroData = NULL;
	$inicio = NULL;
	$fim = NULL;
}

if (!empty($_POST['ordem'])) {
	$ordem = $_POST['ordem'];
	if ($ordem == 1) {
		$FiltroOrdem = ' ORDER BY paciente.DataNascimento DESC';
		$nomeordem = 'Idade menor > maior';
	}
	if ($ordem == 2) {
		$FiltroOrdem = ' ORDER BY paciente.DataNascimento ASC';
		$nomeordem = 'Idade maior > menor';
	}

} else {
	$FiltroOrdem = NULL;
	$ordem = NULL;
	$nomeordem = 'Selecionar';
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

// $sql = "SELECT COUNT(id_endereco_paciente) AS Soma FROM endereco_paciente
// INNER JOIN paciente ON paciente.id_paciente = endereco_paciente.id_paciente
// $FiltroStatus $DataInicio $FiltroCidade
// ";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
// 	// tem
// 	while($row = $result->fetch_assoc()) {
// 		$Soma = $row['Soma'];
// 	}
// // não tem
// } else {
// 	$Soma = NULL;
// }
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
	<li class="inactive"><a href="index.php">Pacientes/região</a></li>
	<li class="active"><a href="pacientes-idade.php">Por idade</a></li>
	<li class="inactive"><a href="terapeutas-regiao.php">Terapeutas/região</a></li>
	<li class="inactive"><a href="terapeutas-funcao.php">Terapeutas/função</a></li>
	<li class="inactive"><a href="terapeutas-disponiveis.php">Terapeutas disponíveis</a></li>
	<li class="inactive"><a href="terapeutas-login.php">Terapeutas c/login</a></li>
</ul>

<div class="janela">
<h3>Pacientes por idade</h3>

<form action="" method="post" class="form-inline">

	<div class="form-group">
    	<label>Filtrar por ano de:</label>
        <input type="date" class="form-control" name="inicio" value="<?php echo $inicio;?>">
    </div>

    <div class="form-group">
    	<label>até:</label>
        <input type="date" class="form-control" name="fim" value="<?php echo $fim;?>">
    </div>

    <div class="form-group">
    	<label>Ordenação:</label>
    	<select class="form-control" name="ordem">
    		<option value="<?php echo $ordem;?>"><?php echo $nomeordem;?></option>
    		<option value="1">Idade menor > maior</option>
    		<option value="2">Idade maior > menor</option>
    		<option value="">Limpar</option>
    	</select>
    	
    </div>

	<button type="submit" class="btn btn-success">Confirmar</button>
</form>

<li><label>Total:</label> <?php// echo $Soma;?></li>
	
<?php
// buscar xxx
$sql = "SELECT * FROM paciente
$FiltroStatus $FiltroData $FiltroOrdem
";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Nome</th>';
	echo '<th>Data nascimento</th>';
	echo '<th>Idade</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$NomeCompleto = $row['NomeCompleto'];
		$DataNascimento = $row['DataNascimento'];
		if (!empty($DataNascimento)) {
			$DataNascimento2 = date("d/m/Y", strtotime($DataNascimento));
		} else {
			$DataNascimento2 = NULL;
		}

		if (empty($DataNascimento)) {
			$age = NULL;
			$Idade = NULL;
		} else {
			# procedural
			$age = date_diff(date_create($DataNascimento), date_create('today'))->y;
			if ($age == 1) {
				$Idade = '1 ano';
			} else {
				$Idade = $age.' anos';
			}
		}

		echo '<tr>';
		echo '<td><a href="../paciente/paciente.php?id_paciente='.$id_paciente.'" class="Link" target="blank">'.$NomeCompleto.'</a></td>';
		echo '<td style="width:100px">'.$DataNascimento2.'</td>';
		echo '<td style="width:100px">'.$Idade.'</td>';
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