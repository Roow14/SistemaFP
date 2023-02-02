<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';


$FiltroConvenio = NULL;
$FiltroPaciente = NULL;
$FiltroConvenio = 'AND convenio_paciente.id_convenio = 3';
// $FiltroPaciente = 'AND NomeCompleto LIKE "%alice%"';

// input
// $sql = "SELECT COUNT(id_paciente) AS Soma FROM paciente WHERE Status = 1";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
// 	// tem
// 	while($row = $result->fetch_assoc()) {
// 		$Soma = $row['Soma'];
// 		echo $Soma.'<br>';
// 		echo '<br>';
// 	}
// // não tem
// } else {
// }

// buscar xxx
$sql = "SELECT * FROM paciente WHERE Status = 1 $FiltroPaciente ORDER BY NomeCompleto ASC";
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
		// echo $NomeCompleto.'<br>';
		echo '<tr>';
		echo '<td>'.$NomeCompleto.'</td>';

		// buscar xxx
		$sqlA = "SELECT convenio_paciente.*, convenio.NomeConvenio FROM convenio_paciente
		INNER JOIN convenio ON convenio_paciente.id_convenio = convenio.id_convenio
		WHERE convenio_paciente.id_paciente = '$id_paciente' $FiltroConvenio";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_convenio = $rowA['id_convenio'];
				$StatusConvenio = $rowA['StatusConvenio'];
				$NomeConvenio = $rowA['NomeConvenio'];
				// echo '> '.$NomeConvenio.''.$StatusConvenio.'<br>';
				echo '<td>'.$NomeConvenio.'</td>';
				echo '<td>'.$StatusConvenio.'</td>';
		    }
		} else {
			// não tem
		}
		echo '</tr>';
    }
    echo '</tbody>';
	echo '</table>';
} else {
	// não tem
}
?>
