<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

echo '<a href="configuracao.php">Voltar</a><br>';
echo 'Importar os arquivos da tabela midia_avaliacao para midia: <a href="importar-midia_avaliacao_para_midia.php">Confirmar</a>';

// buscar xxx
$sql = "SELECT * FROM midia_avaliacao ORDER BY ArquivoMidia ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo '<table class="table table-striped table-hover table-condensed">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>id_midia</th>';
	echo '<th>id_paciente</th>';
	echo '<th style="text-align: left">Tabela midia_avaliacao</th>';
	echo '<th>Tabela midia</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
    while($row = $result->fetch_assoc()) {
		// tem
		$id_midia_avaliacao = $row['id_midia_avaliacao'];
		$ArquivoMidia = $row['ArquivoMidia'];
		$id_paciente = $row['id_paciente'];

		echo '<tr>';
		echo '<td>'.$id_midia_avaliacao.'</td>';
		echo '<td>'.$id_paciente.'</td>';
		echo '<td>'.$ArquivoMidia.'</td>';

		// buscar xxx
		$sqlA = "SELECT * FROM midia WHERE ArquivoMidia = '$ArquivoMidia'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				echo '<td>Tem</td>';
		    }
		} else {
			// não tem
			echo '<td>Não tem</td>';
		}

		echo '</tr>';
    }
    echo '</tbody>';
	echo '</table>';
} else {
	// não tem
}
?>