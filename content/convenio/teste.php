<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// $FiltroSemConvenio = 1;

if (!empty($FiltroSemConvenio)) {
	$FiltroConvenio = NULL;
	$FiltroSemConvenio = 1;
} else {
	$FiltroConvenio = NULL;
	// $FiltroConvenio = 'AND convenio_paciente.id_convenio = 5';
	$FiltroSemConvenio = NULL;
}

// buscar xxx
// $sql = "SELECT * FROM paciente WHERE Status = 1";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
// 		// tem
// 		$id_paciente = $row['id_paciente'];
// 		$NomeCompleto = $row['NomeCompleto'];
// 		// buscar xxx
// 		$sqlA = "SELECT convenio_paciente.* FROM convenio_paciente
// 		INNER JOIN convenio ON convenio.id_convenio = convenio_paciente.id_convenio
// 		WHERE convenio_paciente.id_paciente = '$id_paciente' AND convenio_paciente.StatusConvenio = 1
// 		$FiltroConvenio";
// 		$resultA = $conn->query($sqlA);
// 		if ($resultA->num_rows > 0) {
// 		    while($rowA = $resultA->fetch_assoc()) {
// 				// tem
// 				$id_convenio = $rowA['id_convenio'];
// 				if (empty($FiltroSemConvenio)) {
// 					echo $id_paciente.' - '.$NomeCompleto.' - '.$id_convenio.'<br>';
// 				}
// 		    }
// 		} else {
// 			// não tem
// 			if (empty($FiltroConvenio)) {
// 				echo $id_paciente.' - '.$NomeCompleto.'<br>';
// 			}
			
// 		}

		
//     }
// } else {
// 	// não tem
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

<h2>Convênio médico</h2>

<ul class="nav nav-tabs">
	<!-- <li class="inactive"><a href="index.php">Agenda do dia</a></li>
	<li class="inactive"><a href="relatorio-convenio-paciente.php">Criança</a></li>
	<li class="inactive"><a href="convenio-paciente.php">Convênios da criança</a></li> -->
	<li class="inactive"><a href="listar-convenio.php">Convênios</a></li>
	<li class="active"><a href="teste.php">Convênio/paciente</a></li>
	<!-- <li class="inactive"><a href="listar-paciente-sem-convenio.php">Sem convênio</a></li> -->
	<!-- <li class="inactive"><a href="relatorio-presenca.php">Presença</a></li>
	<li class="inactive"><a href="ajuda.php">Ajuda</a></li> -->
</ul>

<div class="janela">

<?php
// buscar xxx
$sql = "SELECT * FROM paciente WHERE Status = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>ID</th>';
	echo '<th>Nome</th>';
	echo '<th>Convênio</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_paciente = $row['id_paciente'];
		$NomeCompleto = $row['NomeCompleto'];
		// buscar xxx
		$sqlA = "SELECT convenio_paciente.*, convenio.NomeConvenio FROM convenio_paciente
		INNER JOIN convenio ON convenio.id_convenio = convenio_paciente.id_convenio
		WHERE convenio_paciente.id_paciente = '$id_paciente' AND convenio_paciente.StatusConvenio = 1
		$FiltroConvenio";

		echo '<tr>';
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeConvenio = $rowA['NomeConvenio'];
				if (empty($FiltroSemConvenio)) {
					echo '<td>'.$id_paciente.'</td>';
					echo '<td>'.$NomeCompleto.'</td>';
					echo '<td>'.$NomeConvenio.'</td>';
				}
		    }
		} else {
			// não tem
			if (empty($FiltroConvenio)) {
				echo '<td>'.$id_paciente.'</td>';
				echo '<td>'.$NomeCompleto.'</td>';
				echo '<td></td>';
			}
		}		
		echo '</tr>';
    }
    echo '</tbody>';
	echo '</table>';
} else {
	// não tem
}
?>
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